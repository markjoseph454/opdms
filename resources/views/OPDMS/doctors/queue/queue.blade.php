@component('OPDMS.partials.header')


    @slot('title')
        Doctors Queue
    @endslot


@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_queue.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/partials/patient_information.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_assignation.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/notification.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/partials/consultation_all.css') }}" />
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

            @include('OPDMS.doctors.modals.modal_container');

            @include('OPDMS.partials.modals.modal_container');




            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            @include('OPDMS.partials.boilerplate.header',
            ['header' => 'Patients Queue', 'sub' => 'All patients that was been queued and assigned to you will be shown here.'])

            <!-- Main content -->
                <section class="content container-fluid">


                    <div class="box box-default">

                        @include('OPDMS.doctors.queue.header_status'){{-- patient status goes here --}}

                        <div class="box-body">

                            {{-- patient queued goes here --}}
                            <div class="table-responsive selectable_table" id="queue_table">

                                <table class="table table-bordered table-striped table-hover doctors_queue_table" id="dataTable3">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>No#</th>
                                            <th>Patient Name</th>
                                            <th>Age</th>
                                            <th>Status</th>
                                            <th>Time Assigned</th>
                                            <th>Time Queued</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(!$queues->isEmpty())
                                        @php $loop_count = $queues->perPage() * ($queues->currentPage() - 1) + 1; @endphp
                                        @foreach($queues as $queue)
                                            <tr v-on:click.prevent="patient_check($event, {{ $queue->pid }})">
                                                <td class="selected_icon">
                                                    <i class="fa fa-circle-o fa-lg text-muted"></i>
                                                </td>
                                                <td>{{ $loop_count++ }}</td>
                                                <td>
                                                    {{-- patient name --}}
                                                    <strong class="text-primary text-uppercase">
                                                        {{ $queue->last_name.', '.$queue->first_name.' '.
                                                    $queue->suffix.' '.$queue->middle_name }}
                                                    </strong>
                                                </td>
                                                <td>
                                                    {{-- patient age --}}
                                                    @php $age = App\Patient::age($queue->birthday) @endphp
                                                    @if($age >= 60)
                                                        <strong class="text-red">
                                                            {{ $age }}
                                                        </strong>
                                                    @else
                                                        {{ $age }}
                                                    @endif
                                                </td>
                                                {{-- queue status --}}
                                                @include('OPDMS.doctors.queue.queue_status')
                                                <td>
                                                    @if($queue->assigned_time)
                                                        Today {{ Carbon::parse($queue->assigned_time)->format('h:i a') }}
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ Carbon::parse($queue->assigned_time)->diffForHumans() }}
                                                        </small>
                                                    @else
                                                        <strong class="text-muted">None</strong>
                                                    @endif
                                                </td>
                                                <td>
                                                    Today {{ Carbon::parse($queue->queue_time)->format('h:i a') }}
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ Carbon::parse($queue->queue_time)->diffForHumans() }}
                                                    </small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="7" class="text-center">
                                            {{ $queues->links() }}
                                        </th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing todays queued patients.
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
    <script src="{{ asset('public/OPDMS/js/partials/consultationeditor.js') }}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>



@endsection


@endcomponent