@extends('layouts.app')

@section('title_web')
   Update Category
@endsection

@section('content')

<div class="row">
  <div class="offset-md-3 col-md-6">
    <div class="card">
      <div class="card-body">       
        <!-- AREA NOTIF -->
        @include('common.notif')
        <form action="{{ route('category_update', $data->id) }}" role="form" method="post">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <div class="row">
            <div class="col-md-9 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
              <label for="name_Input">Category Name</label>
              <input type="text" name="name" value="{{ old('name') ?: $data->name }}" class="form-control" id="name_Input" placeholder="Enter category name" autofocus required>
              @if ($errors->has('name'))
                <span class="help-block">
                    {{ $errors->first('name') }}
                </span>
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
