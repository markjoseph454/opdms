<?php $__env->startComponent('OPDMS.partials.header'); ?>


    <?php $__env->slot('title'); ?>
        Queue Census Daily
    <?php $__env->endSlot(); ?>


<?php $__env->startSection('pagestyle'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_queue.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/partials/patient_information.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/notification.css')); ?>" />
    <link href="<?php echo e(asset('public/css/receptions/status.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/reports/monitoring.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>




<?php $__env->startSection('vue-container-start'); ?>
    <div id="vue-queue">
    <?php $__env->stopSection(); ?>





    <?php $__env->startSection('navigation'); ?>
        <?php echo $__env->make('OPDMS.partials.boilerplate.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>


    <?php $__env->startSection('dashboard'); ?>
        <?php $__env->startComponent('OPDMS.partials.boilerplate.dashboard'); ?>
    <?php $__env->startSection('search_form'); ?>
        <?php echo $__env->make('OPDMS.reception.partials.search_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>
    <?php echo $__env->renderComponent(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>





        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            <?php echo $__env->make('OPDMS.partials.boilerplate.header',
            ['header' => 'Queuing Census Daily', 'sub' => 'Showing daily queuing census of this clinic.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        <?php echo $__env->make('OPDMS.reception.reports.queue_census_search_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



                        <div class="box-body">




                            <?php if($daily): ?>

                                <?php
                                    $numDays = Carbon::parse($date)->daysInMonth + 1;
                                    $dt = Carbon::parse($date);
                                    $noDoctorsClinic = array(10,48,22,21);
                                    $sum = array();
                                    $fin = 0;
                                    $serv = 0;
                                    $pen = 0;
                                    $pau = 0;
                                    $can = 0;
                                    $unassgned = 0;
                                ?>

                                <div class="table-responsive monthlyTableWrapper">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th rowspan="3">Status</th>
                                            <th colspan="<?php echo e(Carbon::parse($date)->endOfMonth()->day); ?>" class="text-center">
                                                <?php echo e(Carbon::parse($date)->format('F Y')); ?>

                                            </th>
                                            <th rowspan="3">Total</th>
                                        </tr>
                                        <tr>
                                            <?php for($i=1;$i<$numDays;$i++): ?>
                                                <?php
                                                    $weekDay = Carbon::createFromDate($dt->year, $dt->month, $i)->format('l');
                                                ?>
                                                <th><?php echo e($weekDay[0]); ?></th>
                                            <?php endfor; ?>
                                        </tr>
                                        <tr>
                                            <?php for($i=1;$i<$numDays;$i++): ?>
                                                <th><?php echo e($i); ?></th>
                                            <?php endfor; ?>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td class="finishedTabActive">
                                                <?php echo e((!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'Finished' : 'Done'); ?>

                                            </td>
                                            <?php for($i=1;$i<$numDays;$i++): ?>
                                                <?php
                                                    $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
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
                                                    $result = App\Http\Controllers\MonitoringController::monitor($queryDate, $stat);
                                                    (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                                    $fin += $result;
                                                ?>
                                                <td class="<?php echo e(($result)? 'finishedTabActive' : ''); ?>"><?php echo e($result); ?></td>
                                            <?php endfor; ?>
                                            <td style="background: #eee"><?php echo e($fin); ?></td>
                                        </tr>

                                        <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                                            <tr>
                                                <td class="servingTabActive">
                                                    
                                                    <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                                                        Serving
                                                    <?php else: ?>
                                                        <?php if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21): ?>
                                                            Posted Result
                                                        <?php else: ?>
                                                            Finished
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <?php for($i=1;$i<$numDays;$i++): ?>
                                                    <?php
                                                        $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                                        $stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'F' : 'S' ;
                                                        $result = App\Http\Controllers\MonitoringController::monitor($queryDate, $stat);
                                                        (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                                        $serv += $result;
                                                    ?>
                                                    <td class="<?php echo e(($result)? 'servingTabActive' : ''); ?>"><?php echo e($result); ?></td>
                                                <?php endfor; ?>
                                                <td style="background: #eee">
                                                    <?php echo e($serv); ?>

                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                        <tr>
                                            <td class="pendingTabActive">
                                                Pending
                                            </td>
                                            <?php for($i=1;$i<$numDays;$i++): ?>
                                                <?php
                                                    $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                                    $result = App\Http\Controllers\MonitoringController::monitor($queryDate, 'P');
                                                    (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                                    $pen += $result;
                                                ?>
                                                <td class="<?php echo e(($result)? 'pendingTabActive' : ''); ?>"><?php echo e($result); ?></td>
                                            <?php endfor; ?>
                                            <td style="background: #eee">
                                                <?php echo e($pen); ?>

                                            </td>
                                        </tr>

                                        <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                                            <tr>
                                                <td class="pausedTabActive">Paused</td>
                                                <?php for($i=1;$i<$numDays;$i++): ?>
                                                    <?php
                                                        $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                                        $result = App\Http\Controllers\MonitoringController::monitor($queryDate, 'H');
                                                        (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                                        $pau += $result;
                                                    ?>
                                                    <td class="<?php echo e(($result)? 'pausedTabActive' : ''); ?>"><?php echo e($result); ?></td>
                                                <?php endfor; ?>
                                                <td style="background: #eee">
                                                    <?php echo e($pau); ?>

                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                        <tr>
                                            <td class="nawcTabActive">NAWC</td>
                                            <?php for($i=1;$i<$numDays;$i++): ?>
                                                <?php
                                                    $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                                    $result = App\Http\Controllers\MonitoringController::monitor($queryDate, 'C');
                                                    (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                                    $can += $result;
                                                ?>
                                                <td class="<?php echo e(($result)? 'nawcTabActive' : ''); ?>"><?php echo e($result); ?></td>
                                            <?php endfor; ?>
                                            <td style="background: #eee">
                                                <?php echo e($can); ?>

                                            </td>
                                        </tr>

                                        <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                                            <tr>
                                                <td class="unassignedTabActive">Unassigned</td>
                                                <?php for($i=1;$i<$numDays;$i++): ?>
                                                    <?php
                                                        $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                                        $result = App\Http\Controllers\MonitoringController::monitor($queryDate, 'U');
                                                        (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                                        $unassgned += $result;
                                                    ?>
                                                    <td class="<?php echo e(($result)? 'unassignedTabActive' : ''); ?>"><?php echo e($result); ?></td>
                                                <?php endfor; ?>
                                                <td style="background: #eee">
                                                    <?php echo e($unassgned); ?>

                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>

                                        <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <?php for($i=1;$i<$numDays;$i++): ?>
                                                <th><?php echo e($sum['d'.$i]); ?></th>
                                            <?php endfor; ?>
                                            <th style="background: #333;color: #fff"><?php echo e(array_sum($sum)); ?></th>
                                        </tr>






                                        <?php if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21): ?>

                                            <?php
                                                $postedResult = 0;
                                            ?>

                                            <tr>
                                                <td colspan="<?php echo e($numDays); ?>">
                                                    <br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="servingTabActive">
                                                    
                                                    <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                                                        Serving
                                                    <?php else: ?>
                                                        <?php if(Auth::user()->clinic == 22 || Auth::user()->clinic == 21): ?>
                                                            Posted Result
                                                        <?php else: ?>
                                                            Finished
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <?php
                                                    $stat = (in_array(Auth::user()->clinic, $noDoctorsClinic))? 'F' : 'S' ;
                                                ?>
                                                <?php for($i=1;$i<$numDays;$i++): ?>
                                                    <?php
                                                        $queryDate = Carbon::createFromDate($dt->year, $dt->month, $i)->toDateString();
                                                        $result = App\Http\Controllers\MonitoringController::monitor($queryDate, $stat);
                                                        (array_key_exists('d'.$i, $sum))? $sum['d'.$i] += $result : $sum['d'.$i] = $result;
                                                        $postedResult += $result;
                                                    ?>
                                                    <td class="<?php echo e(($result)? 'servingTabActive' : ''); ?>"><?php echo e($result); ?></td>
                                                <?php endfor; ?>
                                                <td style="background-color: #333; color: #fff">
                                                    <?php echo e($postedResult); ?>

                                                </td>
                                            </tr>

                                            <!-- <tr>
                                <th>Posted Total</th>
                                <th colspan="<?php echo e($numDays); ?>"><?php echo e($postedResult); ?></th>
                            </tr> -->

                                        <?php endif; ?>

                                        </tfoot>



                                    </table>
                                </div>


                            <?php else: ?>

                                <hr>
                                <h4 class="text-center text-danger">Please select a date to be retrieve <i class="fa fa-calendar"></i></h4>
                                <hr>

                            <?php endif; ?>



                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing daily queuing census of this clinic.
                                </em>
                            </small>
                        </div>

                    </div>



                </section>
                <!-- /.content -->

            </div>
            <!-- /.content-wrapper -->
        <?php $__env->stopSection(); ?>



        <?php $__env->startSection('footer'); ?>
            <?php echo $__env->make('OPDMS.partials.boilerplate.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php $__env->stopSection(); ?>



        <?php $__env->startSection('aside'); ?>
            <?php echo $__env->make('OPDMS.partials.boilerplate.aside', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php $__env->stopSection(); ?>



        
        <?php $__env->startSection('vue-container-end'); ?>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('pluginscript'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('pagescript'); ?>

    <script src="<?php echo e(asset('public/OPDMS/vue/reception/queue.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/reception/notification.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/reports.js')); ?>"></script>

    <?php if(Session::has('census') && Session::get('census') == 'monthly'): ?>
        <script>
            $(document).ready(function () {
                $('.monthlyBtn').click();
            });
        </script>
    <?php endif; ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>