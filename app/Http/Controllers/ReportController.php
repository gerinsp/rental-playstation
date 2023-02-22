<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use PDF;

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

        $transaksi = Transaction::whereBetween('created_at', [$starDate, $endDate])->get();
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
}
