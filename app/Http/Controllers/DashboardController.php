<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customers;
use App\Products;
use App\Transactions;
use App\Users;
use App\Categories;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admindashboard()
    {
        $countproduct = Products::all()->count();//menhitung seluruh data
        //count fungsinya untuk menhitung
        $countuser = Users::all()->count();
        $countcustomer = Customers::all()->count();
        $conttotal = Transactions::sum('total_amount');
        //karna kita hanya menghitung total pembelajaan yg sudah si proses makanaya pake total_amount

        //perbulan
        $transactions = Transactions::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')->groupBy('month')->whereYear('created_at', Carbon::now()->year)->orderBy('month')->get();
        $months = [];
        $totals = [];

        //loop untuk mempersiapkan bulan dan total transaksi
        foreach ($transactions as $transaction) {
            $months[] = Carbon::create()->month($transaction->month)->format('F');
            $totals[] = $transaction->total;
        }

        //pertahun
        $transactions_year = Transactions::selectRaw('YEAR(created_at) as year, SUM(total_amount) as totalyear')->groupBy('year')->orderBy('year')->get();
        $years = [];
        $totalyear = [];

        //loop untuk mempersiapkan bulan dan total transaksi
        foreach ($transactions_year as $v) {
            $years[] = $v->year;
            $totalyear[] = $v->totalyear;
        }

        return view('dashboard.admin', compact('countproduct', 'countuser', 'countcustomer', 'conttotal', 'months', 'totals', 'years', 'totalyear'));
    }

    public function cashierdashboard()
    {
        $countproduct = Products::all()->count();//menhitung seluruh data
        //count fungsinya untuk menhitung
        $countuser = Users::all()->count();
        $countcustomer = Customers::all()->count();
        $conttotal = Transactions::sum('total_amount');
        $countcategory = Categories::all()->count();
        //karna kita hanya menghitung total pembelajaan yg sudah si proses makanaya pake total_amount
        //perbulan
        $transactions = Transactions::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')->groupBy('month')->whereYear('created_at', Carbon::now()->year)->orderBy('month')->get();
        $months = [];
        $totals = [];

        //loop untuk mempersiapkan bulan dan total transaksi
        foreach ($transactions as $transaction) {
            $months[] = Carbon::create()->month($transaction->month)->format('F');
            $totals[] = $transaction->total;
        }

        //pertahun
        $transactions_year = Transactions::selectRaw('YEAR(created_at) as year, SUM(total_amount) as totalyear')->groupBy('year')->orderBy('year')->get();
        $years = [];
        $totalyear = [];

        //loop untuk mempersiapkan bulan dan total transaksi
        foreach ($transactions_year as $v) {
            $years[] = $v->year;
            $totalyear[] = $v->totalyear;
        }
        return view('dashboard.cashier', compact('countproduct', 'countuser', 'countcustomer', 'conttotal','countcategory','months', 'totals', 'years', 'totalyear'));
    }
}

