@component('OPDMS.partials.header')


    @slot('title')
        Referrals Reports
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


                        @include('OPDMS.reception.reports.demographic_detailed_search_form')


                        <div class="box-body">




                            @if(count($demographics) > 0)

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="">
                                            <th></th>
                                            <th>{{ $category }}</th>
                                            <th>{{ Carbon::parse($starting)->toFormattedDateString().' - '.Carbon::parse($ending)->toFormattedDateString() }}</th>
                                            <th></th>
                                            <th></th>
                                            <th colspan="6" class="leyte">LEYTE</th>
                                            <th colspan="2" class="wsamar">W-SAMAR</th>
                                            <th colspan="2" class="esamar">E-SAMAR</th>
                                            <th colspan="2" class="nsamar">N-SAMAR</th>
                                            <th colspan="2" class="sleyte">S-LEYTE</th>
                                            <th colspan="2" class="biliran">BILIRAN</th>
                                            <th>ADDRESS</th>
                                            <th>SC</th>
                                            <th>GERIA</th>
                                        </tr>
                                        <tr class="">
                                            <th>#</th>
                                            <th>HN</th>
                                            <th>NAME</th>
                                            <th>AGE</th>
                                            <th>SEX</th>
                                            <th class="leyte">TC</th>
                                            <th class="leyte">1ST</th>
                                            <th class="leyte">2ND</th>
                                            <th class="leyte">3RD</th>
                                            <th class="leyte">4TH</th>
                                            <th class="leyte">5TH</th>
                                            <th class="wsamar">1ST</th>
                                            <th class="wsamar">2ND</th>
                                            <th class="esamar">1ST</th>
                                            <th class="esamar">2ND</th>
                                            <th class="nsamar">1ST</th>
                                            <th class="nsamar">2ND</th>
                                            <th class="sleyte">1ST</th>
                                            <th class="sleyte">2ND</th>
                                            <th class="biliran">1ST</th>
                                            <th class="biliran">2ND</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        @foreach($demographics as $demographic)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    {{ ($demographic->total > 1)? 'OLD' : 'NEW' }}
                                                </td>
                                                <td>{{ $demographic->name }}</td>
                                                <td>{{ App\Patient::age($demographic->birthday) }}</td>
                                                <td>{{ $demographic->sex }}</td>
                                                <td class="leyte">
                                                    @if($demographic->provCode == '0837' && $demographic->city_municipality == '083747')
                                                        {{ 1 }}
                                                    @endif
                                                </td>
                                                @for($i=1;$i<6;$i++)
                                                    <td class="leyte">
                                                        @if($demographic->provCode == '0837' && $demographic->district == $i && $demographic->city_municipality != '083747')
                                                            {{ 1 }}
                                                        @endif
                                                    </td>
                                                @endfor
                                                @for($i=1;$i<3;$i++)
                                                    <td class="wsamar">
                                                        @if($demographic->provCode == '0860' && $demographic->district == $i)
                                                            {{ 1 }}
                                                        @endif
                                                    </td>
                                                @endfor
                                                @for($i=1;$i<3;$i++)
                                                    <td class="esamar">
                                                        @if($demographic->provCode == '0826' && $demographic->district == $i)
                                                            {{ 1 }}
                                                        @endif
                                                    </td>
                                                @endfor
                                                @for($i=1;$i<3;$i++)
                                                    <td class="nsamar">
                                                        @if($demographic->provCode == '0848' && $demographic->district == $i)
                                                            {{ 1 }}
                                                        @endif
                                                    </td>
                                                @endfor
                                                @for($i=1;$i<3;$i++)
                                                    <td class="sleyte">
                                                        @if($demographic->provCode == '0864' && $demographic->district == $i)
                                                            {{ 1 }}
                                                        @endif
                                                    </td>
                                                @endfor
                                                @for($i=1;$i<3;$i++)
                                                    <td class="biliran">
                                                        @if($demographic->provCode == '0878' && $demographic->district == $i)
                                                            {{ 1 }}
                                                        @endif
                                                    </td>
                                                @endfor
                                                <td>{{ $demographic->citymunDesc }}</td>
                                                <td>{{ (App\Patient::age($demographic->birthday) >= 60 && App\Patient::age($demographic->birthday) < 69)? 1 : '' }}</td>
                                                <td>{{ (App\Patient::age($demographic->birthday) >= 70)? 1 : '' }}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>

                                        <tfoot>
                                        @if(count($demographics) > 0 && $starting)
                                            <tr>
                                                <td>
                                                    <h5><b class="text-danger">Total</b></h5>
                                                </td>
                                                <td colspan="23"><h5><b class="text-danger">{{ count($demographics) }}</b></h5></td>
                                            </tr>
                                        @endif
                                        </tfoot>

                                    </table>
                                </div>


                            @else


                                @if($starting && count($demographics) <= 0)
                                    <h4 class="text-center text-danger">No results found <i class="fa fa-exclamation"></i></h4>
                                @else
                                    <h4 class="text-center text-danger">Please select a date to be retrieve. <i class="fa fa-calendar"></i></h4>
                                @endif

                                <hr>

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