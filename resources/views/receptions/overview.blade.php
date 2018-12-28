@component('partials/header')

    @slot('title')
        OPD | Overview
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/patients/register.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/designation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/status.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/requisition/medicines.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/ancillary/charging.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')
    <br>
    <div class="container-fluid" id="overviewWrapper">

        @include('doctors.medicalRecords')
        @include('doctors.ajaxConsultationList')
        @include('doctors.ajaxRequisitionList')
        @include('doctors.ajaxRefferals')
        @include('doctors.ajaxFollowup')
        @include('doctors.requisition.medsWatch')
        @include('doctors.records.radiology')
        @include('ancillary.chargingmodal')
        @include('ancillary.loader')


        @php
            $chrgingClinics = array(3,5,8,24,32,34,10,48,22,21,25,11,26);
            $noDoctorsClinic = array(10,48,22,21);
        @endphp

        <div class="">

            @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                @include('receptions.overview.doctors')
            @endif

            <div class="{{ (!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'col-md-8' : 'container' }} patientsWrapper">
                <br>

                @include('receptions.overview.title')

                @if(in_array(Auth::user()->clinic, $noDoctorsClinic))
                    <hr>
                    @include('receptions.ancillary.status')
                @else
                    @include('receptions.overview.status')
                @endif

                <br>
                <div class="table-responsive patientsOverview">
                    <table class="table" id="patientsTable">

                        @include('receptions.overview.thead')


                        <tbody>
                            @if(count($patients) > 0)
                                @php
                                    $fin = 0;
                                    $can = 0;
                                    $pau = 0;
                                    $unassgned = 0;
                                    $pen = 0;
                                    $serv = 0;
                                @endphp
                                @foreach($patients as $patient)
                                    @php
                                    if($patient->status == 'P'){
                                        $asgn = 'disabled onclick="return false"';
                                        $reasgn = '';
                                        $cancel = '';
                                        $status = 'pending';
                                        $pen++;
                                        }
                                    elseif($patient->status == 'S'){
                                        $asgn = 'disabled onclick="return false"';
                                        $reasgn = 'disabled onclick="return false"';
                                        $cancel = 'disabled onclick="return false"';
                                        $status = 'serving';
                                        $serv++;
                                        }
                                    elseif($patient->status == 'F'){
                                        /*$asgn = 'disabled onclick="return false"';*/
                                        $asgn = '';
                                        $reasgn = 'disabled onclick="return false"';
                                        $cancel = 'disabled onclick="return false"';
                                        $status = 'finished';
                                        $fin++;
                                        }
                                    elseif($patient->status == 'C'){
                                        $asgn = '';
                                        $reasgn = 'disabled onclick="return false"';
                                        $cancel = 'disabled onclick="return false"';
                                        $status = 'cancel';
                                        $can++;
                                        }
                                    elseif($patient->status == 'H'){
                                        $asgn = '';
                                        $reasgn = 'disabled onclick="return false"';
                                        $cancel = 'disabled onclick="return false"';
                                        $status = 'paused';
                                        $pau++;
                                        }
                                    else{
                                        $asgn = '';
                                        $reasgn = 'disabled onclick="return false"';
                                        $cancel = '';
                                        $status = 'unassigned';
                                        $unassgned++;
                                        }
                                    @endphp


                                <tr>

                                    @include('receptions.overview.patient')

                                    @include('receptions.overview.info')

                                    @php
                                        if($patient->ff + $patient->rf > 0){
                                            $assignedDoctor = App\Refferal::countAllNotifications($patient->id);
                                        }else{
                                            $assignedDoctor = array();
                                        }
                                    @endphp

                                    @if(Auth::user()->clinic != 21 || Auth::user()->clinic != 22)
                                        @include('receptions.overview.records')
                                    @endif

                                    @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                                        @include('receptions.overview.assign')
                                        @include('receptions.overview.reassign')
                                    @endif



                                    @if(in_array(Auth::user()->clinic, $chrgingClinics))
                                        @php
                                            $charging = App\Ancillaryrequist::otherCharging($patient->id);
                                        @endphp
                                    @endif



                                    @include('receptions.overview.cancel')

                                    @include('receptions.overview.done')

                                    @include('receptions.overview.charging')

                                </tr>
                                @endforeach
                            @else

                                @include('receptions.overview.noPatient')

                            @endif
                        </tbody>
                    </table>




                </div>

                @include('partials.legend')


            </div>
        </div>
    </div>

@endsection



@section('footer')
@stop



@section('pagescript')

    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/receptions/overview.js') }}"></script>
    <script src="{{ asset('public/js/doctors/ajaxRecords.js') }}"></script>
    <script src="{{ asset('public/js/receptions/consultation.js') }}"></script>
    <script src="{{ asset('public/js/results/master.js') }}"></script>
    <script src="{{ asset('public/js/results/medsWatch.js') }}"></script>
    <script src="{{ asset('public/js/results/ultrasound.js') }}"></script>
    <script src="{{ asset('public/js/results/radiologyQuickView.js') }}"></script>
    <script src="{{ asset('public/js/ancillary/charging.js') }}"></script>

    @include('receptions.message.notify')




@stop


@endcomponent
