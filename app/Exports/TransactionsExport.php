<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromView, ShouldAutoSize, WithHeadings, WithStyles
{
    protected $transactions;
    protected $startDate;
    protected $endDate;
    protected $total;

    public function __construct($transactions, $startDate, $endDate, $total)
    {
        $this->transactions = $transactions;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->total = $total;
    }

    public function view(): View
    {
        return view('laporan.cetak-excel', [
            'transactions' => $this->transactions,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'total' => $this->total,
        ]);
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Nama',
            'Jenis Transaksi',
            'Nama Perangkat',
            'Jenis Playstation',
            'Lama Waktu',
            'Harga Total',
            'Tanggal Transaksi',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $sheet->getHighestRow();

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        for ($row = 4; $row <= $rowCount; $row++) {
            $sheet->getStyle('A' . $row . ':A' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('B' . $row . ':B' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('C' . $row . ':C' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('D' . $row . ':D' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('E' . $row . ':E' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('F' . $row . ':F' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('G' . $row . ':G' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('H' . $row . ':H' . $row)->applyFromArray($styleArray);
        }
    }
}
