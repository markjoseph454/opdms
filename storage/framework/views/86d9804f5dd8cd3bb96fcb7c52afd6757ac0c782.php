<?php $__env->startComponent('OPDMS.partials.header'); ?>


    <?php $__env->slot('title'); ?>
        Medical Services Per Patient
    <?php $__env->endSlot(); ?>


<?php $__env->startSection('pagestyle'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_queue.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/partials/patient_information.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_assignation.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/notification.css')); ?>" />
    <link href="<?php echo e(asset('public/css/ancillary/census.css')); ?>" rel="stylesheet" />
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
            ['header' => 'Medical Services Per Patient', 'sub' => 'Showing all the total number of patient per services.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default">


                        <?php echo $__env->make('OPDMS.reception.reports.medical_services_per_patient_search_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                        <div class="box-body">

                            <div>
                                <?php if(isset($_GET['from'])): ?>
                                    <label>TOTAL NUMBER OF PATIENT PER SERVICES - DATE:
                                        <?php echo e(Carbon::parse($_GET['from'])->format('M-d-Y').' to '.Carbon::parse($_GET['to'])->format('M-d-Y')); ?></label>
                                <?php endif; ?>
                            </div>


                            <div class="table-responsive" id="rankindiv">
                                <table class="table table-bordered table-stripped">
                                    <thead>
                                        <tr>
                                            <th>RANKING</th>
                                            <th>PARTICULAR</th>
                                            <th>FEMALE</th>
                                            <th>MALE</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $l = 1;
                                        $total = 0;
                                        $female = 0;
                                        $male = 0;
                                    ?>

                                    <?php if(count($census) > 0): ?>
                                        <?php $__currentLoopData = $census; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td align="center"><?php echo e($l); ?></td>
                                                <td><?php echo e($list->sub_category); ?></td>
                                                <td align="center" class=""><?php echo e($list->female); ?></td>
                                                <td align="center" class=""><?php echo e($list->male); ?></td>
                                                <td align="center" class=""><?php if(Auth::user()->clinic == "3"): ?> <?php echo e($list->person); ?> <?php else: ?> <?php echo e($list->result); ?> <?php endif; ?></td>

                                            </tr>

                                            <?php

                                                $l++;

                                                $female += $list->female;
                                                $male += $list->male;

                                                if(Auth::user()->clinic == "3"):
                                                $total += $list->person;
                                                else:
                                                $total += $list->result;
                                                endif;

                                            ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php
                                            $m = 0;
                                            $f = 0;
                                        ?>

                                        <?php if(Auth::user()->clinic == "3"): ?>
                                            <?php $__currentLoopData = $consultation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($list->sex == "M"): ?>
                                                    <?php
                                                        $m++
                                                    ?>
                                                <?php endif; ?>
                                                <?php if($list->sex == "F"): ?>
                                                    <?php
                                                        $f++
                                                    ?>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td colspan="5" class=""></td>

                                            </tr>
                                            <tr>
                                                <td colspan="2" class="success text-right"><b>TOTAL SERVICES:</b></td>
                                                <td align="center" class="success"><b><?php echo e($female); ?></b></td>
                                                <td align="center" class="success"><b><?php echo e($male); ?></b></td>
                                                <td align="center" class="success"><b><?php echo e($total); ?></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class=""></td>

                                            </tr>
                                            <tr>
                                                <td colspan="2" class="success text-right">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<b>TOTAL CONSULTATION:</b></td>
                                                <td align="center" class="success"><b><?php echo e($f - $female); ?></b></td>
                                                <td align="center" class="success"><b><?php echo e($m - $male); ?></b></td>
                                                <td align="center" class="success"><b><?php echo e(count($consultation) - $total); ?></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class=""></td>

                                            </tr>
                                            <tr>
                                                <th colspan="2" style="text-align: right;">GRAND TOTAL:</th>
                                                <th><?php echo e($female + ($f - $female)); ?></th>
                                                <th><?php echo e($male + ($m - $male)); ?></th>
                                                <th><?php echo e(count($consultation)); ?></th>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <th colspan="2" style="text-align: right;">GRAND TOTAL:</th>
                                                <th colspan=""><?php echo e($female); ?></th>
                                                <th colspan=""><?php echo e($male); ?></th>
                                                <th colspan=""><?php echo e($total); ?></th>
                                            </tr>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="default" align="center" >NO RESULT FOUND</td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>





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