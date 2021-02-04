@extends('layouts.app')

@section('title_web')
   Dashboard - Rekomendasi
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="card card-body bg-info-gradient">
                <h4>Welcome {{ Auth::user()->name}} <i class="ti-face-smile ml-2"></i></h4>
        </div>

    </div>
</div>

@endsection