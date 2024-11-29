@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
               <h3 class="card-title">Data Customers</h3>
            </div>
            <div class="card-body table-responsive">
<table id="example1" class="table table-hover text-wrap">
    <thead>
        <tr>
            <th>No</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Member Status</th>
            <th>
                <a href="{{route('customer.create')}}" class="btn btn-primary btn-sm">Create Customer</a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $dataCustomers as $v)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $v->customer_name }}</td>
            <td>{{ $v->email }}</td>
            <td>{{ $v->phone}}</td>
            <td>{{ $v->address}}</td>
            <td>{{ ($v->member_status) ? "Yes" : "No"}}</td>
            <td>
                <form action="{{route('customer.destroy', $v->customer_id)}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="{{route('customer.edit',$v->customer_id)}}" class="btn btn-success btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>
</div>
@endsection
