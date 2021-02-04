@extends('layouts.app')

@section('title_web')
Data Category
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
                    <h6 class="card-title">Table Category</h6>
                    <div>
                        <a href="{{route('category_create')}}" class="btn btn-outline-primary btn-sm btn-uppercase">
                            <i class="ti-plus mr-2"></i> Add New User
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tables" class="table table-striped table-bordered dataTable dtr-inline" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
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
                ajax: '{!! route('datatables.categories') !!}',
                order: [[0, "desc" ]],
                aoColumnDefs: [
                    {
                        'bVisible': true,
                        'sWidth': '5%',
                        'aTargets': [0]
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
                    { data: 'data_id', name: 'categories.data_id', searchable:false,visible: true},
                    { data: 'name', name: 'categories.name' },
                    { data: 'updated_at', name: 'users.updated_at' },
                    { data: 'actions', name: 'actions',"searchable": false ,'orderable' : false },
                ],
            });
        });
    </script>
@endpush



