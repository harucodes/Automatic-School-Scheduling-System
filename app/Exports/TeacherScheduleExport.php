<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class TeacherScheduleExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle//, ShouldAutoSize
{
    protected $schedules;
    protected $teacherName;

    public function __construct()
    {
        $user = auth()->user();
        $this->teacherName = $user->name;
        $this->schedules = $user->teacherSchedules()
            ->with(['subject', 'section', 'room'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
    }

    public function collection()
    {
        return $this->schedules;
    }

    public function headings(): array
    {
        return [
            'Day',
            'Time',
            'Subject',
            'Section',
            'Room',
            'Students Count',
        ];
    }

    public function map($schedule): array
    {
        return [
            ucfirst($schedule->day),
            \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') . ' - ' .
                \Carbon\Carbon::parse($schedule->end_time)->format('h:i A'),
            $schedule->subject->subject_name ?? 'N/A',
            $schedule->section->section_level ?? 'N/A',
            $schedule->room->room_number ?? 'N/A',
            $schedule->students->count(),
        ];
    }

    public function styles(Worksheet $sheet)
    {

        // Column Width
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setWidth(15);
        }

        // Title row
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'TEACHER SCHEDULE: ' . strtoupper($this->teacherName));
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Insert logo in A2 (1 inch ~ 72 pixels height)
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('School Logo');
        $drawing->setPath(public_path('assets/img/logo.png'));
        $drawing->setHeight(95);  // 72 pixels ~ 1 inch
        $drawing->setCoordinates('A2');
        $drawing->setWorksheet($sheet);

        // SCHOOL INFO rows 2-5
        $sheet->mergeCells('B2:D2');
        $sheet->setCellValue('B2', 'DON HONORIO VENTURA STATE UNIVERSITY');
        $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(14);

        $sheet->mergeCells('B3:D3');
        $sheet->setCellValue('B3', 'Cabambangan, Villa de Bacolor, Pampanga, Philippines');

        $sheet->mergeCells('B4:C4');
        $sheet->setCellValue('B4', 'Tel. No. (6345)458 0021 Local 211');

        $sheet->mergeCells('B5:C5');
        $sheet->setCellValue('B5', 'https://dhvsu.edu.ph');
        $sheet->getCell('B5')->getHyperlink()->setUrl('https://dhvsu.edu.ph');
        $sheet->getStyle('B5')->getFont()->getColor()->setRGB('0000FF');
        $sheet->getStyle('B5')->getFont()->setUnderline(true);

        $sheet->mergeCells('E4:F4');
        $sheet->setCellValue('E4', 'COLLEGE OF BUSINESS STUDIES');
        $sheet->getStyle('E4')->getFont()->setBold(true);
        $sheet->getStyle('E4')->getFont()->setSize(11);
        // Make sure text is uppercase (manually)
        $sheet->setCellValue('E4', strtoupper($sheet->getCell('E4')->getValue()));

        $sheet->mergeCells('E5:F5');
        $sheet->setCellValue('E5', 'DHVSU Main campus, Villa de Bacolor, Pampanga');

        // Add checkbox at A9 with label "CLASS PROGRAM" at B9
        // Simulate checkbox with Unicode empty checkbox symbol in A9
        $sheet->setCellValue('A9', '☐ CLASS PROGRAM');
        $sheet->getStyle('A9')->getFont()->setBold(true);
        $sheet->getRowDimension(9)->setRowHeight(20);

        // Add checkbox at C9 with label "ROOM PROGRAM" at B9
        $sheet->setCellValue('C9', '☐ ROOM PROGRAM');
        $sheet->getStyle('C9')->getFont()->setBold(true);
        $sheet->getRowDimension(9)->setRowHeight(20);

        // Add checkbox at E9 with label "INSTRUCTORS PROGRAM" at B9
        $sheet->setCellValue('E9', '☐ INSTRUCTORS PROGRAM');
        $sheet->getStyle('E9')->getFont()->setBold(true);
        $sheet->getRowDimension(9)->setRowHeight(20);


        // Rows 11, 12, 13: Labels in column A
        $sheet->setCellValue('A11', 'School Year');
        $sheet->setCellValue('A12', 'Semester');
        $sheet->setCellValue('A13', 'CLASS');

        // Merge cells B11:C11, B12:C12, B13:C13 with bottom border
        $sheet->mergeCells('B11:C11');
        $sheet->mergeCells('B12:C12');
        $sheet->mergeCells('B13:C13');

        $borderStyle = [
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('B11:C11')->applyFromArray($borderStyle);
        $sheet->getStyle('B12:C12')->applyFromArray($borderStyle);
        $sheet->getStyle('B13:C13')->applyFromArray($borderStyle);

        // Center and bold text for B11:C13
        $sheet->getStyle('B11:C13')->getFont()->setBold(true);
        $sheet->getStyle('B11:C13')->getAlignment()->setHorizontal('center');

        // Populate values for School Year, Semester, Class (section)
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Filipino School year: 1st Semester Jan-June, 2nd Semester July-Dec
        $semester = ($currentMonth >= 1 && $currentMonth <= 6) ? 'First' : 'Second';

        $sheet->setCellValue('B11', $currentYear);
        $sheet->setCellValue('B12', $semester);
        $sheet->setCellValue('B13', $this->schedules->first()->section->section_level ?? 'N/A');

        // Write headers (now at row 15)
        $sheet->fromArray($this->headings(), null, 'A15');

        // Header style
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '9b1a1a'], // Maroon header
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A15:F15')->applyFromArray($headerStyle);

        // Write data rows starting at row 16
        $row = 16;
        foreach ($this->schedules as $schedule) {
            $sheet->fromArray($this->map($schedule), null, "A{$row}");
            $row++;
        }
        $lastRow = $row - 1;

        // Data rows style
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD'],
                ],
            ],
            'font' => [
                'name' => 'Arial',
                'size' => 11,
            ],
        ];
        $sheet->getStyle("A16:F{$lastRow}")->applyFromArray($dataStyle);

        // Alternate row coloring
        for ($i = 16; $i <= $lastRow; $i++) {
            $fillColor = $i % 2 == 0 ? 'f8f9fa' : 'ffffff'; // Light gray and white alternation
            $sheet->getStyle("A{$i}:F{$i}")
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB($fillColor);
        }

        // Column specific formatting
        $sheet->getStyle("A16:A{$lastRow}")->getAlignment()->setHorizontal('right'); // Time column
        $sheet->getStyle("A15:F{$lastRow}")->getAlignment()->setVertical('center');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(18); // Time
        $sheet->getColumnDimension('B')->setWidth(18); // Teacher
        $sheet->getColumnDimension('C')->setWidth(18); // Day
        $sheet->getColumnDimension('D')->setWidth(18); // Subject
        $sheet->getColumnDimension('E')->setWidth(18); // Section
        $sheet->getColumnDimension('F')->setWidth(18); // Room

        // ----- Footer section (Row 42 and below) -----
        // Prepared by
        $sheet->mergeCells('A42:B42');
        $sheet->setCellValue('A42', 'Prepared by:');
        $sheet->getStyle('A42:B42')->getFont()->setBold(false);
        $sheet->getStyle('A42:B42')->getAlignment()->setHorizontal('left');

        $sheet->mergeCells('A44:B44');
        $sheet->setCellValue('A44', 'MARIA LIBERTY F. ISIP, MBA');
        $sheet->getStyle('A44:B44')->getFont()->setBold(true);
        $sheet->getStyle('A44:B44')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A44:B44')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

        $sheet->mergeCells('A45:B45');
        $sheet->setCellValue('A45', 'Programmer');
        $sheet->getStyle('A45:B45')->getFont()->setBold(false);
        $sheet->getStyle('A45:B45')->getAlignment()->setHorizontal('center');

        // Leave row 46 blank (no action needed)

        // Noted by (starting at row 47)
        $sheet->mergeCells('A48:B48');
        $sheet->setCellValue('A48', 'Noted by:');
        $sheet->getStyle('A48:B48')->getFont()->setBold(false);
        $sheet->getStyle('A48:B48')->getAlignment()->setHorizontal('left');

        $sheet->mergeCells('A50:B50');
        $sheet->setCellValue('A50', 'LUISITO B. REYES, CBA, MBA');
        $sheet->getStyle('A50:B50')->getFont()->setBold(true);
        $sheet->getStyle('A50:B50')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A50:B50')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

        $sheet->mergeCells('A51:B51');
        $sheet->setCellValue('A51', 'Dean, CBS');
        $sheet->getStyle('A51:B51')->getFont()->setBold(false);
        $sheet->getStyle('A51:B51')->getAlignment()->setHorizontal('center');

        // Leave row 52 blank

        // Recommending Approval (starting at row 54)
        $sheet->mergeCells('A54:B54');
        $sheet->setCellValue('A54', 'Recommending Approval:');
        $sheet->getStyle('A54:B54')->getFont()->setBold(false);
        $sheet->getStyle('A54:B54')->getAlignment()->setHorizontal('left');

        $sheet->mergeCells('A56:B56');
        $sheet->setCellValue('A56', 'REDEN M. HERNANDEZ, RCE, MM');
        $sheet->getStyle('A56:B56')->getFont()->setBold(true);
        $sheet->getStyle('A56:B56')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A56:B56')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

        $sheet->mergeCells('A57:B57');
        $sheet->setCellValue('A57', 'Vice President for Academic Affairs');
        $sheet->getStyle('A57:B57')->getFont()->setBold(false);
        $sheet->getStyle('A57:B57')->getAlignment()->setHorizontal('center');

        // Leave row 57 blank

        // Course complete (starting at row 54 on right side)
        $sheet->mergeCells('E54:F54');
        $sheet->setCellValue('E54', 'Course complete:');
        $sheet->getStyle('E54:F54')->getFont()->setBold(false);
        $sheet->getStyle('E54:F54')->getAlignment()->setHorizontal('left');

        // NAME in bold, with bottom border
        $sheet->mergeCells('E56:F56');
        $sheet->setCellValue('E56', 'DOLORES D. MALLARI, Ph.D.');
        $sheet->getStyle('E56:F56')->getFont()->setBold(true);
        $sheet->getStyle('E56:F56')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('E56:F56')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

        // University Registrar
        $sheet->mergeCells('E57:F57');
        $sheet->setCellValue('E57', 'University Registrar');
        $sheet->getStyle('E57:F57')->getFont()->setBold(false);
        $sheet->getStyle('E57:F57')->getAlignment()->setHorizontal('center');


        // Approved block starting at row 60
        $sheet->mergeCells('B60:E60');
        $sheet->setCellValue('B60', 'Approved');
        $sheet->getStyle('B60')->getFont()->setBold(false);
        $sheet->getStyle('B60')->getAlignment()->setHorizontal('center')->setVertical('center');

        // NAME (bold, underline) merged from B to E
        $sheet->mergeCells('B61:E61');
        $sheet->setCellValue('B61', 'ENRIQUE G. BAKING, Ed.D.');
        $sheet->getStyle('B61')->getFont()->setBold(true);
        $sheet->getStyle('B61')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B61:E61')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);


        // SUC President III (merged B to E)
        $sheet->mergeCells('B62:E62');
        $sheet->setCellValue('B62', 'SUC President III');
        $sheet->getStyle('B62')->getFont()->setBold(false);
        $sheet->getStyle('B62')->getAlignment()->setHorizontal('center')->setVertical('center');


        // NOTE in merged A64:F65
        $sheet->mergeCells('A64:F65');
        $sheet->setCellValue('A64', 'NOTE: NO CHANGES IN SCHEDULE SHALL BE MADE UNLESS APPROVED BY THE VPAA');
        $sheet->getStyle('A64')->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);

        // ----- Column WIDTH -----

        // Copy column A's width onto column F
        //$sheet->getColumnDimension('F')->setWidth($sheet->getColumnDimension('A')->getWidth());


        return [];
    }

    public function title(): string
    {
        return 'Teaching Schedule';
    }
}
