@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success">
            <h3 class="card-title">form Edit user</h3>
            </div>
            <form action="{{route('user.update',$dataEdituser->user_id)}}" method="POST">
    {{ csrf_field() }}
            <div class="card-body">
           <div class="form-group">
            <label for="name" class="form-label">Name :</label>
            <input type="hidden" name="_method" value="PUT" />
   <input type="text" name="name"  class="form-control" value="{{$dataEdituser->name}}">
    @if ($errors->has('name'))
    <span class="text-danger">{{ $errors->first('name') }}</span>
    @endif
           </div>
           <div class="form-group">
           <label for="email" class="form-label">Email :</label>
           <input type="email" class="form-control" name="email" value="{{$dataEdituser->email}}">
    @if ($errors->has('email'))
    <span class="text-danger">{{ $errors->first('email') }}</span>
    @endif
           </div>
           <div class="form-group">
            <label for="password" class="form-label">password :</label>
            <input type="password" class="form-control" name="password" value="">
           
           <div class="form-group">
            <label for="role" class="form-label">Role :</label>
            <div class="form-check">
            <input type="radio" name="role" value="Admin" {{ ($dataEdituser->role=="Admin")? "checked" : "" }}>
            <label for="role" class="form-chack-label">Admin</label>
            </div>
            <div class="form-check">
            <input type="radio" name="role" value="Cashier" {{ ($dataEdituser->role=="Cashier")? "checked" : "" }}>
            <label for="role" class="form-chack-label">Cashier</label>
    </div>
    </div>
    </div>
           </div>
    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    </div>
            </form>
        </div>
        </div>
    </div>
@endsection