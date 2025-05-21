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

class TeacherScheduleExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
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
        // Set title row
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'TEACHER SCHEDULE: ' . strtoupper($this->teacherName));
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Write headers
        $sheet->fromArray($this->headings(), null, 'A2');

        // Write data rows
        $row = 3;
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
                'startColor' => ['rgb' => '4CAF50'], // Green header
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
            $fillColor = $i % 2 == 0 ? 'f8f9fa' : 'ffffff';
            $sheet->getStyle("A{$i}:F{$i}")
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB($fillColor);
        }

        // Column specific formatting
        $sheet->getStyle("B3:B{$lastRow}")->getAlignment()->setHorizontal('right');
        $sheet->getStyle("A3:F{$lastRow}")->getAlignment()->setVertical('center');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(15); // Day
        $sheet->getColumnDimension('B')->setWidth(20); // Time
        $sheet->getColumnDimension('C')->setWidth(30); // Subject
        $sheet->getColumnDimension('D')->setWidth(15); // Section
        $sheet->getColumnDimension('E')->setWidth(15); // Room
        $sheet->getColumnDimension('F')->setWidth(15); // Students Count

        return [];
    }

    public function title(): string
    {
        return 'Teaching Schedule';
    }
}
