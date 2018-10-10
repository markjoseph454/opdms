@component('partials/header')

    @slot('title')
        OPD | Requisition
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/css/doctors/requisition.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors/dashboard')
        @section('main-content')






            <div class="content-wrapper" style="padding: 55px 10px">

                <div class="container-fluid">

                    @include('doctors.requisition.patientName')

                    <div class="col-md-12 requsitionWrapper">

                        <div class="row">


                            @include('doctors.requisition.departments')

                            @include('doctors.requisition.selection')

                        </div>

                    </div>


                    @include('doctors.requisition.selectedItems')

                </div>

            </div> <!-- .content-wrapper -->







        @endsection
    @endcomponent
@endsection





@section('footer')
@stop






@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
    <script src="{{ asset('public/js/requisition/master.js') }}"></script>
    <script src="{{ asset('public/js/requisition/meds.js') }}"></script>
    <script src="{{ asset('public/js/requisition/radiology.js') }}"></script>
@endsection

@endcomponent
