@component('partials/header')

    @slot('title')
        OPD | Edit Account
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/css/doctors/consultation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/partials/account.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors/dashboard')
@section('main-content')


    <div class="content-wrapper">
        <br/>

        <div class="container-fluid">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Consultation</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                        <td>{{ $row->patient }}</td>
                        <td>{{ $row->doctor }}</td>
                        <td>{{ $row->consultation }}</td>
                        <td>{{ $row->created_at->toFormattedDateString() }}</td>
                        @endforeach
                </tbody>
            </table>

        </div>

    </div> <!-- .content-wrapper -->


@endsection
@endcomponent
@endsection




@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
@stop


@endcomponent
