@component('OPDMS.partials.header')


    @slot('title')
        Follow Notifications
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

            @include('OPDMS.partials.modals.modal_container');

        {{--@include('OPDMS.reception.modals.patient_assignation') --}}{{-- patient assignation --}}{{--
        @include('OPDMS.reception.modals.patient_re_assignation') --}}{{-- patient re_assignation --}}{{--
        @include('OPDMS.partials.modals.medical_records') --}}{{-- medical records --}}{{--
        @include('OPDMS.partials.modals.consultation_show') --}}{{-- consultation show records --}}{{--
        @include('OPDMS.partials.modals.nurse_notes') --}}{{-- nurse notes --}}{{--
        --}}{{--@include('OPDMS.partials.modals.notifications')--}}{{----}}{{-- notification status goes here --}}{{--
        @include('OPDMS.partials.modals.patient_notifications')--}}{{-- notification status goes here --}}{{--
        @include('OPDMS.partials.modals.patient_information') --}}{{-- patient information --}}{{--
        @include('OPDMS.partials.modals.vital_signs_form') --}}{{-- nurse notes --}}



        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            @include('OPDMS.partials.boilerplate.header',
            ['header' => 'Follow-up Patients', 'sub' => 'Showing all patients that has a scheduled follow-up.'])

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        <div class="box-header with-border">
                            <form action="{{ url('followup_notifications') }}" method="get" class="form-inline">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="start" class="form-control datepicker1" placeholder="Starting Date"
                                           data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="{{ $start }}" />
                                </div>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="end" class="form-control datepicker1" placeholder="Ending Date"
                                           data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="{{ $end }}" />
                                </div>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </div>
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Enter Patient Name"/>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-flat bg-green" onclick="full_window_loader()">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="box-body">


                            {{-- patient queued goes here --}}
                            <div class="table-responsive selectable_table" id="queue_table">
                                <table class="table table-bordered table-striped table-hover" id="dataTable2">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>No#</th>
                                        <th>Patient Name</th>
                                        <th>Age</th>
                                        <th>Clinic</th>
                                        <th>Consulted/Assisted By</th>
                                        <th>Follow-up To</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Follow-up Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($queues)
                                        @foreach($queues as $queue)
                                            <tr v-on:click.prevent="patient_check($event, {{ $queue->pid }})">
                                                <td class="selected_icon">
                                                    <i class="fa fa-circle-o fa-lg text-muted"></i>
                                                </td>
                                                <td>{{ $loop->index + 1 }}</td>
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
                                                <td>{{ $queue->name }}</td>
                                                <td>
                                                    {{-- consulted by doctor name --}}
                                                    <strong class="text-primary text-uppercase">
                                                        {{ $queue->u_last_name.', '.$queue->u_first_name.' '.
                                                        $queue->u_middle_name }}
                                                    </strong>
                                                </td>
                                                <td>
                                                    {{-- consulted by doctor name --}}
                                                    @if($queue->ft_last_name)
                                                        <strong class="text-primary text-uppercase">
                                                            {{ $queue->ft_last_name.', '.$queue->ft_first_name.' '.
                                                            $queue->ft_middle_name }}
                                                        </strong>
                                                    @endif
                                                </td>
                                                <td>{{ $queue->reason }}</td>
                                                <?php
                                                    if ($queue->status == 'F'){
                                                        $status_text = 'Finished';
                                                        $status_color = 'label-info';
                                                    }else{
                                                        $status_text = 'Pending';
                                                        $status_color = 'label-warning';
                                                    }
                                                ?>
                                                <td>
                                                    <span class="label {{ $status_color }}">
                                                        {{ $status_text }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ Carbon::parse($queue->followupdate)->format('M d, Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing all patients that has been charged.
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
    <script src="{{ asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
@endsection


@section('pagescript')
    <script src="{{ asset('public/OPDMS/vue/reception/queue.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/reception/notification.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/partials/texteditor.js') }}"></script>
    <script>
        $('[data-mask]').inputmask()
    </script>
@endsection


@endcomponent