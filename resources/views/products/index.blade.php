@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
               <h3 class="card-title">Data Products</h3>
            </div>
            <div class="card-body table-responsive">
<table id="example1" class="table table-hover text-wrap">
    <thead>
        <tr>
            <th>No</th>
            <th>Product Name</th>
            <th>Photo</th>
            <th>Category</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
            <th>
                <a href="{{route('product.create')}}" class="btn btn-primary btn-sm">Create Products</a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataProducts as $v)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $v->product_name }}</td>
            <td>
                @if($v->photo)
                <img src="{{ asset('storage/' . $v->photo) }}" alt="{{ $v->product_name }}" width="100">
                @else
                <img src="https://via.placeholder.com/100" alt="No Image" width="100">
                @endif
            </td>
            <td>{{ $v->Categories->category_name }}</td>
            <td>{{ $v->product_description }}</td>
            <td>{{ $v->price }}</td>
            <td>{{ $v->stock }}</td>
            <td>
                
                <form action="{{ route('product.destroy', $v->product_id) }}" method="POST">
                    <input type="hidden" name="_method" value="delete" />
                    {{ csrf_field() }}
                    <a href="{{ route('product.edit', $v->product_id) }}" class="btn btn-success btn-sm">Edit</a>
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