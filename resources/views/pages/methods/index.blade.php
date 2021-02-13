@extends('layouts.app')

@section('title_web')
Create New Review
@endsection

@section('content')

<div class="row">
  <div class="offset-md-3 col-md-6">
    <div class="card">
      <div class="card-body">       
        <!-- AREA NOTIF -->
        @include('common.notif')
        <form action="{{ route('method_store') }}" role="form" method="post">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <div class="row">
            <div class="col-md-9 form-group {{ $errors->has('customer_id') ? 'has-error' : '' }}">
              <label for="name_Input">Customer</label>
              <select class="CustomerID form-control input-lg" style="width:500px;" name="customer_id" autofocus required></select>
              @if ($errors->has('customer_id'))
                <span class="help-block">
                    {{ $errors->first('customer_id') }}
                </span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-md-9 form-group {{ $errors->has('product_id') ? 'has-error' : '' }}">
              <label for="name_Input">Product</label>
              <select class="ProductID form-control input-lg" style="width:500px;" name="product_id" required></select>
              @if ($errors->has('product_id'))
                <span class="help-block">
                    {{ $errors->first('product_id') }}
                </span>
              @endif
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Get Recomendation</button>
        </form>

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
    </script>
@endpush

