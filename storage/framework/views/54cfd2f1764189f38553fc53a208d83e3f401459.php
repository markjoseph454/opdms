<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Weekly Census
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/radiology/reports/highestCases.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php if(Auth::user()->role == 5): ?>
        <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('radiology/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <br>
    <div class="container-fluid">
        <div class="container weeklyCensus">

            <?php echo $__env->make('radiology.reports.weeklyDate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            <?php if($dateTime): ?>



                <?php
                    $date = Carbon::parse($dateTime);
                    $ted = Carbon::parse($dateTime);
                ?>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th rowspan="2" colspan="2" class="text-center">
                                <h4><strong>PARTICULARS</strong></h4>
                            </th>
                            <th colspan="5" id="monthTD" class="text-center">
                                <?php echo e($date->format('F')); ?>

                            </th>
                        </tr>
                        <tr>


                            <?php for($i=1;$i<7;$i++): ?>
                                <?php
                                    $endloop = $i;
                                    if($i == 1){
                                        $start = '01';
                                    }else{
                                        $start = $date->endOfWeek()->addDay()->format('d');
                                    }
                                    if ($date->endOfWeek()->format('m') != $ted->format('m')){
                                        $end = $ted->endOfMonth()->format('d');
                                    }else{
                                        $end = $date->endOfWeek()->format('d');
                                    }
                                ?>
                                <th>
                                    WEEK <?php echo e($i); ?> <br>
                                    (<?php echo e($ted->format('m').'/'.$start.'-'.$end.'/'.$date->format('y')); ?>)
                                </th>
                                <?php if($date->endOfWeek()->format('m') != $ted->format('m')): ?>
                                    <?php break; ?>
                                <?php endif; ?>
                            <?php endfor; ?>




                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2">
                                1. Total number of Radiologic Procedure Done
                            </td>
                            <?php for($i=0;$i<$endloop;$i++): ?>
                                <td></td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td class="text-right">a.</td>
                            <td>In-Patients</td>
                            <?php for($i=0;$i<$endloop;$i++): ?>
                                <td></td>
                            <?php endfor; ?>
                        </tr>


                        <tr>
                            <td class="text-right">b.</td>
                            <td>Out-Patients</td>

                            <?php
                                $firstDate = Carbon::parse($dateTime);
                                $secondDate = Carbon::parse($dateTime);
                            ?>
                            <?php for($i=1;$i<7;$i++): ?>
                                <?php
                                    if($i == 1){
                                        $start = '01';
                                    }else{
                                        $start = $firstDate->endOfWeek()->addDay()->format('d');
                                    }
                                    if ($firstDate->endOfWeek()->format('m') != $secondDate->format('m')){
                                        $end = $secondDate->endOfMonth()->format('d');
                                    }else{
                                        $end = $firstDate->endOfWeek()->format('d');
                                    }
                                ?>
                                <td>
                                    <?php
                                        $startDate = $firstDate->format('Y').'-'.$secondDate->format('m').'-'.$start;
                                        $endDate = $firstDate->format('Y').'-'.$secondDate->format('m').'-'.$end;
                                        $total = App\Radiology::weeklyReport($startDate, $endDate);
                                    ?>
                                    <?php echo e($total[0]->total); ?>

                                </td>
                                <?php if($firstDate->endOfWeek()->format('m') != $secondDate->format('m')): ?>
                                    <?php break; ?>
                                <?php endif; ?>
                            <?php endfor; ?>

                        </tr>



                        <tr>
                            <td colspan="2">
                                2. Total number of Out-Patients provided with Diagnostic <br>
                                Services from Presentation of Request to Release
                            </td>

                            <?php
                                $firstDate = Carbon::parse($dateTime);
                                $secondDate = Carbon::parse($dateTime);
                            ?>
                            <?php for($i=1;$i<7;$i++): ?>
                                <?php
                                    if($i == 1){
                                        $start = '01';
                                    }else{
                                        $start = $firstDate->endOfWeek()->addDay()->format('d');
                                    }
                                    if ($firstDate->endOfWeek()->format('m') != $secondDate->format('m')){
                                        $end = $secondDate->endOfMonth()->format('d');
                                    }else{
                                        $end = $firstDate->endOfWeek()->format('d');
                                    }
                                ?>
                                <td>
                                    <?php
                                        $startDate = $firstDate->format('Y').'-'.$secondDate->format('m').'-'.$start;
                                        $endDate = $firstDate->format('Y').'-'.$secondDate->format('m').'-'.$end;
                                        $total = App\Radiology::withResult($startDate, $endDate);
                                    ?>
                                    <?php echo e($total[0]->total); ?>

                                </td>
                                <?php if($firstDate->endOfWeek()->format('m') != $secondDate->format('m')): ?>
                                    <?php break; ?>
                                <?php endif; ?>
                            <?php endfor; ?>

                        </tr>
                        </tbody>
                    </table>
                </div>



            <?php else: ?>

                <hr>

                <h4 class="text-danger text-center">
                    Please select a date to be retrieve <i class="fa fa-calendar"></i>
                </h4>

                <hr>

            <?php endif; ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>

    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/radiology/reports/reports.js')); ?>"></script>


    <?php if($dateTime): ?>
        <script>
            $('#monthTD').attr('colspan',<?php echo e($endloop); ?>);
        </script>
    <?php endif; ?>



<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
