@component('OPDMS.partials.header')


    @slot('title')
        Medical Services Top Leading
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
            ['header' => 'Medical Services Top Leading', 'sub' => 'Showing all top leading medical services.'])

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        @include('OPDMS.reception.reports.medical_services_top_leading_search_form')


                        <div class="box-body">



                            @if($starting && $ending)

                                @php
                                    $startMonth = Carbon::parse($start)->month;
                                    $endMonth = Carbon::parse($end)->month;
                                    $total = 0;
                                    $monthTotal = array();
                                @endphp

                                @if(!empty($reports))


                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="bg-primary">
                                                <th colspan="16" class="text-center">TOP LEADING SERVICES</th>
                                            </tr>
                                            <tr>
                                                <th colspan="16" class="text-center">DIAGNOSTIC{{--{{ (Auth::user()->clinic == 22)? 'X-RAY' : 'UTZ' }}--}}</th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">#</th>
                                                <th rowspan="2" class="text-center">NAME OF CASES</th>
                                                <th colspan="2" class="text-center">Number of Consultations</th>
                                                <th colspan="12" class="text-center">Month</th>
                                            </tr>
                                            <tr>
                                                <td>SubTotal</td>
                                                <td>Total</td>
                                                @for($i=1;$i<13;$i++)
                                                    <td>
                                                        {{ Carbon::parse("2018-$i-01")->format('F') }}
                                                    </td>
                                                @endfor
                                            </tr>
                                            </thead>


                                            <tbody>

                                            @if(!empty($reports))

                                                @php
                                                    for ($k=1;$k<13;$k++){
                                                        $monthTotal['m'.$k] = 0;
                                                    }
                                                @endphp

                                                @foreach($reports as $row)

                                                    <tr>
                                                        <td>
                                                            {{ $loop->index + 1 }}
                                                        </td>
                                                        <td>
                                                            {{ $row->sub_category }}
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            {{ $row->total }}
                                                        </td>
                                                        @for($i=1;$i<13;$i++)
                                                            <td>
                                                                @if($i >= $startMonth && $i <= $endMonth)
                                                                    @php
                                                                        $query = App\Ancillaryrequist::topLeading($row->id, Carbon::create(Carbon::parse($start)->year, $i)->format('Y-m'))
                                                                    @endphp
                                                                    {{ (empty($query))? '' : $query }}
                                                                    @php
                                                                        $monthTotal['m'.$i] += $query;
                                                                    @endphp
                                                                @endif
                                                            </td>
                                                        @endfor
                                                    </tr>


                                                    @php
                                                        ($row->total)? $total+=$row->total : '';
                                                    @endphp

                                                @endforeach



                                            @endif

                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <td colspan="2">Total</td>
                                                <td></td>
                                                <td>{{ $total }}</td>
                                                @for($i=1;$i<13;$i++)
                                                    <td>
                                                        {{ $monthTotal['m'.$i] }}
                                                    </td>
                                                @endfor
                                            </tr>
                                            </tfoot>

                                        </table>
                                    </div>


                                @else

                                    <h4 class="text-center text-danger">
                                        Sorry! No Results Found.
                                    </h4>

                                @endif


                            @else

                                <h4 class="text-center text-danger">
                                    Please select a date to be retrieve <i class="fa fa-warning"></i>
                                </h4>

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