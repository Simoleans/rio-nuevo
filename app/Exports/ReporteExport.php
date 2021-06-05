<?php

namespace App\Exports;

use App\Models\Reporte;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;



class ReporteExport implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        return view('reporte.excel', [
            'reportes' => Reporte::all()

        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                // Todo el diseño del header
                $cellRange         = 'A2:M3'; //datos
                $cellRangeAll = 'A1:M1'; // header table estacion

                $styleArrayAll = [ //encabezado
                    'font'      => [
                        'bold' => true,
                    ],
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
                        'rotation'   => 90,
                        'startColor' => [
                            'argb' => 'FFE699',
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
                            'argb' => '24782c',
                        ],

                    ],

                ];
                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRangeAll)->applyFromArray($styleArrayAll)->getFont()->setSize(12);
                $event->sheet->getTabColor()->setRGB('FF0000');

                //fin header

            },

        ];
    }
}
