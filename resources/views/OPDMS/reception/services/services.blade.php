@component('OPDMS.partials.header')


    @slot('title')
        Services
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

            @include('OPDMS.reception.services.services_add')






            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            @include('OPDMS.partials.boilerplate.header',
            ['header' => 'Ancillary items & Services offered', 'sub' =>
            'Shown here are all the ancillary items & services offered by this clinic.'])

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        <div class="box-header with-border">

                            <?php
                                $active = 0;
                                $inactive = 0;
                                foreach($data as $row){
                                    if ($row->status == 'active'){
                                        $active = $row->total;
                                    }
                                    if ($row->status == 'inactive'){
                                        $inactive = $row->total;
                                    }
                                }
                            ?>
                            {{--<a href="" class="btn bg-green-inverse btn-flat">
                                Export to PDF <i class="fa fa-file-pdf-o"></i>
                            </a>--}}
                            <button class="btn bg-aqua-gradient btn-flat" v-on:click="service_add">
                                Add Service <i class="fa fa-plus"></i>
                            </button>
                            <a href="{{ url('services_offered/A') }}" class="btn bg-green btn-flat"
                            onclick="full_window_loader()">
                                Active <span class="badge">{{ $active }}</span>
                            </a>
                            <a href="{{ url('services_offered/I') }}" class="btn bg-red btn-flat"
                               onclick="full_window_loader()">
                                Inactive <span class="badge">{{ $inactive }}</span>
                            </a>
                            <a href="{{ url('services_offered') }}" class="btn bg-black btn-flat"
                               onclick="full_window_loader()">
                                All <span class="badge">{{ $active + $inactive }}</span>
                            </a>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" id="dataTable1">
                                    <thead>
                                    <tr>
                                        <th>Service Description</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!$services->isEmpty())
                                        @foreach($services as $service)
                                            <tr>
                                                <td class="text-blue text-bold">{{ $service->sub_category }}</td>
                                                <td>&#8369; {{ number_format($service->price, 2) }}</td>
                                                <td>
                                                    @if($service->status == 'active')
                                                        <label class="label label-success">
                                                            Active
                                                        </label>
                                                    @else
                                                        <label class="label label-danger">
                                                            Inactive
                                                        </label>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button v-on:click="service_edit({{ $service->sub_id }})" class="btn bg-blue btn-sm btn-flat">
                                                        <i class="fa fa-pencil"></i> Edit
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
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
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>

    @if ($errors->has('sub_category') || $errors->has('price'))
        <script>
            $('#services_add_modal').modal();
        </script>
    @endif


    <script>
        $('#services_add_form').on('submit', function () {
            $('#services_add_modal .loaderRefresh').fadeIn(0);
        });
    </script>

@endsection


@endcomponent