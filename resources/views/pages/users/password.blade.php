@extends('admin.layouts.app')

@section('title_web')Profile - Mimi Resto @endsection

@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">Users</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="{{ route('dashboard') }}">Home</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                    <li>
                        <a href="{{ route('user_index') }}">Users</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Profile</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel tab-border card-box">
                    <header class="panel-heading panel-heading-gray custom-tab">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="{{ route('users.profile') }}" data-toggle="tabs">
                                    <i class="fa fa-user"></i> Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.password') }}" data-toggle="tabs"  class="active show">
                                    <i class="fa fa-lock"></i> Password
                                </a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active show">
                                <!-- AREA NOTIF -->
                                @include('admin.common.notif')
                                <form action="{{ route('users.password.update') }}" role="form" method="post" accept-charset="utf-8" class="form-horizontal">                            
                                    <div class="form-group row  margin-top-20 {{ $errors->has('current_password') ? 'has-error' : '' }} current_password">
                                        <label class="control-label col-md-4" for="current_password">Current Password
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="password" id="current_password" name="current_password" class="form-control" value="{{ old('current_password') ?: '' }}" required autofocus>
                                            @if ($errors->has('current_password'))
                                                <span class="help-block">
                                                    {{ $errors->first('current_password') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row  {{ $errors->has('password') ? 'has-error' : '' }} password">
                                        <label class="control-label col-md-4" for="password">New Password
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="password" id="password" name="password" class="form-control" value="{{ old('password') ?: '' }}" required autofocus>
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    {{ $errors->first('password') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row  {{ $errors->has('password_confirmation') ? 'has-error' : '' }} password_confirmation">
                                        <label class="control-label col-md-4" for="password_confirmation">Confirm Password
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') ?: '' }}" required autofocus>
                                            @if ($errors->has('password_confirmation'))
                                                <span class="help-block">
                                                    {{ $errors->first('password_confirmation') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <div class="offset-md-4 col-md-9">
                                            <button type="submit" class="btn btn-info">Save</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="_token" value="{{ Session::token() }}">

                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>


    </div>
</div>
@endsection

@section('css')
    {{-- For Select Toggle Checkboxs --}}
    <link href="{{ asset('css/formlayout.css') }}" rel="stylesheet" type="text/css"/>
@endsection

