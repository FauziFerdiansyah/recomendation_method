@extends('layouts.app')

@section('title_web')
Create New Users
@endsection

@section('content')

<div class="row">
  <div class="offset-md-3 col-md-6">
    <div class="card">
      <div class="card-body">       
        <!-- AREA NOTIF -->
        @include('common.notif')
        <form action="{{ route('user_store') }}" role="form" method="post">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <div class="row">
            <div class="col-md-9 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
              <label for="name_Input">Name</label>
              <input type="text" name="name" value="{{ old('name') ?: '' }}" class="form-control" id="name_Input" placeholder="Enter name" autofocus required>
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
              <input type="email" name="email" value="{{ old('email') ?: '' }}" class="form-control" id="email_Input" placeholder="Enter email" required>
              @if ($errors->has('email'))
                <span class="help-block">
                    {{ $errors->first('email') }}
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
          
          <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
            <div class="custom-control custom-switch">
              <input type="checkbox" name="status" class="custom-control-input" id="status_check" value="2" checked>
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

