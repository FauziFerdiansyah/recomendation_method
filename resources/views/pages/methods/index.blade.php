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
          <button type="button" class="btn btn-primary mb-2 ml-sm-0 ml-0 ml-md-1" onclick="execMethod(this)">Get Recomendation</button>
        </form>
      </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-block">
                <h6 class="card-title mb-3">Review Product</h6>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive" id="table-review">
                      <center>Data is empety</center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-block">
                <h6 class="card-title mb-3">Similarity Product (Pearson correlation)</h6>
                <div class="alert alert-info">Pendekatan Pearson correlation adalah sebuah metode yang dikembangkan oleh Karl Pearson. Korelasi (correlation) adalah sebuah teknik pengukuran yang menentukan seberapa dekat relasi antar dua himpunan bilangan yang berbeda.</div>
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
                <div class="alert alert-info">Perhitungan prediksi digunakan untuk memprediksi nilai rating yang diberikan oleh user untuk item tertentu.</div>
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
    <div class="card">
        <div class="card-body">
            <div class="d-block">
                <h6 class="card-title mb-3">MAE Product</h6>
                <div class="alert alert-info">Mean absolute error (MAE) adalah formula yang digunakan untuk menghitung tingkat akurasi atau besar error hasil prediksi rating dari sistem terhadap rating yang sebenarnya yang user berikan terhadap suatu item (Ricci et.al., 2011). Dari MAE yang dihasilkan akan ditarik kesimpulan dengan asumsi jika MAE semakin mendekati 0 maka hasil prediksi akan semakin akurat.</div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="rating-user">
                    </div>
                    <div id="rating-by-system">
                    </div>
                    <div class="table-responsive" id="table-mae">
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

      function execMethod(this_) {
          var btn_ = $(this_);
          $.ajax({
            url: "{{ route('method_store') }}",
            type: "POST",
            dataType: 'json',
            data: $('#form-data').serialize(),
            beforeSend: function() {
                var data_load = '<center><span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...</center>';
                var btn_load = '<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>';
                $('#table-similarity').html(data_load);
                $('#table-review').html(data_load);
                $('#table-prediction').html(data_load);
                $('#table-mae').html(data_load);
                btn_.prop('disabled', true);
                btn_.html(btn_load);
            }
          }).done(function (data, textStatus, jqXHR){
            var empty_data = '<center>Data is empety</center>';
            if(data.table_review){
              $('#table-review').html(data.table_review);
            }else{
              $('#table-review').html(empty_data);
            }
            if(data.table_similarity){
              $('#table-similarity').html(data.table_similarity);
            }else{
              $('#table-similarity').html(empty_data);
            }
            if(data.table_prediction){
              $('#table-prediction').html(data.table_prediction);
            }else{
              $('#table-similarity').html(empty_data);
            }
            if(data.MAE || data.MAE === 0){
              $('#table-mae').html(`<span>MAE : <b>${data.MAE}</b>`);
              $('#rating-user').html(`<span>Rating product <i>${data.product_selected}</i> by ${data.username} : <b>${data.rating_user}</b></span>`);
              $('#rating-by-system').html(`<span>Rating product <i>${data.product_selected}</i> by System : <b>${data.rating_by_system}</b></span>`);
            }else{
              $('#table-mae').html(empty_data);
              $('#rating-user').html(``);
              $('#rating-by-system').html(``);
            }
            if(data.MAE == null){
              $('#table-mae').html('<div class="alert alert-danger" role="alert">Produk ini belum dirating oleh customer, sehingga MAE tidak tersedia.</div>');
            }
          })
          .fail()
          .always(function (){
            btn_.prop('disabled', false);
            btn_.html("Get Recomendation");
          });
      }
    </script>
@endpush

