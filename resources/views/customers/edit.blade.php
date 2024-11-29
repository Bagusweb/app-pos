@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success">
            <h3 class="card-title">form Edit Customer</h3>
            </div>
            <form action="{{route('customer.update', $dataEditcustomer->customer_id)}}" method="POST">
    {{ csrf_field() }}
            <div class="card-body">
            <div class="form-group">
                <label for="customer_name" class="form-label">Customer Name :</label>
                <input type="hidden"  name="_method" value="PUT" />
    <input type="text" name="customer_name" class="form-control" value="{{$dataEditcustomer->customer_name}}">
    @if ($errors->has('customer_name'))
    <span class="text-danger">{{ $errors->first('customer_name') }}</span>
    @endif
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email :</label>
    <input type="email" name="email" class="form-control" value="{{$dataEditcustomer->email}}">
    @if ($errors->has('email'))
    <span class="text-danger">{{ $errors->first('email') }}</span>
    @endif
            </div>
            <div class="form-group">
                <label for="phone" class="form-label">phone :</label>
                <input type="number" class="form-control"name="phone" value="{{$dataEditcustomer->phone}}">
    @if ($errors->has('phone'))
    <span class="text-danger">{{ $errors->first('phone') }}</span>
    @endif
            </div>
            <div class="form-group">
                <label for="member_status" class="form-label">Member status :</label>
                <div class="form-check">
                <input type="radio" class="form-check-label" name="member_status" value=1 {{ ($dataEditcustomer->member_status == 1) ?
    'checked' : ''}}>True
                </div>
                <div class="form-check">
                <input type="radio" class="form-check-label" name="member_status" value=0 {{ ($dataEditcustomer->member_status == 0) ? 'checked' :
    ''}}>False
    @if ($errors->has('member_status'))
    <span class="text-danger">{{ $errors->first('member_status') }}</span>
    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="address" class="form-label">address :</label>
                <textarea class="form-control" name="address">{{ $dataEditcustomer->address }}</textarea>
        @if ($errors->has('address'))
            <div class="text-danger">{{ $errors->first('address') }}</div>
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