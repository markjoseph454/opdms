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


<?php echo $__env->make('receptions.qrcode.scan', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<nav class="navbar navbar-default navigation">

    <div class="container">

        <div class="navbar-header">
            <div class="navbar-toggle collapsed hamburger" data-toggle="collapse" data-target="#navigationMenus"
                 aria-expanded="false" onclick="openHamburger(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            <a class="navbar-brand" href="<?php echo e(url('overview')); ?>">
                <i class="fa fa-stethoscope"></i>
                <label class="longBrandName">OPD</label>
                <label class="shortHandName">OPD</label>
            </a>
        </div>


        <div class="collapse navbar-collapse" id="navigationMenus">
            <ul class="nav navbar-nav navbar-right">
                

                <li class="">
                    <a href="#" data-toggle="modal" data-target="#qrcodeModal">
                        QRCode <i class="fa fa-qrcode"></i>
                    </a>
                </li>

                <li class="">
                    <a href="<?php echo e(url('overview')); ?>">Overview <i class="fa fa-list"></i></a>
                </li>
                

                <?php if(Auth::user()->clinic != 31): ?>
                <li class="">
                    <a href="<?php echo e(url('vs_scanbarcode')); ?>">Vital Signs <i class="fa fa-heartbeat"></i></a>
                </li>
                <?php endif; ?>

               
                <li class="">
                    <a href="<?php echo e(url('ancillary')); ?>">Services <i class="fa fa-wrench"></i></a>
                </li>
               


                <li class="">
                    <a href="<?php echo e(url('patientsearch')); ?>">Search <i class="fa fa-search"></i></a>
                </li>
                <li class="">
                    <a href="<?php echo e(url('rcptnLogs')); ?>">History <i class="fa fa-history"></i></a>
                </li>


                <?php
                    $servicesClinic = array(3,5,10,21,22,32,48,8);
                ?>

                <?php if(in_array(Auth::user()->clinic, $servicesClinic)): ?>
                <li class="">
                    <a href="<?php echo e(url('ancillary')); ?>">Services <i class="fa fa-wrench"></i></a>
                </li>
                <?php endif; ?>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Reports <i class="fa fa-file-text-o"></i>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">



                            <li>
                                <a href="<?php echo e(url('censusWatch')); ?>">Statistics Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                            </li>
                            <li>
                                <a href="<?php echo e(url('famedcensus')); ?>">
                                    Age, Gender Distribution &nbsp; <small><strong class="text-danger">BETA</strong></small>
                                </a>
                            </li>

                            <?php if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21): ?>
                                <li>
                                    <a href="<?php echo e(url('weeklyCensus')); ?>">Weekly Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                                </li>
                            <?php endif; ?>

                            <li class="dropdown-submenu">
                                <a class="test" tabindex="-1" href="#">Medical Services &nbsp; <small><strong class="text-danger">BETA</strong></small>
                                    <i class="fa fa-caret-right pull-right" style="padding-top: 3px"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="<?php echo e(url('medServicesAccomplished')); ?>">Services Accomplished &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                    <li><a tabindex="-1" href="<?php echo e(url('topLeadingServices')); ?>">Top Leading Services &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                    <li><a tabindex="-1" href="<?php echo e(url('ancillarycensus')); ?>?top=ALL&from=<?php echo e(Carbon::now()->setTime(0,0)->format('Y-m-d')); ?>&to=<?php echo e(Carbon::now()->setTime(0,0)->format('Y-m-d')); ?>">Census &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="<?php echo e(url('highestCases')); ?>">Demographic Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                            </li>


                            <li class="dropdown-submenu">
                                <a class="test" tabindex="-1" href="#">Demographic Census &nbsp; <small><strong class="text-danger">BETA</strong></small>
                                    <i class="fa fa-caret-right pull-right" style="padding-top: 3px"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="<?php echo e(url('demographic')); ?>">Detailed Census &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                    <li><a tabindex="-1" href="<?php echo e(url('demographicSummary')); ?>">Summary Census &nbsp; <small><strong class="text-danger">BETA</strong></small></a></li>
                                </ul>
                            </li>




                        <li>
                            <a href="<?php echo e(url('ancillaryreport')); ?>">MSS Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                        </li>

                        <li>
                            <a href="<?php echo e(url('refferalsReport')); ?>">Referrals Report &nbsp; <small><strong class="text-danger">BETA</strong></small></a>
                        </li>

                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo e(Auth::user()->username); ?>

                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo e(url('receptionsAccount')); ?>">Update Account</a></li>
                        <li>
                            <a href="<?php echo e(url('logout')); ?>"
                               onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST" style="display: none;">
                                <?php echo e(csrf_field()); ?>

                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</nav>

<br/><br/><br/>