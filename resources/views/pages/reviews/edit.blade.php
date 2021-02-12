@extends('layouts.app')

@section('title_web')
   Update Review
@endsection

@section('content')

<div class="row">
  <div class="offset-md-3 col-md-6">
    <div class="card">
      <div class="card-body">       
        <!-- AREA NOTIF -->
        @include('common.notif')
        <form action="{{ route('review_update', $data->id) }}" role="form" method="post">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <div class="row">
            <div class="col-md-9 form-group {{ $errors->has('customer_id') ? 'has-error' : '' }}">
              <label for="name_Input">Customer</label>
              <select class="CustomerID form-control input-lg" style="width:500px;" name="customer_id" autofocus required>
                <option value="{{$data->customer_id}}">{{$data->customer_name}}</option>
              </select>
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
              <select class="ProductID form-control input-lg" style="width:500px;" name="product_id" required>
                <option value="{{$data->product_id}}">{{$data->product_name}}</option>
              </select>
              @if ($errors->has('product_id'))
                <span class="help-block">
                    {{ $errors->first('product_id') }}
                </span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-md-9 form-group {{ $errors->has('rating') ? 'has-error' : '' }}">
              <label for="name_Input">Ratings</label>
              <input type="hidden" name="rating" id="selected_rating" value="{{$data->rating}}" required>
              <div>
                {!! 
                $rating = ""; 
                for ($x = 1; $x <= 5; $x++){
                  if($x > $data->rating){
                      $rating .= '<button type="button" class="btnrating mr-1 btn btn-outline-warning" data-attr="'.$x.'" id="rating-star-'.$x.'"><i class="fa fa-star"></i></button>';
                  }else{
                      $rating .= '<button type="button" class="btnrating mr-1 btn btn-warning" data-attr="'.$x.'" id="rating-star-'.$x.'"><i class="fa fa-star"></i></button>';
                  }
                }
                echo ($rating);
                !!}
              </div>

              @if ($errors->has('rating'))
                <span class="help-block">
                    {{ $errors->first('rating') }}
                </span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 form-group {{ $errors->has('note') ? 'has-error' : '' }}">
              <label for="weight_Input">Note</label>
              <textarea name="note" class="form-control input-sm" rows="5">{{ old('note') ?: $data->note }}</textarea>
              @if ($errors->has('note'))
                <span class="help-block">{{ $errors->first('note') }}</span>
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

      $('.CustomerID').prop('disabled', true);
      $('.ProductID').prop('disabled', true);

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
