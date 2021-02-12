@extends('layouts.app')

@section('title_web')
   Update Customer
@endsection

@section('content')

<div class="row">
  <div class="offset-md-3 col-md-6">
    <div class="card">
      <div class="card-body">       
        <!-- AREA NOTIF -->
        @include('common.notif')
        <form action="{{ route('customer_update', $data->id) }}" role="form" method="post">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <div class="row">
            <div class="col-md-9 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
              <label for="name_Input">Customer Name</label>
              <input type="text" name="name" value="{{ old('name') ?: $data->name }}" class="form-control" id="name_Input" placeholder="Enter customer name" autofocus required>
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
          <div class="row">
            <div class="col-md-5 form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
              <label for="phone_Input">Phone Number</label>
              <input type="text" name="phone" value="{{ old('phone') ?: $data->phone }}" class="form-control" id="phone_Input" placeholder="Enter phone number" required>
              @if ($errors->has('phone'))
                <span class="help-block">
                    {{ $errors->first('phone') }}
                </span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="gender_male_Input" name="gender" class="custom-control-input" value="1" @if($data->gender == 1) checked="checked" @endif>
                <label class="custom-control-label" for="gender_male_Input">Male</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="gender_female_Input" name="gender" class="custom-control-input" value="2" @if($data->gender == 2) checked="checked" @endif>
                <label class="custom-control-label" for="gender_female_Input">Female</label>
              </div>
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
