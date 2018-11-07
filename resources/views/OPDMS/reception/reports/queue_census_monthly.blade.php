@component('OPDMS.partials.header')


    @slot('title')
        Queue Census Monthly
    @endslot


@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_queue.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/partials/patient_information.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/notification.css') }}" />
    <link href="{{ asset('public/css/receptions/status.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/receptions/reports/monitoring.css') }}" rel="stylesheet" />
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
            ['header' => 'Queuing Census Monthly', 'sub' => 'Showing daily queuing census of this clinic.'])

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        @include('OPDMS.reception.reports.queue_census_search_form')



                        <div class="box-body">



                            @php
                                $st = Carbon::parse($start);
                                $et = Carbon::parse($end);
                                $begin = Carbon::parse($start)->month;
                                $final = Carbon::parse($end)->month + 1;
                                $noDoctorsClinic = array(10,48,22,21);
                                $sum = array();
                            @endphp

                            <div class="table-responsive monthlyTableWrapper">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">Status</th>
                                        <th colspan="31" class="text-center">Month</th>
                                    </tr>
                                    <tr>
                                        @for($i=$begin;$i<$final;$i++)
                                            <th class="text-center">{{ Carbon::parse("2018-$i-01")->format('F') }}</th>
                                        @endfor
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="finishedTabActive">
                                        <td>
                                            {{  (!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'Finished' : 'Done' }}
                                        </td>
                                        @for($i=$begin;$i<$final;$i++)
                                            @php
                                                $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                                $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                                $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                                //$stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'D' : 'F' ;
                                                if (in_array(Auth::user()->clinic, $noDoctorsClinic)){
                                                    if (Auth::user()->clinic == 22 || Auth::user()->clinic == 21){
                                                        $stat = 'D';
                                                    }else{
                                                        $stat = 'F';
                                                    }
                                                }else{
                                                    $stat = 'F';
                                                }
                                                $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, $stat);
                                                (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i] = $result;
                                            @endphp
                                            <td class="text-center">{{ $result }}</td>
                                        @endfor
                                    </tr>

                                    @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                                        <tr class="servingTabActive">
                                            <td>
                                                @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                                                    Serving
                                                @else
                                                    @if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21)
                                                        Posted Result
                                                    @else
                                                        Finished
                                                    @endif
                                                @endif
                                            </td>
                                            @for($i=$begin;$i<$final;$i++)
                                                @php
                                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                                    $stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'F' : 'S' ;
                                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, $stat);
                                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                                @endphp
                                                <td class="text-center">{{ $result }}</td>
                                            @endfor
                                        </tr>
                                    @endif

                                    <tr class="pendingTabActive">
                                        <td>Pending</td>
                                        @for($i=$begin;$i<$final;$i++)
                                            @php
                                                $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                                $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                                $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                                $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, 'P');
                                                (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                            @endphp
                                            <td class="text-center">{{ $result }}</td>
                                        @endfor
                                    </tr>
                                    @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                                        <tr class="pausedTabActive">
                                            <td>Paused</td>
                                            @for($i=$begin;$i<$final;$i++)
                                                @php
                                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, 'H');
                                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                                @endphp
                                                <td class="text-center">{{ $result }}</td>
                                            @endfor
                                        </tr>
                                    @endif
                                    <tr class="nawcTabActive">
                                        <td>NAWC</td>
                                        @for($i=$begin;$i<$final;$i++)
                                            @php
                                                $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                                $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                                $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                                $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, 'C');
                                                (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                            @endphp
                                            <td class="text-center">{{ $result }}</td>
                                        @endfor
                                    </tr>
                                    @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                                        <tr class="unassignedTabActive">
                                            <td>Unassigned</td>
                                            @for($i=$begin;$i<$final;$i++)
                                                @php
                                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, 'U');
                                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                                @endphp
                                                <td class="text-center">{{ $result }}</td>
                                            @endfor
                                        </tr>
                                    @endif

                                    </tbody>

                                    <tfoot>

                                    <tr class="">
                                        <th>Total</th>
                                        @for($i=$begin;$i<$final;$i++)
                                            <th class="text-center">{{ $sum['m'.$i] }}</th>
                                        @endfor
                                    </tr>


                                    @if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21)
                                        <tr class="">
                                            <td colspan="{{ $final }}"><br></td>
                                        </tr>


                                        <tr class="servingTabActive">
                                            <td>
                                                @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
                                                    Serving
                                                @else
                                                    @if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21)
                                                        Posted Result
                                                    @else
                                                        Finished
                                                    @endif
                                                @endif
                                            </td>
                                            @for($i=$begin;$i<$final;$i++)
                                                @php
                                                    $day = Carbon::create($et->year, $i)->endOfMonth()->day;
                                                    $startingDate = Carbon::createFromDate($st->year, $i, 01)->toDateString();
                                                    $endingDate = Carbon::createFromDate($et->year, $i, $day)->toDateString();
                                                    $stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'F' : 'S' ;
                                                    $result = App\Http\Controllers\MonitoringController::monitorMonthly($startingDate, $endingDate, $stat);
                                                    (array_key_exists('m'.$i, $sum))? $sum['m'.$i] += $result : $sum['m'.$i];
                                                @endphp
                                                <td class="text-center">{{ $result }}</td>
                                            @endfor
                                        </tr>
                                    @endif

                                    </tfoot>
                                </table>
                            </div>







                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing monthly queuing census of this clinic.
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
    <script src="{{ asset('public/js/receptions/reports.js') }}"></script>

    @if(Session::has('census') && Session::get('census') == 'monthly')
        <script>
            $(document).ready(function () {
                $('.monthlyBtn').click();
            });
        </script>
    @endif

@endsection


@endcomponent