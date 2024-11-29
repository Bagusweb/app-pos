<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transactions;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $startDate = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $endDate = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        $transactions = Transactions::with('details.product', 'customer', 'payment', 'users')->get();

        return view('report.index', compact('transactions', 'startDate', 'endDate'));
    }

    public function filter(Request $request)
    {
        $dateRange = $request->input('date_range');
        $date = explode(' - ', $dateRange);

        $startDate = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $endDate = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';

        $transactions = Transactions::with('details.product', 'customer', 'payment', 'users')
            ->whereBetween('created_at', [$startDate, $endDate])->get();

        return view('report.index', compact('transactions', 'startDate', 'endDate'));
    }

    public function generatePDF(Request $request)
    {
        $startDate = $request->input('start_date') . ' 00:00:00'; // Start of the selected day
        $endDate = $request->input('end_date') . ' 23:59:59'; // End of the selected day

        $tanggalBulanTahunawal = date("d-m-Y", strtotime($startDate));
        $tanggalBulanTahunakhir = date("d-m-Y", strtotime($endDate));

        $transaction = Transactions::with('details.product', 'customer', 'payment', 'users')
            ->whereBetween('created_at', [$startDate, $endDate])->get();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);

        $dompdf->setPaper('A4', 'landscape');
        $html = view('report.transactionpdf', compact(
            'transaction', 'tanggalBulanTahunawal', 'tanggalBulanTahunakhir'
            ))->render();
        
        $dompdf->loadHtml($html);
        $dompdf->render();
        $namaFile = 'LaporanTransaksiPeriode_' . $tanggalBulanTahunawal . '_' . $tanggalBulanTahunakhir . '.pdf';

        return $dompdf->stream($namaFile); // Inline display
    }

    public function generatePDFByTransactionId($id)
    {
        $transaction = Transactions::with('details.product', 'customer', 'payment', 'users')
            ->findOrFail($id);
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Courier');

        $dompdf = new Dompdf($options);
        $dompdf->setPaper([0, 0, 226.77, 800], 'portrait');
        $html = view('report.transaction_receipt', compact('transaction'))->render();
        $dompdf->loadHtml($html);

        $dompdf->render();
        $namaFile = "Struk_Transaksi_$id.pdf";
        return $dompdf->stream($namaFile);
    }
}