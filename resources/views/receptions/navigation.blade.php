<style>
    .dropdown-submenu {
        position: relative;
    }
    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
        width: 250px;
    }
</style>


@include('receptions.qrcode.scan')

<nav class="navbar navbar-default navigation">

    <div class="container">

        <div class="navbar-header">
            <div class="navbar-toggle collapsed hamburger" data-toggle="collapse" data-target="#navigationMenus"
                 aria-expanded="false" onclick="openHamburger(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            <a class="navbar-brand" href="{{ url('overview') }}">
                <i class="fa fa-stethoscope"></i>
                <label class="longBrandName">OPD</label>
                <label class="shortHandName">OPD</label>
            </a>
        </div>


        <div class="collapse navbar-collapse" id="navigationMenus">
            <ul class="nav navbar-nav navbar-right">
                {{--<li class="">
                    <a href="{{ url('receptions') }}">QRCode <i class="fa fa-qrcode"></i></a>
                </li>--}}

                <li class="">
                    <a href="#" data-toggle="modal" data-target="#qrcodeModal">
                        QRCode <i class="fa fa-qrcode"></i>
                    </a>
                </li>

                <li class="">
                    <a href="{{ url('overview') }}">Overview <i class="fa fa-list"></i></a>
                </li>
                {{--<li class="">
                    <a href="{{ url('doctorsStatus') }}">DOCTORS <i class="fa fa-user-md"></i></a>
                </li>
                <li class="">
                    <a href="{{ url('patientsStatus') }}">PATIENTS <i class="fa fa-wheelchair"></i></a>
                </li>--}}

                @if(Auth::user()->clinic != 31)
                <li class="">
                    <a href="{{ url('vs_scanbarcode') }}">Vital Signs <i class="fa fa-heartbeat"></i></a>
                </li>
                @endif

               
                <li class="">
                    <a href="{{ url('ancillary') }}">Services <i class="fa fa-wrench"></i></a>
                </li>
               


                <li class="">
                    <a href="{{ url('patientsearch') }}">Search <i class="fa fa-search"></i></a>
                </li>
                <li class="">
                    <a href="{{ url('rcptnLogs') }}">History <i class="fa fa-history"></i></a>
                </li>


                @php
                    $servicesClinic = array(3,5,10,21,22,32,48,8);
                @endphp

                @if(in_array(Auth::user()->clinic, $servicesClinic))
                <li class="">
                    <a href="{{ url('ancillary') }}">Services <i class="fa fa-wrench"></i></a>
                </li>
                @endif

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Reports <i class="fa fa-file-text-o"></i>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">



                            <li>
                                <a href="{{ url('censusWatch') }}">Statistics Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                            </li>
                            <li>
                                <a href="{{ url('famedcensus') }}">
                                    Age, Gender Distribution &nbsp; <small><strong class="text-danger">BETA</strong></small>
                                </a>
                            </li>

                            @if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21)
                                <li>
                                    <a href="{{ url('weeklyCensus') }}">Weekly Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                                </li>
                            @endif

                            <li class="dropdown-submenu">
                                <a class="test" tabindex="-1" href="#">Medical Services &nbsp; <small><strong class="text-danger">BETA</strong></small>
                                    <i class="fa fa-caret-right pull-right" style="padding-top: 3px"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="{{ url('medServicesAccomplished') }}">Services Accomplished &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                    <li><a tabindex="-1" href="{{ url('topLeadingServices') }}">Top Leading Services &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                    <li><a tabindex="-1" href="{{ url('ancillarycensus') }}?top=ALL&from={{Carbon::now()->setTime(0,0)->format('Y-m-d')}}&to={{Carbon::now()->setTime(0,0)->format('Y-m-d')}}">Census &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{ url('highestCases') }}">Demographic Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                            </li>


                            <li class="dropdown-submenu">
                                <a class="test" tabindex="-1" href="#">Demographic Census &nbsp; <small><strong class="text-danger">BETA</strong></small>
                                    <i class="fa fa-caret-right pull-right" style="padding-top: 3px"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="{{ url('demographic') }}">Detailed Census &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                    <li><a tabindex="-1" href="{{ url('demographicSummary') }}">Summary Census &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                </ul>
                            </li>




                        <li>
                            <a href="{{ url('ancillaryreport') }}">MSS Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                        </li>

                        <li>
                            <a href="{{ url('refferalsReport') }}">Referrals Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                        </li>

                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->username }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('receptionsAccount') }}">Update Account</a></li>
                        <li>
                            <a href="{{ url('logout') }}"
                               onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</nav>

<br/><br/><br/>