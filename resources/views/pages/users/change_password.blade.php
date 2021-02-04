@extends('layouts.app')

@section('title_web')
   Change Password Users - Mimi Resto
@endsection

@section('content')

<div class="row">
  <div class="offset-md-3 col-md-6">
    <div class="card">
      <div class="card-body">       
        <!-- AREA NOTIF -->
        @include('common.notif')
        <form action="{{ route('user_change_password_update', $data->id) }}" role="form" method="post">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <div class="row">
            <div class="col-md-6 form-group {{ $errors->has('current_password') ? 'has-error' : '' }}">
              <label for="current_password_Input">Current Password</label>
              <input type="password" name="current_password" value="{{ old('current_password') ?: '' }}" class="form-control" id="current_password_Input" placeholder="Enter current password" autofocus required>
              @if ($errors->has('name'))
                <span class="help-block">
                    {{ $errors->first('name') }}
                </span>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
              <label for="password_input">Password</label>
              <input type="password" name="password" value="{{ old('password') ?: '' }}" class="form-control" id="password_input" placeholder="Password (> 5 characters)">
              @if ($errors->has('password'))
                <span class="help-block">
                    {{ $errors->first('password') }}
                </span>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
              <label for="password_confirm_input">Confirm Password</label>
              <input type="password" name="password_confirmation" value="{{ old('password_confirmation') ?: '' }}" class="form-control" id="password_confirm_input" placeholder="Enter Confirm Password">
              @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    {{ $errors->first('password_confirmation') }}
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
