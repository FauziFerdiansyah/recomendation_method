@extends('layouts.app')

@section('title_web')
Data Customer
@endsection

@section('content')


<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">
                <!-- AREA NOTIF -->
                <div id="notif_info">
                    @include('common.notif')
                </div>
                <div class="d-flex justify-content-between">
                    <h6 class="card-title">Table Customer</h6>
                    <div>
                        <a href="{{route('customer_create')}}" class="btn btn-outline-primary btn-sm btn-uppercase">
                            <i class="ti-plus mr-2"></i> Add New Customer
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tables" class="table table-striped table-bordered dataTable dtr-inline" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('css')
    <link href="{{ asset('plugin/dataTable/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@push('scripts')
    <script src="{{ asset('plugin/dataTable/datatables.min.js') }}" ></script>


    <script type="text/javascript">
        'use strict';
        var table;
        $(document).ready(function() {
            table = $('#tables').DataTable({
                responsive: true,
                stateSave : true, 
                processing: true,
                ajax: '{!! route('datatables.customers') !!}',
                aoColumnDefs: [
                    {
                        'bVisible': true,
                        'sWidth': '5%',
                        'aTargets': [0]
                    },
                    {
                        'sWidth': '15%',
                        'aTargets':[2]
                    },
                    {
                        'sWidth': '10%',
                        'aTargets':[3]
                    },
                    {
                        'sWidth': '5%',
                        'aTargets':[4]
                    },
                    {
                        'sWidth': '20%',
                        'aTargets':[-2]
                    },
                    {
                        'sWidth': '5%',
                        'aTargets':[-1]
                    } 
                ],              

                columns: [
                    { data: 'data_id', name: 'customers.data_id', searchable:false,visible: true},
                    { data: 'name', name: 'customers.name' },
                    { data: 'email', name: 'customers.email' },
                    { data: 'phone', name: 'customers.phone' },
                    { data: 'gender', name: 'customers.gender' },
                    { data: 'updated_at', name: 'customers.updated_at' },
                    { data: 'actions', name: 'actions',"searchable": false ,'orderable' : false },
                ],
            });
            $("#tables_wrapper #tables_length label").append('<button type="button" class="btn btn-outline-primary btn-sm btn-rounded ml-2" onclick="table.ajax.reload(null);"><i class="fa fa-refresh"></i></button>');
        });
    </script>
@endpush



