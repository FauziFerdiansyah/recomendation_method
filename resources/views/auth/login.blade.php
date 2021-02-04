@extends('layouts.login')

@section('content')
<div class="form-wrapper">

    <!-- logo -->
    <div id="logo">
        <img class="logo" src="{{URL::asset('/img/logo.png')}}" alt="image">
    </div>
    <!-- ./ logo -->

    <!-- form -->
    <form action="{{ route('login') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' input-err' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' input-err' : '' }}" name="password" placeholder="Password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        
        <button class="btn btn-primary btn-block">Sign in</button>
    </form>
    <!-- ./ form -->


</div>
@endsection
@section('css')
    <style type="text/css">
        .form-group.has-error .invalid-feedback {
            width: 100%;
            color: #dc3545;
            display: block;
            margin: 4px 0px 10px;
        }
        .form-group.has-error {
            margin-bottom: 0.4rem;
        }
        .form-group.has-error .input-err {
            margin-bottom: 0px;
            border-color: #dc3545;
        }
        body.form-membership .form-wrapper #logo {
            margin-bottom: 2rem;
        }
    </style>
@endsection
