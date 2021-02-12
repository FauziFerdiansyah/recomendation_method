@extends('layouts.app')

@section('title_web')
Create New Product
@endsection

@section('content')

<div class="row">
  <div class="offset-md-3 col-md-6">
    <div class="card">
      <div class="card-body">       
        <!-- AREA NOTIF -->
        @include('common.notif')
        <form action="{{ route('product_store') }}" role="form" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <div class="row">
            <div class="col-md-12 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
              <label for="name_Input">Product Name</label>
              <input type="text" name="name" value="{{ old('name') ?: '' }}" class="form-control" id="name_Input" placeholder="Enter product name" autofocus required>
              @if ($errors->has('name'))
                <span class="help-block">
                    {{ $errors->first('name') }}
                </span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
              <label for="category_Input">Category</label>
                <select name="category_id" id="category_Input" class="form-control" required>
                  <option value="">- Select Category -</option>
                  @foreach($list_category as $key => $value)
                      option
                      <option value="{{ $key }}" @if($key == old('category_id') ) selected @endif>
                          {{ $value}}
                      </option>
                  @endforeach
                </select>
            </div>  
          </div>
          <div class="row">
            <div class="col-md-9 form-group {{ $errors->has('image') ? 'has-error' : '' }}">
              <label for="image_Input">Image Product</label>
                  <input type="file" name="image" class="form-control" value="{{ old('image') ?: '' }}" id="image_Input" required>
                @if ($errors->has('image'))
                  <span class="help-block">
                    {{ $errors->first('image') }}
                  </span>
                @endif
                <small class="form-text text-muted mt-2">
                    <ul>
                        <li>Extension allowed are jpg, jpeg, bmp, png, gif</li>
                        <li>Max file size is 1024 kb( 1mb )</li>
                    </ul>
                </small>
            </div> 
          </div>
          <div class="form-row">
            <div class="col-md-5 form-group {{ $errors->has('price') ? 'has-error' : '' }}">
              <label for="price_Input">Price</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp</span>
                </div>
                <input type="text" name="price" value="{{ old('price') ?: '' }}" class="form-control" id="price_Input" placeholder="Enter prices" required>
              </div>
              @if ($errors->has('price'))
                <span class="help-block">
                    {{ $errors->first('price') }}
                </span>
              @endif
            </div>
            <div class="col-md-4 form-group {{ $errors->has('weight') ? 'has-error' : '' }}">
              <label for="weight_Input">Weight</label>
              <div class="input-group">
                <input type="text" name="weight" value="{{ old('weight') ?: '' }}" class="form-control" id="weight_Input" placeholder="Enter weight" required>
                <div class="input-group-append">
                  <span class="input-group-text">Gram</span>
                </div>
              </div>
              @if ($errors->has('weight'))
                <span class="help-block">
                    {{ $errors->first('weight') }}
                </span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 form-group {{ $errors->has('description') ? 'has-error' : '' }}">
              <label for="weight_Input">Description</label>
              <textarea name="description" class="form-control input-sm" rows="5">{{ old('description') ?: '' }}</textarea>
              @if ($errors->has('description'))
                <span class="help-block">{{ $errors->first('description') }}</span>
              @endif
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection

@section('css')
@endsection

