@php 
  use App\Patient;
@endphp
@component('OPDMS.partials.header')


@slot('title')
    MEDICAL RECORDS
@endslot


@section('pagestyle')
    <link href="{{ asset('public/OPDMS/css/patients/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/action.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/check_patient.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/result_patient.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/print_patient.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/edit_patient.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/remove.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/patient_information.css') }}" rel="stylesheet" />
@endsection


@section('navigation')
    @include('OPDMS.partials.boilerplate.navigation')
@endsection


@section('dashboard')
    @component('OPDMS.partials.boilerplate.dashboard')
        {{--
            @section('search_form')
                @include('OPDMS.partials.boilerplate.search_form', ['redirector' => 'admin.search'])
            @endsection
        --}}
    @endcomponent
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="main-page">

        @include('OPDMS.partials.boilerplate.header',
        ['header' => 'Patients List', 'sub' => 'All patients that was been registered will be shown here.'])

        <!-- Main content -->
        <section class="content">

            <div class="box">
                @include('OPDMS.patients.action')

                <div class="box-body">
                    @include('OPDMS.partials.loader')
                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="table table-striped table-hover" id="patient-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><span class="fa fa-user-o"></span></th>
                                    <th>ID No</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Suffix</th>
                                    <th>Gender</th>
                                    <th>Birthdate</th>
                                    <th>Address</th>
                                    <th>Reg.Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $list)
                                <tr data-id="{{ $list->id }}" @if($list->fordelete) status="remove" @endif>
                                    <td><span class="fa fa-caret-right"></span></td>
                                    <td class=""><span class="fa fa-user-o @if($list->fordelete) text-red @endif"></span></td>
                                    <td>{{ $list->hospital_no }}</td>
                                    <td class="last_name">{{ $list->last_name }}</td>
                                    <td class="first_name">{{ $list->first_name }}</td>
                                    <td class="middle_name">{{ $list->middle_name }}</td>
                                    <td class="suffix">{{ $list->suffix }}</td>
                                    <td class="sex">{{ ($list->sex == "M")?'Male':'Female' }}</td>
                                    <td class="birthday">@if($list->birthday) {{ Carbon::parse($list->birthday)->format('m/d/Y') }} @endif</td>
                                    <td class="address">{{ $list->brgyDesc.' '.$list->citymunDesc.', '.$list->provDesc }}</td>
                                    <td>{{ Carbon::parse($list->regdate)->format('m/d/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="box-footer">
                    <small>
                        <em class="text-muted">
                              @if (count($request->post()) > 0)
                                Showing <b> {{ count($data) }} </b> search result(s).
                              @else  
                                Showing <b> {{ count($data) }} </b> of {{ count(Patient::whereDate('created_at', '=', Carbon::today())->get()) }} registered patient(s) today.
                              @endif
                            <!-- Carbon::today() -->
                        </em>
                    </small>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>

    @include('OPDMS.patients.modals.check_patient')
    @include('OPDMS.patients.modals.check_result')
    @include('OPDMS.patients.modals.store_patient')
    @include('OPDMS.patients.modals.edit_patient')
    @include('OPDMS.patients.modals.remove')
    @include('OPDMS.patients.modals.address')
    @include('OPDMS.patients.modals.print')
    @include('OPDMS.patients.modals.patient_information')
    @include('OPDMS.patients.modals.medical_records')
    <!-- /.content-wrapper -->
@endsection



{{--@section('footer')
    @include('OPDMS.partials.boilerplate.footer')
@endsection--}}

@section('aside')
    @include('OPDMS.partials.boilerplate.aside')
@endsection


@section('pluginscript')
    <script src="{{ asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
@endsection

@section('pagescript')
    <script>
        var dateToday = '{{ Carbon::today()->format("m/d/Y") }}';
    </script>
    <script src="{{ asset('public/OPDMS/js/patients/main.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/action.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/check_patient.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/result_patient.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/print_patient.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/store_patient.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/edit_patient.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/remove.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/search.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/table.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/roles.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/patient_information.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/medical_record.js') }}"></script>

    <script src="{{ asset('public/OPDMS/js/patients/address.js') }}"></script>



   <!--  <script src="{{ asset('public/AdminLTE/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/AdminLTE/dist/js/adminlte.min.js') }}"></script> -->


    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>

@endsection


@endcomponent