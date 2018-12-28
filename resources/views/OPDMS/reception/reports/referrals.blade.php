@component('OPDMS.partials.header')


    @slot('title')
        Referrals Report
    @endslot


@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_queue.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/partials/patient_information.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_assignation.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/notification.css') }}" />
    <link href="{{ asset('public/css/receptions/demographic.css') }}" rel="stylesheet" />
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
            ['header' => 'Referrals Report', 'sub' => 'Showing all referrals from this clinic.'])

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        @include('OPDMS.reception.reports.referrals_search_form')


                        <div class="box-body">


                            @if($starting)
                                @if(!$refferals->isEmpty())
                                    @php $total = 0; @endphp
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="bg-primary">
                                                <th>Total</th>
                                                <th>Referred To Clinic</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($refferals as $row)
                                                <tr>
                                                    <td>{{ $row->total }}</td>
                                                    <td>{{ $row->name }}</td>
                                                </tr>
                                                @php $total+=$row->total @endphp
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr class="bg-primary">
                                                <td>{{ $total }}</td>
                                                <td>Total</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-danger text-center">
                                        <h5>No Results Found!</h5>
                                    </div>
                                @endif
                            @else

                                <hr/>
                                <h4 class="text-center text-danger">Please select a date to retrieve data</h4>
                                <hr/>

                            @endif




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