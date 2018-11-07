@component('OPDMS.partials.header')


    @slot('title')
        Demographic Summary Census
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
            ['header' => 'Demographic Detailed Census', 'sub' => 'Showing a detailed demographic census of registered patients.'])

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        @include('OPDMS.reception.reports.demographic_summary_search_form')


                        <div class="box-body">



                            @if($final)

                                <div class="col-md-4">

                                    <div class="table-responsive demographicSummary">
                                        <table class="table table-bordered">
                                            <thead>
                                            <th>CITY/MUNICIPALITY</th>
                                            <th>NEW</th>
                                            <th>OLD</th>
                                            </thead>
                                            <tbody>



                                            <tr class="leyte">
                                                <td colspan="3" class="text-center"><strong>LEYTE</strong></td>
                                            </tr>
                                            <tr class="leyte">
                                                <td>TACLOBAN</td>
                                                <td>{{ $final['TN'] }}</td>
                                                <td>{{ $final['TO'] }}</td>
                                            </tr>
                                            @for($i=1;$i<6;$i++)
                                                @php
                                                    if($i == 1){
                                                        $dis = '1st';
                                                    }elseif($i == 2){
                                                        $dis = '2nd';
                                                    }elseif($i == 3){
                                                        $dis = '3rd';
                                                    }elseif($i == 4){
                                                        $dis = '4th';
                                                    }else{
                                                        $dis = '5th';
                                                    }
                                                @endphp
                                                <tr class="leyte">
                                                    <td>{{ $dis }}</td>
                                                    <td>{{ $final['LN'.$i] }}</td>
                                                    <td>{{ $final['LO'.$i] }}</td>
                                                </tr>
                                            @endfor
                                            <tr class="wsamar">
                                                <td colspan="3" class="text-center"><strong>W-SAMAR</strong></td>
                                            </tr>
                                            @for($i=1;$i<3;$i++)
                                                @php
                                                    if($i == 1){
                                                        $dis = '1st';
                                                    }elseif($i == 2){
                                                        $dis = '2nd';
                                                    }
                                                @endphp
                                                <tr class="wsamar">
                                                    <td>{{ $dis }}</td>
                                                    <td>{{ $final['WSN'.$i] }}</td>
                                                    <td>{{ $final['WSO'.$i] }}</td>
                                                </tr>
                                            @endfor
                                            <tr class="esamar">
                                                <td colspan="3" class="text-center"><strong>E-SAMAR</strong></td>
                                            </tr>
                                            @for($i=1;$i<3;$i++)
                                                @php
                                                    if($i == 1){
                                                        $dis = '1st';
                                                    }elseif($i == 2){
                                                        $dis = '2nd';
                                                    }
                                                @endphp
                                                <tr class="esamar">
                                                    <td>{{ $dis }}</td>
                                                    <td>{{ $final['ESN'.$i] }}</td>
                                                    <td>{{ $final['ESO'.$i] }}</td>
                                                </tr>
                                            @endfor
                                            <tr class="nsamar">
                                                <td colspan="3" class="text-center"><strong>N-SAMAR</strong></td>
                                            </tr>
                                            @for($i=1;$i<3;$i++)
                                                @php
                                                    if($i == 1){
                                                        $dis = '1st';
                                                    }elseif($i == 2){
                                                        $dis = '2nd';
                                                    }
                                                @endphp
                                                <tr class="nsamar">
                                                    <td>{{ $dis }}</td>
                                                    <td>{{ $final['NSN'.$i] }}</td>
                                                    <td>{{ $final['NSO'.$i] }}</td>
                                                </tr>
                                            @endfor
                                            <tr class="sleyte">
                                                <td colspan="3" class="text-center"><strong>S-LEYTE</strong></td>
                                            </tr>
                                            @for($i=1;$i<3;$i++)
                                                @php
                                                    if($i == 1){
                                                        $dis = '1st';
                                                    }elseif($i == 2){
                                                        $dis = '2nd';
                                                    }
                                                @endphp
                                                <tr class="sleyte">
                                                    <td>{{ $dis }}</td>
                                                    <td>{{ $final['SLN'.$i] }}</td>
                                                    <td>{{ $final['SLO'.$i] }}</td>
                                                </tr>
                                            @endfor
                                            <tr class="biliran">
                                                <td colspan="3" class="text-center"><strong>BILIRAN</strong></td>
                                            </tr>
                                            @for($i=1;$i<3;$i++)
                                                @php
                                                    if($i == 1){
                                                        $dis = '1st';
                                                    }elseif($i == 2){
                                                        $dis = '2nd';
                                                    }
                                                @endphp
                                                <tr class="biliran">
                                                    <td>{{ $dis }}</td>
                                                    <td>{{ $final['BN'.$i] }}</td>
                                                    <td>{{ $final['BO'.$i] }}</td>
                                                </tr>
                                            @endfor
                                            <tr class="totalSum">
                                                <td>TOTAL</td>
                                                <td>{{ $new }}</td>
                                                <td>{{ $old }}</td>
                                            </tr>
                                            <tr class="totalSum">
                                                <td>GRAND TOTAL</td>
                                                <td colspan="2" class="text-center">{{ $new + $old }}</td>
                                            </tr>


                                            </tbody>
                                        </table>
                                    </div>

                                </div>


                            @else
                                <hr>
                                @if(!$starting)
                                    <h4 class="text-center text-danger">Please select a date to be retrieve. <i class="fa fa-calendar"></i></h4>
                                @else
                                    <h4 class="text-center text-danger">No results found <i class="fa fa-exclamation"></i></h4>
                                @endif
                                <hr>
                            @endif


                            @if($final)
                                <div class="col-md-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <th></th>
                                            <th>NEW</th>
                                            <th>OLD</th>
                                            <th>TOTAL</th>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>SENIOR CITIZEN</td>
                                                <td>{{ $csn }}</td>
                                                <td>{{ $cso }}</td>
                                                <td><strong class="text-danger">{{ $csn + $cso }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>GERIA</td>
                                                <td>{{ $geriaN }}</td>
                                                <td>{{ $geriaO }}</td>
                                                <td><strong class="text-danger">{{ $geriaN + $geriaO }}</strong></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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