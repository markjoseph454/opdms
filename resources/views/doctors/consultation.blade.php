@component('partials/header')

    @slot('title')
        OPD | Consultation
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/css/doctors/consultation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/diagnosis.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientinfo.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/industrialForm.css') }}" rel="stylesheet" />

    <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/designation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/requisition/medicines.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/status.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors/dashboard')
@section('main-content')


    <div class="content-wrapper" style="padding: 50px 20px">
        <br/>
        <div class="container-fluid">




            <div class="loaderRefresh">
                <div class="loaderWaiting">
                    <i class="fa fa-spinner fa-spin"></i>
                    <span> Please Wait...</span>
                </div>
            </div>





            @include('doctors.medicalRecords')
            @include('doctors.ajaxConsultationList')
            @include('doctors.ajaxRequisitionList')
            @include('doctors.ajaxRefferals')
            @include('doctors.ajaxFollowup')
            @include('doctors.records.consultation')
            @include('doctors.requisition.medsWatch')
            @include('doctors.records.radiology')



            @include('doctors.industrial.form')


            @include('doctors.consultation_icon', ['patient'=>$patient, 'smoke'=>$smoke])

            @include('doctors.consultation_patientinfo', ['patient'=>$patient])

            @include('doctors.consultation_notification', ['refferals'=>$refferals, 'followups'=>$followups])

            <div class="row diagnosisWrapper">
                <form action="{{ url('consultation') }}" method="post" enctype="multipart/form-data" id="consultationForm">
                    {{ csrf_field()  }}
                    <div class="form-group">
                        <textarea name="consultation" id="diagnosis" class="my-editor" rows="65">{!! $consultation->consultation or '' !!}</textarea>
                    </div>

                    @include('doctors.filemanager')

                    @include('doctors.icdCodeAttachments', ['icds'=>$icdcodes])

                </form>
            </div>

        </div>



        @include('doctors.icd10codes')

        @include('doctors.phic_annex')


    </div> <!-- .content-wrapper -->


@endsection
@endcomponent
@endsection




@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
    <script src="{{ asset('public/js/doctors/filemanager.js') }}"></script>
    <script src="{{ asset('public/plugins/js/tinymce/tinymce.min.js') }}"></script>

    <script src="{{ asset('public/js/doctors/bp.js') }}"></script>

    @if(Session::has('cid'))
        <script src="{{ asset('public/js/doctors/richtexteditorpreview.js') }}"></script>
    @else
        <script src="{{ asset('public/js/doctors/richtexteditor.js') }}"></script>
    @endif

    <script src="{{ asset('public/plugins/js/preventDelete.js') }}"></script>
    <script src="{{ asset('public/js/doctors/consultation.js') }}"></script>

    <script src="{{ asset('public/js/doctors/main.js') }}"></script>
    <script src="{{ asset('public/js/doctors/ajaxRecords.js') }}"></script>
    <script src="{{ asset('public/js/results/consultation.js') }}"></script>
    <script src="{{ asset('public/js/results/master.js') }}"></script>
    <script src="{{ asset('public/js/results/medsWatch.js') }}"></script>
    <script src="{{ asset('public/js/results/ultrasound.js') }}"></script>
    <script src="{{ asset('public/js/results/radiologyQuickView.js') }}"></script>



    <!-- smoke inceasation -->
    <script src="{{ asset('public/js/doctors/smokeInceasation.js') }}"></script>


    <script src="{{ asset('public/js/doctors/phic_annex.js') }}"></script>



    <script src="{{ asset('public/js/industrial/form.js') }}"></script>
    <script>
        $( function() {
            $( ".dateOfConsult" ).datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    @if($industrialConsultations)
        <script>
            $('.printIConIndustrial').fadeIn('fast');
        </script>
    @endif

@stop


@endcomponent
