<?php $__env->startComponent('OPDMS.partials.header'); ?>


    <?php $__env->slot('title'); ?>
        Medical Services Accomplished
    <?php $__env->endSlot(); ?>


<?php $__env->startSection('pagestyle'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_queue.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/partials/patient_information.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_assignation.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/notification.css')); ?>" />
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
            ['header' => 'Medical Services Accomplished', 'sub' => 'Showing all medical services accomplished.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        <?php echo $__env->make('OPDMS.reception.reports.medical_services_accomplished_search_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                        <div class="box-body">



                            <?php if($starting && $ending): ?>


                                <?php if(!empty($reports)): ?>


                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="bg-primary">
                                                <th colspan="15" class="text-center">MEDICAL SERVICES ACCOMPLISHED</th>
                                            </tr>
                                            <tr>
                                                <th colspan="15" class="text-center">DIAGNOSTIC</th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2" class="text-center">NAME OF CASES</th>
                                                <th colspan="2" class="text-center">Number of Consultations</th>
                                                <th colspan="12" class="text-center">Month</th>
                                            </tr>
                                            <tr>
                                                <td>SubTotal</td>
                                                <td>Total</td>
                                                <?php for($i=1;$i<13;$i++): ?>
                                                    <td>
                                                        <?php echo e(Carbon::parse("2018-$i-01")->format('F')); ?>

                                                    </td>
                                                <?php endfor; ?>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php if(!empty($reports)): ?>

                                                <?php
                                                    $duplicateCategory = false;
                                                    $counter = 1;
                                                    $noResult= false;
                                                    $monthTotal = array();
                                                    $totalPerRow = array();
                                                    $sumPerRow = false;
                                                    for ($k=1;$k<13;$k++){
                                                        $monthTotal['m'.$k] = 0;
                                                    }
                                                ?>

                                                <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                    <?php if($sumPerRow == $row->cid): ?>
                                                        <?php
                                                            $totalPerRow['t'.$row->cid] += $row->total;
                                                        ?>
                                                    <?php else: ?>
                                                        <?php
                                                            $totalPerRow['t'.$row->cid] = $row->total;
                                                        ?>
                                                    <?php endif; ?>
                                                    <?php
                                                        $sumPerRow = $row->cid;
                                                    ?>


                                                    <?php if($duplicateCategory && $duplicateCategory != $row->cid && $noResult): ?>
                                                        <?php for($j=$counter;$j<13;$j++): ?>
                                                            <td></td>
                                                        <?php endfor; ?>
                                                    <?php endif; ?>



                                                    <?php if($duplicateCategory != $row->cid): ?>
                                                        <?php $counter = 1 ?>
                                                    <?php endif; ?>




                                                    <?php if($duplicateCategory != $row->cid): ?>
                                                        <tr>
                                                            <?php endif; ?>

                                                            <?php if($duplicateCategory != $row->cid): ?>
                                                                <td class="<?php echo e($row->cid); ?>">
                                                                    <?php echo e($row->sub_category); ?>

                                                                </td>
                                                                <td></td>
                                                                <td class="<?php echo e('t'.$row->cid); ?>"></td>
                                                            <?php endif; ?>


                                                            <?php for($j=$counter;$j<13;$j++): ?>
                                                                <td>
                                                                    <?php if($row->month == $j): ?>
                                                                        <?php echo e($row->total); ?>

                                                                        <?php
                                                                            $counter = $j + 1; $noResult = true;
                                                                            $monthTotal['m'.$j] += $row->total;
                                                                        ?>
                                                                        <?php break; ?>
                                                                    <?php else: ?>
                                                                        <?php
                                                                            $noResult = false;
                                                                        ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                            <?php endfor; ?>


                                                            <?php
                                                                $duplicateCategory = $row->cid;
                                                            ?>




                                                            <?php if($duplicateCategory != $row->cid): ?>
                                                        </tr>
                                                    <?php endif; ?>



                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                                <tr>
                                                    <td class="bg-primary">
                                                        <?php echo e(($category == 'N')? 'NEW' : 'OLD'); ?> PATIENTS
                                                    </td>
                                                    <td></td>
                                                    <td><?php echo e(array_sum($totalPerRow)); ?></td>
                                                    <?php for($i=1;$i<13;$i++): ?>
                                                        <td>
                                                            <?php echo e($monthTotal['m'.$i]); ?>

                                                        </td>
                                                    <?php endfor; ?>
                                                </tr>

                                            <?php endif; ?>

                                            </tbody>
                                        </table>
                                    </div>


                                <?php else: ?>

                                    <h4 class="text-center text-danger">
                                        Sorry! No Results Found.
                                    </h4>

                                <?php endif; ?>


                            <?php else: ?>

                                <h4 class="text-center text-danger">
                                    Please select a date to be retrieve <i class="fa fa-warning"></i>
                                </h4>

                            <?php endif; ?>



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

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>