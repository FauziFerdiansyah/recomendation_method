@if(!empty($errors))
    @if($errors->any())

        <div class="alert alert-danger alert-dismissible" role="alert">
        
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ti-close"></i>
            </button>
            <ul class="list-unstyled">
                <li><i class="ti-info-alt mr-2"></i> Errors
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    @endif
@endif

{{-- @if(session('alt_red')) --}}
@if(Session::has('alt_red'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <i class="ti-info-alt mr-2"></i> {{ Session::get('alt_red') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ti-close"></i>
        </button>
    </div>
@endif

{{-- @if(session('alt_green')) --}}
@if(Session::has('alt_green'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <i class="ti-check mr-2"></i> {{ Session::get('alt_green') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ti-close"></i>
        </button>
    </div>
@endif