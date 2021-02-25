@extends('layouts.app')

@section('title_web')
Create New Review
@endsection

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">       
        <!-- AREA NOTIF -->
        @include('common.notif')
        <form class="form-inline" id="form-data">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
            <div class="form-group mb-2 col-md-5 px-sm-0 px-0 px-md-1">
              <label for="name_Input" class="sr-only">Customer</label>
              <select class="CustomerID form-control input-lg" name="customer_id" autofocus required></select>
              @if ($errors->has('customer_id'))
                <span class="help-block">
                    {{ $errors->first('customer_id') }}
                </span>
              @endif
            </div>
            <div class="form-group mb-2 col-md-5 px-sm-0 px-0 px-md-1">
              <label for="name_Input" class="sr-only">Product</label>
              <select class="ProductID form-control input-lg" name="product_id" required></select>
              @if ($errors->has('product_id'))
                <span class="help-block">
                    {{ $errors->first('product_id') }}
                </span>
              @endif
            </div>
          <button type="button" class="btn btn-primary mb-2 ml-sm-0 ml-0 ml-md-1" onclick="execMethod()">Get Recomendation</button>
        </form>

      </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-block">
                <h6 class="card-title mb-3">Similarity Product</h6>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive" id="table-similarity">
                      <center>Data is empety</center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-block">
                <h6 class="card-title mb-3">Prediction</h6>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive" id="table-prediction">
                      <center>Data is empety</center>
                    </div> 
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('plugin/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <style>
      .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
      }
      .select2.select2-container .select2-selection {
        border: 1px solid #ced4da;
        height: 38px;
      }
    </style>
@endsection

@push('scripts')
    <script src="{{ asset('plugin/select2/select2.min.js') }}" ></script>
    <script>
      $('.CustomerID').select2({
        placeholder: 'Select Customer...',
        ajax: {
            url:"{{ route('customer_search') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 10,
            data: function (term) {
                return {
                    key: term,
                    _token : "{{ Session::token() }}"
                };
            },
            processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.value
                                }
                            })
                        };
                    }
                }
      }).on("change", function (e) {
      });

      $('.ProductID').select2({
        placeholder: 'Select Product...',
        ajax: {
            url:"{{ route('product_search') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 10,
            data: function (term) {
                return {
                    key: term,
                    _token : "{{ Session::token() }}"
                };
            },
            processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.value
                                }
                            })
                        };
                    }
                }
      }).on("change", function (e) {
      });

      $(".btnrating").on('click',(function(e) {
        var previous_value = $("#selected_rating").val();
        var selected_value = $(this).attr("data-attr");
        $("#selected_rating").val(selected_value);
        
        $(".selected-rating").empty();
        $(".selected-rating").html(selected_value);
        
        for (i = 1; i <= selected_value; ++i) {
        $("#rating-star-"+i).toggleClass('btn-warning');
        $("#rating-star-"+i).toggleClass('btn-outline-warning');
        }
        
        for (ix = 1; ix <= previous_value; ++ix) {
        $("#rating-star-"+ix).toggleClass('btn-warning');
        $("#rating-star-"+ix).toggleClass('btn-outline-warning');
        }
      }));

      function execMethod() {
          $.ajax({
            url: "{{ route('method_store') }}",
            type: "POST",
            dataType: 'json',
            data: $('#form-data').serialize(),
            beforeSend: function() {
                
            }
          }).done(function (data, textStatus, jqXHR){
            if(data.table_similarity){
              $('#table-similarity').html(data.table_similarity);
            }
            if(data.table_prediction){
              $('#table-prediction').html(data.table_prediction);
            }
          })
          .fail()
          .always();
      }
    </script>
@endpush

