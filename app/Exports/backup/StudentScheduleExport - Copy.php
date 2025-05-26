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

class StudentScheduleExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $schedules;
    protected $studentName;

    public function __construct()
    {
        $user = auth()->user();
        $this->studentName = $user->name;
        $this->schedules = $user->schedules()
            ->with(['subject', 'section', 'room', 'teacher'])
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
            'Teacher',
            'Day',
            'Time',
            'Subject',
            'Section',
            'Room',
        ];
    }

    public function map($schedule): array
    {
        return [
            $schedule->teacher->name ?? 'N/A',
            ucfirst($schedule->day),
            \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') . ' - ' .
                \Carbon\Carbon::parse($schedule->end_time)->format('h:i A'),
            $schedule->subject->subject_name ?? 'N/A',
            $schedule->section->section_level ?? 'N/A',
            $schedule->room->room_number ?? 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set title row
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'STUDENT SCHEDULE: ' . strtoupper($this->studentName));
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Write headers
        $sheet->fromArray($this->headings(), null, 'A2');

        // Write data rows
        $row = 3; // Start from row 3 (row 1 is title, row 2 is headers)
        foreach ($this->schedules as $schedule) {
            $sheet->fromArray($this->map($schedule), null, "A{$row}");
            $row++;
        }

        // Header style
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3490dc'], // Blue header
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A2:F2')->applyFromArray($headerStyle);

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
        $lastRow = count($this->schedules) + 2;
        $sheet->getStyle("A3:F{$lastRow}")->applyFromArray($dataStyle);

        // Alternate row coloring
        for ($i = 3; $i <= $lastRow; $i++) {
            $fillColor = $i % 2 == 0 ? 'f8f9fa' : 'ffffff'; // Light gray and white alternation
            $sheet->getStyle("A{$i}:F{$i}")
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB($fillColor);
        }

        // Column specific formatting
        $sheet->getStyle("C3:C{$lastRow}")->getAlignment()->setHorizontal('right');
        $sheet->getStyle("A3:F{$lastRow}")->getAlignment()->setVertical('center');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(25); // Teacher
        $sheet->getColumnDimension('B')->setWidth(15); // Day
        $sheet->getColumnDimension('C')->setWidth(20); // Time
        $sheet->getColumnDimension('D')->setWidth(30); // Subject
        $sheet->getColumnDimension('E')->setWidth(15); // Section
        $sheet->getColumnDimension('F')->setWidth(15); // Room

        return [];
    }

    public function title(): string
    {
        return 'My Schedule';
    }
}
