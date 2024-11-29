<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transactions;
use App\TransactionDetails;
use App\Payments;
use App\Products;
use App\Customers;
use App\Users;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Menampilkan daftar transaksi
        $transactions = Transactions::with(
            'details.product', 
            'customer', 
            'payment', 
            'users')->orderBy('transaction_id', 'DESC')->get();
       
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $customers = Customers::all(); // Ambil daftar pelanggan
        $products = Products::where('stock', '>', 0)->get(); // Ambil daftar barang

        return view('transactions.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'customer_id' => 'nullable|exists:tbl_customers,customer_id',
            'payment_method' => 'required|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:tbl_products,product_id',
            'products.*.qty' => 'required|integer|min:1',
            'payment' => 'required|numeric|min:0',
        ]);

        // Ambil data customer
        $customer = Customers::find($request->customer_id);

        // Inisialisasi variabel untuk total harga
        $totalAmount = 0;

        // Loop melalui produk yang dipilih dan hitung total harga
        $products = [];
        foreach ($request->products as $productData) {
            $product = Products::find($productData['product_id']);
            $totalAmount += $product->price * $productData['qty'];

            // Simpan produk beserta kuantitas untuk TransactionDetails
            $products[] = [
                'product_id' => $product->product_id,
                'quantity' => $productData['qty'],
                'price' => $product->price,
                'total' => $product->price * $productData['qty'],
            ];
        }

        // Hitung total setelah diskon
        $totalAfterDiscount = $totalAmount - $request->discount;

        // Simpan data transaksi ke tabel 'transactions'
        $transaction = Transactions::create([
            'customer_id'       => $request->customer_id,
            'user_id'           => Auth::id(),  // ID user yang melakukan transaksi
            'total_amount'      => $totalAfterDiscount,
            'discount'          => $request->discount,
            'payment_method'    => $request->payment_method,
            'payment'           => $request->payment,
            'change'            => $request->change,
            'status'            => "completed"
        ]);

        // Simpan detail transaksi ke tabel 'transaction_details'
        foreach ($products as $product) {
            TransactionDetails::create([
                'transaction_id' => $transaction->transaction_id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total' => $product['total'],
            ]);

            // Update stok produk (kurangi stok berdasarkan jumlah yang dibeli)
            $productModel = Products::find($product['product_id']);
            $productModel->stock -= $product['quantity'];
            $productModel->save();
        }

        // Simpan data pembayaran ke tabel 'payments'
        Payments::create([
            'transaction_id' => $transaction->transaction_id,
            'payment_method' => $request->payment_method,
            'amount'         => $request->payment,
            'change'         => $request->change,
            'payment_date'   => today(),
            'user_id'       => Auth::id(),  // ID user yang menerima pembayaran
        ]);

        // Redirect atau kirim respons sukses
        return redirect()->route('transaction.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transactions::with('details.product', 'customer', 'payment', 'users')->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transactions::where('transaction_id', $id)->delete();
        return redirect(route('transaction.index'));
    }
}