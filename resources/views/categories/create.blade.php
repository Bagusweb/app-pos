@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title"> Form Create Category</h3>
            </div>
            <form action="{{route('category.store')}}" method="POST">
                {{ csrf_field() }}
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="category_name"> Category Name</label>
                    <input type="text" class="form-control" name="category_name" 
                    value="{{ old('category_name') }}"/>
                    @if ($errors->has('category_name'))
                    <span class="label label-danger">{{ $errors->first('category_name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                    <span class="label label-danger">{{ $errors->first('description') }}</span>
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

