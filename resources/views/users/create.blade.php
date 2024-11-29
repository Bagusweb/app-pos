@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
            <h3 class="card-title">form create User</h3>
            </div>
            <form action="{{route('user.store')}}" method="POST">
    {{ csrf_field() }}
            <div class="card-body">
          <div class="form-group">
            <label for="name" class="form-label">Name :</label>
            <input type="text" class="form-control" name="name" value="{{old('name')}}">
    @if ($errors->has('name'))
    <span class="text-danger">{{ $errors->first('name') }}</span>
    @endif
          </div>
          <div class="form-group">
            <label for="email" class="form-group">email :</label>
            <input type="email"  class="form-control" name="email" value="{{old('email')}}">
    @if ($errors->has('email'))
    <span class="text-danger">{{ $errors->first('email') }}</span>
    @endif
          </div>
          <div class="form-group">
            <label for="password" class="form-label">password :</label>
            <input type="password" class="form-control" name="password" value="{{old('password')}}">
    @if ($errors->has('password'))
    <span class="text-danger">{{ $errors->first('password') }}</span>
    @endif
          </div>
          <div class="form-group">
            <label for="role" class="form-label">Role :</label>
            <div class="form-check">
            <input type="radio" name="role" value="Admin" checked>
            <label for="role" class="form-check-label">Admin</label>
            </div>
            <div class="form-check">
            <input type="radio" name="role" value="Cashier">
            <label for="role" class="form-check-label">Cashier</label>
            </div>
    @if ($errors->has('role'))
    <span class="text-danger">{{ $errors->first('role') }}</span>
    @endif
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