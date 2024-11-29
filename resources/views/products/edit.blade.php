@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success">
            <h3 class="card-title">form Edit Product</h3>
            </div>
            <form action="{{ route('product.update',$dataEditproduct) }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
            <div class="card-body">
                <div class="form-group">
                    <label for="product_name" class="form-label">Product Name :</label>
                    <input type="hidden" name="_method" value="PUT" />
    <input type="text" name="product_name" class="form-control" value="{{$dataEditproduct->product_name}}">
    @if ($errors->has('product_name'))
    <span class="text-danger">{{ $errors->first('product_name') }}</span>
    @endif
                </div>
                <div class="form-group">
                <label for="photo">Foto Produk :</label>
                <input type="file" name="photo"><br>
                @if($dataEditproduct->photo)
    <p>Foto Saat Ini: <img src="{{ asset('storage/' . $dataEditproduct->photo) }}"
            alt="{{ $dataEditproduct->product_name }}" width="100"></p>
    @endif
                </div>
                <div class="form-group">
                <label for="category_id" class="form-label">Product category :</label>
                <select class="form-control"name="category_id">
        <option value="">Select Category</option>
        @foreach ($categories as $v)
        <option value="{{ $v->category_id }}" {{ $v->category_id ==
            $dataEditproduct->category_id ? 'selected' : '' }}>{{ $v->category_name }}</option>
        @endforeach
    </select>
    @if ($errors->has('category_id'))
    <span class="ltext-danger">{{ $errors->first('category_id') }}</span>
    @endif
                </div>
                <div class="form-group">
                <label for="price" class="form-label">Price :</label>
                <input type="text"class="form-control" name="price" value="{{$dataEditproduct->price}}">
    @if ($errors->has('price'))
    <span class="text-danger">{{ $errors->first('price') }}</span>
    @endif
                </div>
                <div class="form-group">
                <label for="stock" class="form-label">Stock :</label>
    <input type="text" name="stock" class="form-control" value="{{$dataEditproduct->stock}}">
    @if ($errors->has('stock'))
    <span class="text-danger">{{ $errors->first('stock') }}</span>
    @endif
                </div>
                <div class="form-group">
                <label for="product_description" class="form-label">Product Description :</label>
                <textarea type="text" class="form-control" name="product_description">{{$dataEditproduct->product_description}}</textarea></br>
    @if ($errors->has('product_description'))
    <span class="text-danger">{{ $errors->first('product_description') }}</span>
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