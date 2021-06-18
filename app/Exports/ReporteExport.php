<?php

namespace App\Exports;

use App\Models\Reporte;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;



class ReporteExport implements FromView, ShouldAutoSize, WithEvents,WithDrawings
{
    protected $query;
    protected $temporada;

    public function __construct($query,$temporada)
    {
        $this->query = $query;
        $this->temporada = $temporada;
    }
    public function view(): View
    {
        
        return view('reporte.excel', [
            'reportes' => $this->query,
            'temporada' => $this->temporada->nombre

        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $c = count($this->query) + 6;
                
                $cellRange = 'A6:X'.$c;
                $cellRangeAll = 'A6:S6'; // header table
                $cellRed = 'T6:X6';

                $styleArrayAll = [ //encabezado
                    'font'      => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],

                    'borders'   => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color'       => ['argb' => '000000'],
                        ],
                    ],
                    'fill'      => [
                        'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation'   => 90,
                        'startColor' => [
                            'argb' => 'FFE699',
                        ],
                    ],
                ];

                $styleArrayRed = [ //encabezado
                    'font'      => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],

                    'borders'   => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color'       => ['argb' => '000000'],
                        ],
                    ],
                    'fill'      => [
                        'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation'   => 90,
                        'startColor' => [
                            'argb' => 'E72F15',
                        ],
                    ],
                ];

                $styleArray = [ // los datos
                    // 'font'      => [
                    //     'bold' => true,
                    // ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders'   => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color'       => ['argb' => '000000'],
                        ],
                    ],
                    'fill'      => [
                        'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation'   => 10,
                        'startColor' => [
                            'argb' => '569E43',
                        ],

                    ],

                ];

                $event->sheet->getDefaultColumnDimension('A:6')->setWidth(42);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray)->getFont()->setSize(12);
                $event->sheet->getHeaderFooter()
                    ->setOddHeader('¡Reportes RIO NUEVO!');
                $event->sheet->getHeaderFooter()
                    ->setOddFooter('&L&B' . $event->sheet->getTitle() . '&Pagína &P of &N');
                
                $event->sheet->getDelegate()->getStyle($cellRangeAll)->applyFromArray($styleArrayAll)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRed)->applyFromArray($styleArrayRed)->getFont()->setSize(12);
                $event->sheet->getTabColor()->setRGB('FF0000');
                $event->sheet->setTitle('Reportes');

            },

        ];
    }

    public function drawings(){
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Rio nuevo');
                $drawing->setPath(public_path('img\logo.jpg'));
                $drawing->setHeight(90);
                $drawing->setCoordinates('A1');

                return $drawing;
    }
}
