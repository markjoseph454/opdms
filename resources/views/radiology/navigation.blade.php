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
<nav class="navbar navbar-default navigation">

    <div class="container">

        <div class="navbar-header">
            <div class="navbar-toggle collapsed hamburger" data-toggle="collapse" data-target="#navigationMenus" 
                aria-expanded="false" onclick="openHamburger(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            <a class="navbar-brand" href="{{ url('patients') }}">
                <i class="fa fa-stethoscope"></i>
                <label class="longBrandName">EVRMC OPD</label>
                <label class="shortHandName">OPD</label>
            </a>
        </div>


        <div class="collapse navbar-collapse" id="navigationMenus">
            <ul class="nav navbar-nav navbar-right">

                <li class="">
                    <a href="{{ url('radiologyHome') }}">Patients <i class="fa fa-user-o"></i></a>
                </li>

                {{--<li class="">
                    <a href="{{ url('ancillary') }}">Services <i class="fa fa-wrench"></i></a>
                </li>--}}

                <li class="">
                    <a href="{{ url('radiologySearch') }}">Search <i class="fa fa-search"></i></a>
                </li>

                <li class="">
                    <a href="{{ url('radiologyhistory') }}">History <i class="fa fa-history"></i></a>
                </li>

                <li class="">
                    <a href="{{ url('ancillary') }}">Services <i class="fa fa-wrench"></i></a>
                </li>

                <li class="">
                    <a href="{{ url('addTemplate') }}">Templates <i class="fa fa-file-o"></i></a>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Reports <i class="fa fa-file-text-o"></i> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                            <a class="test" tabindex="-1" href="#">Medical Services &nbsp; <small><strong class="text-danger">BETA</strong></small>
                                <i class="fa fa-caret-right pull-right" style="padding-top: 3px"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a tabindex="-1" href="{{ url('medServicesAccomplished') }}">Services Accomplished &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                <li><a tabindex="-1" href="{{ url('topLeadingServices') }}">Top Leading Services &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ url('highestCases') }}">Demographic Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                        </li>
                        <li>
                            <a href="{{ url('weeklyCensus') }}">Weekly Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->username }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('register_account') }}">Update Account</a></li>
                        <li>
                            <a href="{{ url('logout') }}"
                               onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                                Logout <i class="fa fa-sign-out"></i>
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