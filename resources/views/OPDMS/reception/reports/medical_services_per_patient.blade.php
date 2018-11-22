@component('OPDMS.partials.header')


    @slot('title')
        Medical Services Per Patient
    @endslot


@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_queue.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/partials/patient_information.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_assignation.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/notification.css') }}" />
    <link href="{{ asset('public/css/ancillary/census.css') }}" rel="stylesheet" />
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
            ['header' => 'Medical Services Per Patient', 'sub' => 'Showing all the total number of patient per services.'])

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default">


                        @include('OPDMS.reception.reports.medical_services_per_patient_search_form')


                        <div class="box-body">

                            <div>
                                @if (isset($_GET['from']))
                                    <label>TOTAL NUMBER OF PATIENT PER SERVICES - DATE:
                                        {{  Carbon::parse($_GET['from'])->format('M-d-Y').' to '.Carbon::parse($_GET['to'])->format('M-d-Y') }}</label>
                                @endif
                            </div>


                            <div class="table-responsive" id="rankindiv">
                                <table class="table table-bordered table-stripped">
                                    <thead>
                                        <tr>
                                            <th>RANKING</th>
                                            <th>PARTICULAR</th>
                                            <th>FEMALE</th>
                                            <th>MALE</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $l = 1;
                                        $total = 0;
                                        $female = 0;
                                        $male = 0;
                                    @endphp

                                    @if(count($census) > 0)
                                        @foreach($census as $list)
                                            <tr>
                                                <td align="center">{{ $l }}</td>
                                                <td>{{ $list->sub_category }}</td>
                                                <td align="center" class="">{{ $list->female }}</td>
                                                <td align="center" class="">{{ $list->male }}</td>
                                                <td align="center" class="">@if(Auth::user()->clinic == "3") {{ $list->person }} @else {{ $list->result }} @endif</td>

                                            </tr>

                                            @php

                                                $l++;

                                                $female += $list->female;
                                                $male += $list->male;

                                                if(Auth::user()->clinic == "3"):
                                                $total += $list->person;
                                                else:
                                                $total += $list->result;
                                                endif;

                                            @endphp

                                        @endforeach

                                        @php
                                            $m = 0;
                                            $f = 0;
                                        @endphp

                                        @if(Auth::user()->clinic == "3")
                                            @foreach($consultation as $list)
                                                @if($list->sex == "M")
                                                    @php
                                                        $m++
                                                    @endphp
                                                @endif
                                                @if($list->sex == "F")
                                                    @php
                                                        $f++
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td colspan="5" class=""></td>

                                            </tr>
                                            <tr>
                                                <td colspan="2" class="success text-right"><b>TOTAL SERVICES:</b></td>
                                                <td align="center" class="success"><b>{{ $female }}</b></td>
                                                <td align="center" class="success"><b>{{ $male }}</b></td>
                                                <td align="center" class="success"><b>{{ $total }}</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class=""></td>

                                            </tr>
                                            <tr>
                                                <td colspan="2" class="success text-right">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<b>TOTAL CONSULTATION:</b></td>
                                                <td align="center" class="success"><b>{{ $f - $female  }}</b></td>
                                                <td align="center" class="success"><b>{{ $m - $male}}</b></td>
                                                <td align="center" class="success"><b>{{ count($consultation) - $total }}</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class=""></td>

                                            </tr>
                                            <tr>
                                                <th colspan="2" style="text-align: right;">GRAND TOTAL:</th>
                                                <th>{{ $female + ($f - $female) }}</th>
                                                <th>{{ $male + ($m - $male) }}</th>
                                                <th>{{ count($consultation) }}</th>
                                            </tr>
                                        @else
                                            <tr>
                                                <th colspan="2" style="text-align: right;">GRAND TOTAL:</th>
                                                <th colspan="">{{ $female }}</th>
                                                <th colspan="">{{ $male }}</th>
                                                <th colspan="">{{  $total }}</th>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <td colspan="5" class="default" align="center" >NO RESULT FOUND</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>





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