@extends('layouts.app')

@section('title_web')
   Update Users
@endsection

@section('content')

<div class="row">
  <div class="offset-md-3 col-md-6">
    <div class="card">
      <div class="card-body">       
        <!-- AREA NOTIF -->
        @include('common.notif')
        <form action="{{ route('user_update', $data->id) }}" role="form" method="post">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <div class="row">
            <div class="col-md-9 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
              <label for="name_Input">Name</label>
              <input type="text" name="name" value="{{ old('name') ?: $data->name }}" class="form-control" id="name_Input" placeholder="Enter name" autofocus required>
              @if ($errors->has('name'))
                <span class="help-block">
                    {{ $errors->first('name') }}
                </span>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="col-md-10 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
              <label for="email_Input">E-Mail Address</label>
              <input type="email" name="email" value="{{ old('email') ?: $data->email }}" class="form-control" id="email_Input" placeholder="Enter email" required>
              @if ($errors->has('email'))
                <span class="help-block">
                    {{ $errors->first('email') }}
                </span>
              @endif
            </div>
          </div>

          <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
            <div class="custom-control custom-switch">
              <input type="checkbox" name="status" class="custom-control-input" id="status_check" value="{{$data->status}}"  @if($data->status == 2) checked="checked" @endif>
              <label class="custom-control-label" for="status_check">Status Active</label>
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
