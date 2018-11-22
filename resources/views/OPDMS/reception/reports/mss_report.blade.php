@component('OPDMS.partials.header')


    @slot('title')
        MSS Report
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


        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            @include('OPDMS.partials.boilerplate.header',
            ['header' => 'MSS Report', 'sub' => 'Showing medical social service report.'])

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">



                        <div class="box-body">

                            <form class="form-inline" method="GET" target="_blank">
                                <label>TYPE</label>
                                <select class="form-control" name="type" required>
                                    <option value="" hidden>Select</option>
                                    <option value="all">ISSUANCE ALL</option>
                                    <option value="c">MSS ISSUANCE CLASS-C</option>
                                    <option value="d">MSS ISSUANCE CLASS-D</option>
                                    <!-- <option value="d">SERVICES</option> -->
                                </select>

                                <label>FROM</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="date" name="from" class="form-control" @if(isset($_GET['to'])) value="{{  $_GET['from'] }}" @endif required>
                                </div>

                                <label>TO</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="date" name="to" class="form-control" @if(isset($_GET['to'])) value="{{  $_GET['to']  }}" @endif required>
                                </div>
                                <button type="submit" class="btn btn-success btn-flat">
                                    <span class="fa fa-cog"></span> GENERATE
                                </button>
                            </form>
                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing a detailed demographic census of registered patients.
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
@endsection


@section('pagescript')
    <script src="{{ asset('public/OPDMS/vue/reception/queue.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/reception/notification.js') }}"></script>

@endsection


@endcomponent