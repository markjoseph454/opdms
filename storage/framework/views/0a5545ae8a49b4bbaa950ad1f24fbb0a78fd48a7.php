<?php $__env->startComponent('OPDMS.partials.header'); ?>


    <?php $__env->slot('title'); ?>
        Referrals Reports
    <?php $__env->endSlot(); ?>


<?php $__env->startSection('pagestyle'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_queue.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/partials/patient_information.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_assignation.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/notification.css')); ?>" />
    <link href="<?php echo e(asset('public/css/receptions/demographic.css')); ?>" rel="stylesheet" />
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
            ['header' => 'Referrals Report', 'sub' => 'Showing all referrals from this clinic.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        <?php echo $__env->make('OPDMS.reception.reports.demographic_detailed_search_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                        <div class="box-body">




                            <?php if(count($demographics) > 0): ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="">
                                            <th></th>
                                            <th><?php echo e($category); ?></th>
                                            <th><?php echo e(Carbon::parse($starting)->toFormattedDateString().' - '.Carbon::parse($ending)->toFormattedDateString()); ?></th>
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

                                        <?php $__currentLoopData = $demographics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $demographic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->index + 1); ?></td>
                                                <td>
                                                    <?php echo e(($demographic->total > 1)? 'OLD' : 'NEW'); ?>

                                                </td>
                                                <td><?php echo e($demographic->name); ?></td>
                                                <td><?php echo e(App\Patient::age($demographic->birthday)); ?></td>
                                                <td><?php echo e($demographic->sex); ?></td>
                                                <td class="leyte">
                                                    <?php if($demographic->provCode == '0837' && $demographic->city_municipality == '083747'): ?>
                                                        <?php echo e(1); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <?php for($i=1;$i<6;$i++): ?>
                                                    <td class="leyte">
                                                        <?php if($demographic->provCode == '0837' && $demographic->district == $i && $demographic->city_municipality != '083747'): ?>
                                                            <?php echo e(1); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                <?php endfor; ?>
                                                <?php for($i=1;$i<3;$i++): ?>
                                                    <td class="wsamar">
                                                        <?php if($demographic->provCode == '0860' && $demographic->district == $i): ?>
                                                            <?php echo e(1); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                <?php endfor; ?>
                                                <?php for($i=1;$i<3;$i++): ?>
                                                    <td class="esamar">
                                                        <?php if($demographic->provCode == '0826' && $demographic->district == $i): ?>
                                                            <?php echo e(1); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                <?php endfor; ?>
                                                <?php for($i=1;$i<3;$i++): ?>
                                                    <td class="nsamar">
                                                        <?php if($demographic->provCode == '0848' && $demographic->district == $i): ?>
                                                            <?php echo e(1); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                <?php endfor; ?>
                                                <?php for($i=1;$i<3;$i++): ?>
                                                    <td class="sleyte">
                                                        <?php if($demographic->provCode == '0864' && $demographic->district == $i): ?>
                                                            <?php echo e(1); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                <?php endfor; ?>
                                                <?php for($i=1;$i<3;$i++): ?>
                                                    <td class="biliran">
                                                        <?php if($demographic->provCode == '0878' && $demographic->district == $i): ?>
                                                            <?php echo e(1); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                <?php endfor; ?>
                                                <td><?php echo e($demographic->citymunDesc); ?></td>
                                                <td><?php echo e((App\Patient::age($demographic->birthday) >= 60 && App\Patient::age($demographic->birthday) < 69)? 1 : ''); ?></td>
                                                <td><?php echo e((App\Patient::age($demographic->birthday) >= 70)? 1 : ''); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </tbody>

                                        <tfoot>
                                        <?php if(count($demographics) > 0 && $starting): ?>
                                            <tr>
                                                <td>
                                                    <h5><b class="text-danger">Total</b></h5>
                                                </td>
                                                <td colspan="23"><h5><b class="text-danger"><?php echo e(count($demographics)); ?></b></h5></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tfoot>

                                    </table>
                                </div>


                            <?php else: ?>


                                <?php if($starting && count($demographics) <= 0): ?>
                                    <h4 class="text-center text-danger">No results found <i class="fa fa-exclamation"></i></h4>
                                <?php else: ?>
                                    <h4 class="text-center text-danger">Please select a date to be retrieve. <i class="fa fa-calendar"></i></h4>
                                <?php endif; ?>

                                <hr>

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