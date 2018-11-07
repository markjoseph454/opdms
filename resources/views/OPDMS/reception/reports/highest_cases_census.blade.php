@component('OPDMS.partials.header')


    @slot('title')
        Highest Cases Census
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
            ['header' => 'Highest Cases Census', 'sub' => 'Showing all the highest cases per demographic area.'])

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">



                        @include('OPDMS.reception.reports.highest_case_search_form')



                        <div class="box-body">


                            @if($starting && $ending)


                                @php
                                    $clinic = App\Clinic::find(Auth::user()->clinic);
                                    $clinicName = $clinic->name;
                                    $grandTotal = 0;
                                    $monthTotal = array();
                                @endphp

                                <div class="table-responsive" id="highestCasesTable">
                                    <table class="table table-bordered">

                                        <tr>
                                            <td class="text-center">
                                                {{ strtoupper($clinicName) }}
                                            </td>
                                            @php
                                                $colSpan = ((Carbon::parse($ending)->month + 1) - Carbon::parse($starting)->month) * 3;
                                            @endphp
                                            <td colspan="{{ $colSpan }}" class="text-center">MONTH</td>
                                            <td rowspan="3">
                                                TOTAL PER AREA <br>
                                                <small>(No. of Consultations)</small>
                                            </td>
                                            <td rowspan="3">
                                                TOTAL PER AREA <br>
                                                <small>(Referrals From)</small>
                                            </td>
                                            <td rowspan="3">
                                                TOTAL PER AREA <br>
                                                <small>(Referrals To)</small>
                                            </td>
                                        </tr>




                                        <tr>
                                            <td rowspan="2">
                                                NAME OF PROVINCES / AREAS CASES
                                            </td>

                                            @for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++)
                                                <td colspan="3" class="text-center bg-info">
                                                    {{ Carbon::parse("2018-$i-01")->format('F') }}
                                                </td>
                                                @php
                                                    $monthTotal['m'.$i] = 0;
                                                @endphp
                                            @endfor
                                        </tr>




                                        <tr>
                                            @for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++)
                                                <td>No. of Consultations</td>
                                                <td>Referrals (FROM)</td>
                                                <td>Referrals (TO)</td>
                                            @endfor
                                        </tr>




                                        {{-- for leyte reports --}}

                                        @foreach($leyte as $row)

                                            <tr class="bg-success leyte">
                                                <?php
                                                switch ($row->district){
                                                    case 1:
                                                        $distrito = '1st';
                                                        break;
                                                    case 2:
                                                        $distrito = '2nd';
                                                        break;
                                                    case 3:
                                                        $distrito = '3rd';
                                                        break;
                                                    case 4:
                                                        $distrito = '4th';
                                                        break;
                                                    default:
                                                        $distrito = '5th';
                                                        break;
                                                }
                                                ?>
                                                <td>
                                                    <strong>{{ ($loop->first)? $row->citymunDesc : $row->provDesc.' '.$distrito.' District' }}</strong>
                                                </td>
                                                @for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 2; $i++)
                                                    <td {!! 'id="m'.$i.$row->citymunCode.'"' !!}></td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                @endfor
                                            </tr>




                                            <tr class="leyte">
                                                @php
                                                    $totalPerRow = 0;
                                                    $sumPerColumn = array();
                                                @endphp
                                                @for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++)
                                                    @php
                                                        $year = Carbon::parse($starting)->year;
                                                        $date = Carbon::create($year, $i)->format('Y-m');
                                                        $tacloban = App\Radiology::highestCases($date, $row->citymunCode, $row->provCode, $row->district, $row->regCode);
                                                        if ($tacloban){
                                                            $cid = $tacloban[0]->cid;
                                                            (array_key_exists('m'.$i, $monthTotal)) ? $monthTotal['m'.$i] += $tacloban[0]->highest : $monthTotal['m'.$i] = $tacloban[0]->highest;
                                                        }
                                                    @endphp
                                                    @if($i == Carbon::parse($starting)->month)
                                                        <td style="padding-left: 40px">
                                                            Highest Case:
                                                            <strong>{{ $tacloban[0]->subcategory or '' }}</strong>
                                                        </td>
                                                    @endif
                                                    <td>{{ $tacloban[0]->highest or 0 }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    @php
                                                        $totalPerRow += ($tacloban)? $tacloban[0]->highest : 0;
                                                        $sumPerColumn['s'.$i] = ($tacloban)? $tacloban[0]->highest : 0;
                                                    @endphp
                                                @endfor
                                                <td>{{ $totalPerRow }}</td>
                                                <td></td>
                                                <td></td>
                                                @php
                                                    $grandTotal += $totalPerRow;
                                                @endphp
                                            </tr>


                                            <tr class="leyte">
                                                @php
                                                    $totalPerOthersRow = 0;
                                                @endphp
                                                @for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++)
                                                    @if($tacloban)
                                                        @php
                                                            $year = Carbon::parse($starting)->year;
                                                            $date = Carbon::create($year, $i)->format('Y-m');
                                                            $taclobanOther = App\Radiology::otherCases($date, $row->citymunCode, $cid, $row->provCode, $row->district, $row->regCode);
                                                        @endphp
                                                    @endif
                                                    @if($i == Carbon::parse($starting)->month)
                                                        <td style="padding-left: 40px">
                                                            {{ $clinicName }} Total Cases:
                                                        </td>
                                                    @endif
                                                    <td>
                                                        @if($tacloban)
                                                            {{ $taclobanOther[0]->others or 0 }}
                                                            @php
                                                                $totalPerOthersRow += $taclobanOther[0]->others;
                                                                $sumPerColumn['s'.$i] += $taclobanOther[0]->others;
                                                                (array_key_exists('m'.$i, $monthTotal))? $monthTotal['m'.$i] += $taclobanOther[0]->others : $monthTotal['m'.$i] = 0;
                                                            @endphp
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                    <td></td>
                                                    <td></td>


                                                    <script>
                                                        document.getElementById("m{{ $i.$row->citymunCode }}").innerText {{ "=".$sumPerColumn['s'.$i] }};
                                                    </script>

                                                @endfor
                                                <td>{{ $totalPerOthersRow }}</td>
                                                <td></td>
                                                <td></td>
                                                @php
                                                    $grandTotal += $totalPerOthersRow;
                                                @endphp
                                            </tr>




                                            <script>
                                                document.getElementById("m{{ (Carbon::parse($ending)->month + 1).$row->citymunCode }}").innerText {{ "=" . ($totalPerRow + $totalPerOthersRow) }};
                                            </script>



                                        @endforeach


                                        {{-- end of leyte reports --}}









                                        {{-- for samar and others reports --}}

                                        @foreach($samar as $row)

                                            <?php
                                            switch ($row->district){
                                                case 1:
                                                    $distrito = '1st';
                                                    break;
                                                default:
                                                    $distrito = '2nd';
                                                    break;
                                            }

                                            switch ($row->provCode){
                                                case '0826':
                                                    $province = 'esamar';
                                                    break;
                                                case '0848':
                                                    $province = 'nsamar';
                                                    break;
                                                case '0860':
                                                    $province = 'wsamar';
                                                    break;
                                                case '0864':
                                                    $province = 'sleyte';
                                                    break;
                                                default:
                                                    $province = 'biliran';
                                                    break;
                                            }

                                            ?>
                                            <tr class="bg-success {{ $province }}">
                                                <td>
                                                    <strong>{{ ($loop->first && $row->citymunCode == '083747')? $row->citymunDesc : $row->provDesc.' '.$distrito.' District' }}</strong>
                                                </td>
                                                @for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 2; $i++)
                                                    <td {!! 'id="m'.$i.$row->citymunCode.'"' !!}></td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                @endfor
                                            </tr>

                                            <tr class="{{ $province }}">
                                                @php
                                                    $totalPerRow = 0;
                                                    $sumPerColumn = array();
                                                @endphp
                                                @for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++)
                                                    @php
                                                        $year = Carbon::parse($starting)->year;
                                                        $date = Carbon::create($year, $i)->format('Y-m');
                                                        $tacloban = App\Radiology::highestCases($date, $row->citymunCode, $row->provCode, $row->district, $row->regCode);
                                                        if ($tacloban){
                                                            $cid = $tacloban[0]->cid;
                                                            (array_key_exists('m'.$i, $monthTotal))? $monthTotal['m'.$i] += $tacloban[0]->highest : $monthTotal['m'.$i] = 0;
                                                        }
                                                    @endphp
                                                    @if($i == Carbon::parse($starting)->month)
                                                        <td style="padding-left: 40px">
                                                            Highest Case:
                                                            <strong>{{ $tacloban[0]->subcategory or '' }}</strong>
                                                        </td>
                                                    @endif
                                                    <td>{{ $tacloban[0]->highest or 0 }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    @php
                                                        $totalPerRow += ($tacloban)? $tacloban[0]->highest : 0;
                                                        $sumPerColumn['s'.$i] = ($tacloban)? $tacloban[0]->highest : 0;
                                                    @endphp
                                                @endfor
                                                <td>{{ $totalPerRow }}</td>
                                                <td></td>
                                                <td></td>
                                                @php
                                                    $grandTotal += $totalPerRow;
                                                @endphp
                                            </tr>

                                            <tr class="{{ $province }}">
                                                @php $totalPerOthersRow = 0; @endphp
                                                @for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++)
                                                    @if($tacloban)
                                                        @php
                                                            $year = Carbon::parse($starting)->year;
                                                            $date = Carbon::create($year, $i)->format('Y-m');
                                                            $taclobanOther = App\Radiology::otherCases($date, '083747', $cid, $row->provCode, $row->district, $row->regCode);
                                                        @endphp
                                                    @endif
                                                    @if($i == Carbon::parse($starting)->month)
                                                        <td style="padding-left: 40px">
                                                            {{ $clinicName }} Total Cases:
                                                        </td>
                                                    @endif
                                                    <td>
                                                        @if($tacloban)
                                                            {{ $taclobanOther[0]->others or 0 }}
                                                            @php
                                                                $totalPerOthersRow += $taclobanOther[0]->others;
                                                                $sumPerColumn['s'.$i] += $taclobanOther[0]->others;
                                                                (array_key_exists('m'.$i, $monthTotal))? $monthTotal['m'.$i] += $taclobanOther[0]->others : $monthTotal['m'.$i] = 0;
                                                            @endphp
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                    <td></td>
                                                    <td></td>


                                                    <script>
                                                        document.getElementById("m{{ $i.$row->citymunCode }}").innerText {{ "=".$sumPerColumn['s'.$i] }};
                                                    </script>


                                                @endfor
                                                <td>{{ $totalPerOthersRow }}</td>
                                                <td></td>
                                                <td></td>
                                                @php
                                                    $grandTotal += $totalPerOthersRow;
                                                @endphp
                                            </tr>



                                            <script>
                                                document.getElementById("m{{ (Carbon::parse($ending)->month + 1).$row->citymunCode }}").innerText {{ "=" . ($totalPerRow + $totalPerOthersRow) }};
                                            </script>

                                        @endforeach


                                        {{-- end of samara and others reports --}}












                                        {{-- for outside region 8 reports --}}

                                        <tr class="bg-success outside">
                                            <td>
                                                <strong>Outside Region 8</strong>
                                            </td>
                                            @for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 2; $i++)
                                                <td {!! 'id="m'.$i.'"' !!}></td>
                                                <td>0</td>
                                                <td>0</td>
                                            @endfor
                                        </tr>

                                        <tr class="outside">
                                            @php
                                                $totalPerRow = 0;
                                                $sumPerColumn = array();
                                            @endphp
                                            @for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++)
                                                @php
                                                    $year = Carbon::parse($starting)->year;
                                                    $date = Carbon::create($year, $i)->format('Y-m');
                                                    $tacloban = App\Radiology::highestCases($date, false, false, false, 'outside');
                                                    if (!empty($tacloban)){
                                                        $cid = $tacloban[0]->cid;
                                                        (array_key_exists('m'.$i, $monthTotal))? $monthTotal['m'.$i] += $tacloban[0]->highest : $monthTotal['m'.$i] = 0;
                                                    }
                                                @endphp
                                                @if($i == Carbon::parse($starting)->month)
                                                    <td style="padding-left: 40px">
                                                        Highest Case:
                                                        <strong>{{ ($tacloban)? $tacloban[0]->subcategory : '' }}</strong>
                                                    </td>
                                                @endif
                                                <td>{{ $tacloban[0]->highest or 0 }}</td>
                                                <td></td>
                                                <td></td>
                                                @php
                                                    $totalPerRow += ($tacloban)? $tacloban[0]->highest : 0;
                                                    $sumPerColumn['s'.$i] = ($tacloban)? $tacloban[0]->highest : 0;
                                                @endphp
                                            @endfor
                                            <td>{{ $totalPerRow }}</td>
                                            <td></td>
                                            <td></td>
                                            @php
                                                $grandTotal += $totalPerRow;
                                            @endphp
                                        </tr>

                                        <tr class="outside">
                                            @php $totalPerOthersRow = 0; @endphp
                                            @for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++)
                                                @if($tacloban)
                                                    @php
                                                        $year = Carbon::parse($starting)->year;
                                                        $date = Carbon::create($year, $i)->format('Y-m');
                                                        $taclobanOther = App\Radiology::otherCases($date, false, $cid, false, false, 'outside');
                                                    @endphp
                                                @endif
                                                @if($i == Carbon::parse($starting)->month)
                                                    <td style="padding-left: 40px">
                                                        {{ $clinicName }} Total Cases:
                                                    </td>
                                                @endif
                                                <td>
                                                    @if($tacloban)
                                                        {{ ($taclobanOther)? $taclobanOther[0]->others : 0 }}
                                                        @php
                                                            $totalPerOthersRow += $taclobanOther[0]->others;
                                                            $sumPerColumn['s'.$i] += $taclobanOther[0]->others;
                                                            (array_key_exists('m'.$i, $monthTotal))? $monthTotal['m'.$i] += $taclobanOther[0]->others : $monthTotal['m'.$i] = 0;
                                                        @endphp
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td></td>
                                                <td></td>


                                                <script>
                                                    document.getElementById("m{{ $i }}").innerText {{ "=".$sumPerColumn['s'.$i] }};
                                                </script>


                                            @endfor
                                            <td>{{ $totalPerOthersRow }}</td>
                                            <td></td>
                                            <td></td>
                                            @php
                                                $grandTotal += $totalPerOthersRow;
                                            @endphp
                                        </tr>


                                        <script>
                                            document.getElementById("m{{ (Carbon::parse($ending)->month + 1)}}").innerText {{ "=" . ($totalPerRow + $totalPerOthersRow) }};
                                        </script>


                                        {{-- end of outside region 8 reports --}}




                                        <tr>
                                            <td>Total</td>
                                            @for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++)
                                                <td>{{ $monthTotal['m'.$i] }}</td>
                                                <td></td>
                                                <td></td>
                                            @endfor
                                            <td class="total">{{ $grandTotal }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>



                                    </table>
                                </div>


                            @else

                                <hr>
                                <h4 class="text-center text-danger">
                                    Please select a date to be retrieve <i class="fa fa-calendar"></i>
                                </h4>

                            @endif



                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing all the highest cases per demographic area.
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