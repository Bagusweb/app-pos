@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="card-title">Laporan Transaction Periode</h5>
            </div>
            <div class="card-body">
                <label for="" class="form-title">Please Select Date</label>

                <div class="d-flex align-items-center gap-2 mb-3">
                    <!-- Form untuk Filter -->
                    <form action="{{ route('report.filter') }}" method="GET" class="d-flex">
                        <input type="text" id="date_range" name="date_range" class="form-control"
                            placeholder="Select date range" value="{{ request('date_range') }}">
                        <button class="btn btn-secondary ms-2" type="submit">Filter</button>
                        <button class="btn btn-danger ms-2" type="button" id="resetButton">Reset</button>

                    </form>

                    <!-- Form untuk Print -->
                    <form action="{{ route('report.generate') }}" method="POST" class="d-inline" target="_blank">
                        {{ csrf_field() }}
                        <input type="hidden" name="start_date" id="start_date">
                        <input type="hidden" name="end_date" id="end_date">
                        <button type="submit" target="_blank" class="btn btn-dark ms-2">Print</button>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Transaction Id</th>
                                <th>Customer</th>
                                <th>Total Belanja</th>
                                <th>Total Pembayaran</th>
                                <th>Kasir</th>
                                <th>Status</th>
                                <th>Tanggal Transaction</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->transaction_id }}</td>
                                <td>{{ $transaction->customer->customer_name ?? 'Guest' }}</td>
                                <td>Rp. {{ number_format($transaction->total_amount, 2) }}</td>
                                <td>Rp. {{ number_format($transaction->payment->amount ?? 0, 2) }}</td>
                                <td>{{ $transaction->users->name }}</td>
                                <td>{{ ucfirst($transaction->status) }}</td>
                                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                            </tr>
                            @php $grandTotal += $transaction->total_amount; @endphp
                            @empty
                            <tr>
                                <td colspan="8" align="center">Empty</td>
                            </tr>

                            @endforelse
                        </tbody>
                        <tfoot style="font-weight: bold;">
                            <tr>
                                <td colspan="3" style="text-align: center;">Total Keseluruhan</td>
                                <td colspan="7">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection