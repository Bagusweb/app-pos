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
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th><a href="{{route('user.create')}}" class="btn btn-primary btn-sm">Create User</a></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataUser as $v)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $v->name }}</td>
            <td>{{ $v->email }}</td>
            <td>{{ $v->role }}</td>
            <td>
                <form action="{{route('user.destroy', $v->user_id)}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE" />
                    <a href="{{route('user.edit',$v->user_id)}}" class="btn btn-success btn-sm" >Edit</a>
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