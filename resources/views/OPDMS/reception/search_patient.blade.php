@component('OPDMS.partials.header')


    @slot('title')
        Search Patients
    @endslot


@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_queue.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/partials/patient_information.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_assignation.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/notification.css') }}" />
@endsection



{{-- vue element start of div --}}
@section('vue-container-start')
    <div id="vue-queue">
    @endsection





    @section('navigation')
        @include('OPDMS.partials.boilerplate.navigation')
    @endsection


    @section('dashboard')
        @component('OPDMS.partials.boilerplate.dashboard')
            @section('search_form')
                @include('OPDMS.reception.partials.search_form')
            @endsection
        @endcomponent
    @endsection



    @section('content')



        {{-- modals goes here --}}

            @include('OPDMS.partials.modals.modal_container');

        {{--@include('OPDMS.partials.modals.patient_information') --}}{{-- patient information --}}{{--
        @include('OPDMS.reception.modals.patient_assignation') --}}{{-- patient assignation --}}{{--
        @include('OPDMS.reception.modals.patient_re_assignation') --}}{{-- patient re_assignation --}}{{--
        @include('OPDMS.partials.modals.medical_records') --}}{{-- medical records --}}{{--
        @include('OPDMS.partials.modals.consultation_show') --}}{{-- consultation show records --}}{{--
        @include('OPDMS.partials.modals.nurse_notes') --}}{{-- nurse notes --}}{{--
        @include('OPDMS.partials.modals.vital_signs_form') --}}{{-- nurse notes --}}{{--
        @include('OPDMS.partials.modals.notifications')--}}{{-- notification status goes here --}}



        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            @include('OPDMS.partials.boilerplate.header',
            ['header' => 'Search Patients', 'sub' => 'Showing all matching patients found with your search query.'])

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">

                        <div class="box-body">

                            {{-- patient queued goes here --}}
                            <div class="table-responsive selectable_table" id="queue_table">
                                <table class="table table-bordered table-striped table-hover" id="dataTable2">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>No#</th>
                                        <th>Hospital_No.</th>
                                        <th>QR Code</th>
                                        <th>Patient Name</th>
                                        <th>Birthday</th>
                                        <th>Age</th>
                                        <th>Address</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!$patients->isEmpty())
                                        @php $loop_count = $patients->perPage() * ($patients->currentPage() - 1) + 1; @endphp
                                        @foreach($patients as $patient)
                                            <tr v-on:click.prevent="patient_check($event, {{ $patient->id }})">
                                                <td class="selected_icon">
                                                    <i class="fa fa-circle-o fa-lg text-muted"></i>
                                                </td>
                                                <td>{{ $loop_count++ }}</td>


                                                {{-- notification for last consultation, referral, follow-up please uncomment
                                                 if notification needed --}}

                                                {{--<td>
                                                    @if($queue->ls_date)
                                                        <div class="text-green small">
                                                            Last consultation: {{ Carbon::parse($queue->ls_date)->toFormattedDateString() }} <br>
                                                            Consulted by:
                                                            <span class="text-uppercase">
                                                                DR. {{ $queue->ls_last_name.' '.$queue->ls_first_name }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if($queue->followupdate)
                                                        <div class="text-info small">
                                                            Scheduled today for follow-up <br>
                                                            Follow-up to:
                                                            <span class="text-uppercase">
                                                                DR. {{ $queue->ff_last_name.' '.$queue->ff_first_name }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if($queue->rpid)
                                                        <div class="text-orange small">
                                                            Referral from: {{ $queue->rf_clinic }} <br>
                                                            Referred by:
                                                            <span class="text-uppercase">
                                                                DR. {{ $queue->rb_last_name.' '.$queue->rb_first_name }}
                                                            </span> <br>
                                                            @if($queue->rt_last_name)
                                                                Referred to:
                                                                <span class="text-uppercase">
                                                                    DR. {{ $queue->rt_last_name.' '.$queue->rt_first_name }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    @if(!$queue->ls_date && !$queue->followupdate && !$queue->rpid)
                                                        <strong class="text-muted">None</strong>
                                                    @endif
                                                </td>--}}

                                                <td>{{ $patient->hospital_no }}</td>
                                                <td>{{ $patient->barcode }}</td>
                                                <td>
                                                    {{-- patient name --}}
                                                    <strong class="text-primary text-uppercase">
                                                        {{ $patient->last_name.', '.$patient->first_name.' '.
                                                    $patient->suffix.' '.$patient->middle_name }}
                                                    </strong>
                                                </td>
                                                <td>{{ Carbon::parse($patient->birthday)->toFormattedDateString() }}</td>
                                                <td>
                                                    {{-- patient age --}}
                                                    @php $age = App\Patient::age($patient->birthday) @endphp
                                                    @if($age >= 60)
                                                        <strong class="text-red">
                                                            {{ $age }}
                                                        </strong>
                                                    @else
                                                        {{ $age }}
                                                    @endif
                                                </td>
                                                <td>{{ $patient->address }}</td>




                                                {{-- Charging Notification please uncomment if charging needed --}}
                                                {{--<td>
                                                    @if($queue->request_total)
                                                        <span class="label label-info">Request {{ $queue->request_total or 0 }}</span> <br>
                                                        <span class="label label-success">Paid {{ $queue->paid_total or 0 }}</span>
                                                    @else
                                                        <strong class="text-muted">None</strong>
                                                    @endif
                                                </td>--}}



                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="8" class="text-center">
                                            {{ $patients->links() }}
                                        </th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing all matching patients found with your search query.
                                </em>
                            </small>
                        </div>

                    </div>



                </section>
                <!-- /.content -->

            </div>
            <!-- /.content-wrapper -->
        @endsection



        @section('footer')
            @include('OPDMS.partials.boilerplate.footer')
        @endsection



        @section('aside')
            @include('OPDMS.partials.boilerplate.aside')
        @endsection



        {{-- vue element end of div --}}
        @section('vue-container-end')
    </div>
@endsection


@section('pluginscript')
    <script src="{{ asset('public/plugins/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/preventDelete.js') }}"></script>
@endsection


@section('pagescript')
    <script src="{{ asset('public/OPDMS/vue/reception/queue.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/reception/notification.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/partials/texteditor.js') }}"></script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
@endsection


@endcomponent