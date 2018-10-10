@component('partials/header')

    @slot('title')
        OPD | Scan Barcode
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/patients/register.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/triage/triage_support.css') }}" rel="stylesheet" />
@stop



@section('header')
    @include('receptions.navigation')
@stop



@section('content')

    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <br/><br/><br/>
            <h2 class="text-center">RECEPTION AREA</h2>
            <br/>
            <form action="{{ url('receptionsbarcode') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group @if($errors->has('barcode')) has-error @endif">
                    <input type="text" name="barcode" class="form-control" value=""
                           placeholder="Enter QRCODE or Hospital #" autofocus />
                    @if($errors->has('barcode'))
                        <span class="help-block">
                            <strong>{{ $errors->first('barcode') }}</strong>
                        </span>
                    @endif
                </div>
            </form>

            <br/>
            <br/>
            <p class="text-center">
                <strong>“ Prioritization of patients for medical treatment ”</strong>
            </p>
            <p class="text-center">
                Medicine is a science of uncertainty and an art of probabality.
            </p>
        </div>
    </div>

@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
@stop


@endcomponent
