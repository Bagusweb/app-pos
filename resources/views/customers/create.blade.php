@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
            <h3 class="card-title">form create Customer</h3>
            </div>
            <form action="{{route('customer.store')}}" method="POST">
    {{ csrf_field() }}
            <div class="card-body">
            <div class="form group">
                <label for="customer_name" class="form-label">Customer Name :</label>
                <input type="text" class="form-control" name="customer_name" value="{{old('customer_name')}}">
    @if ($errors->has('customer_name'))
    <span class="text-danger">{{ $errors->first('customer_name') }}</span>
    @endif
            </div>
            <div class="form group">
                <label for="email" class="form-label">Email :</label>
                <input type="email" name="email"class="form-control" value="{{old('email')}}">
    @if ($errors->has('email'))
    <span class="text-danger">{{ $errors->first('email') }}</span>
    @endif
            </div>
            <div class="form group">
                <label for="Phone" class="form-label">Phone :</label>
                <input type="number"   class="form-control" name="phone" value="{{old('phone')}}">
    @if ($errors->has('phone'))
    <span class="text-danger">{{ $errors->first('phone') }}</span>
    @endif
            </div>
            <div class="form group">
                <label for="member_status" class="form-label">Member Status :</label>
                <div class="form-check">
                <input type="radio" class="form-check-input" name="member_status" value=1>
                <label for="member_status" class="form-check-label">True</label>
                </div>
                <div class="form-check">
                <input type="radio" class="form-check-input" name="member_status" value=0 checked>
                <label for="member_status" class="form-check-label">False</label>
                </div>
    @if ($errors->has('member_status'))
    <span class="text-danger">{{ $errors->first('member_status') }}</span>
    @endif
            </div>
            <div class="form group">
                <label for="address" class="form-label">address :</label>
                <textarea  class="form-control"  name="address">{{old('address')}}</textarea>
    @if ($errors->has('address'))
    <span class="text-danger">{{ $errors->first('address') }}</span>
    @endif
            </div>
            <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    </div>
    </form>
    </div>
        </div>
    </div>
</div>
@endsection
