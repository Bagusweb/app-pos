@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Categories</h3>
            </div>
            <div class="card-body table-responsive">
<table id="example1" class="table table-hover text-wrap">
    <thead>
        <tr>
            <th>No</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>
                <a href="{{route('category.create')}}" class="btn btn-primary btn-sm">Create Category</a>
            </th>
        </tr>
    </thead>
    <tbody>

        @foreach ( $dataCategory as $v)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $v->category_name }}</td>
                <td>{{ $v->description }}</td>
                <td>
                    <form action="{{route('category.destroy', $v->category_id)}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <a href="{{route('category.edit',$v->category_id)}}" class="btn btn-success btn-sm">Edit</a>
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
