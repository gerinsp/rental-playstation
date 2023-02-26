<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class ReportController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'title' => 'Laporan',
            'active' => 'report',

        ]);
    }

    public function generatePDF(Request $request)
    {
        $starDate = $request->input('tanggal_awal');
        $endDate = $request->input('tanggal_akhir');

        $transaksi = Transaction::whereBetween('created_at', [$starDate, $endDate])->where('status_transaksi', 'sukses')->get();
        $total = $transaksi->sum('total');
        $pdf = PDF::loadView('laporan.cetak-pdf', [
            'title' => 'Laporan Transaksi',
            'active' => 'report',
            'transactions' => $transaksi,
            'starDate' => $starDate,
            'endDate' => $endDate,
            'total' => $total
        ]);
        return $pdf->download('laporan.pdf');
    }

    public function generateExcel(Request $request)
    {
        $startDate = $request->input('tanggal_awal');
        $endDate = $request->input('tanggal_akhir');

        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status_transaksi', 'sukses')
            ->get();
        $total = $transactions->sum('total');
        // Membuat file Excel dengan menggunakan library "Maatwebsite\Excel"
        $excel = Excel::download(new TransactionsExport($transactions, $startDate, $endDate, $total), 'laporan.xlsx');

        // Mengembalikan file Excel dalam bentuk response
        return $excel;
    }
}
