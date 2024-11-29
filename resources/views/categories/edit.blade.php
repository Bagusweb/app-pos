@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-success">
            <h3 class="card-title">form Edit category</h3>
            </div>
            <form action="{{route('category.update',$dataEditcategory->category_id)}}" method="POST">
    {{ csrf_field() }}
            <div class="card-body">
            <div class="form-group">
                <label for="category_name" class="form-label">Category name :</label>
                <input type="hidden" name="_method" value="PUT">
    <input type="text" class="form-control" name="category_name" value="{{$dataEditcategory->category_name}}" />
    @if ($errors->has('category_name'))
    <span class="text-danger">{{ $errors->first('category_name') }}</span>
    @endif
            </div>
            <div class="form-group">
                <label for="description" class="form-label">description :</label>
                <textarea class="form-control" name="description">{{$dataEditcategory->description}}</textarea>
    @if ($errors->has('description'))
    <span class="text-danger">{{ $errors->first('description') }}</span>
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