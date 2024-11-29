@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
            <h3 class="card-title">form create Product</h3>
            </div><form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card-body">
           <div class="form-group">
            <label for="product_name" class="form-label">Product Name :</label>
           <input type="text" class="form-control" name="product_name" value="{{ old('product_name') }}">
            @if ($errors->has('product_name'))
            <span class="text-danger">{{ $errors->first('product_name') }}</span>
            @endif
           </div>
           <div class="form-group">
            <label for="photo" class="form-label">Foto Product</label>
           <input type="file" name="photo">
           </div>
           <div class="form-group">
            <label for="category_id" class="form-label">Select Category :</label>
    <select class="form-control" name="category_id">
        <option value="">Select Category</option>
        @foreach ($dataCategory as $v)
        <option value="{{ $v->category_id }}" @if (old('category_id')==$v->category_id) selected @endif>{{ $v->category_name }}</option>
        @endforeach
    </select>
    @if ($errors->has('category_id'))
    <span class="text-danger">{{ $errors->first('category_id') }}</span>
    @endif
           </div>
           <div class="form-group">
            <label for="price" class="form-label">Price :</label>
            <input type="text" class="form-control" name="price" value="{{ old('price') }}">
    @if ($errors->has('price'))
    <span class="text-danger">{{ $errors->first('price') }}</span>
    @endif
           </div>
           <div class="form-group">
            <label for="stock" class="form-label">Stock :</label>
            <input type="text" class="form-control" name="stock" value="{{ old('stock') }}">
    @if ($errors->has('stock'))
    <span class="text-danger">{{ $errors->first('stock') }}</span>
    @endif
           </div>
           <div class="form-group">
            <label for="product_description" class="form-label">Product Description :</label>
           <textarea type="text" class="form-control" name="product_description">{{ old('product_description') }}</textarea></br>
    @if ($errors->has('product_description'))
    <span class="text-danger">{{ $errors->first('product_description') }}</span>
    @endif
</div>
                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    </div>
</form>            </div>
        </div>
    </div>
</div>
@endsection