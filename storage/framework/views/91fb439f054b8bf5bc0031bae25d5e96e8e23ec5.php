<?php $__env->startComponent('OPDMS.partials.header'); ?>


    <?php $__env->slot('title'); ?>
        Demographic Detailed Census
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
            ['header' => 'Demographic Detailed Census', 'sub' => 'Showing a detailed demographic census of registered patients.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        <?php echo $__env->make('OPDMS.reception.reports.referrals_search_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                        <div class="box-body">


                            <?php if($starting): ?>
                                <?php if(!$refferals->isEmpty()): ?>
                                    <?php $total = 0; ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="bg-primary">
                                                <th>Total</th>
                                                <th>Referred To Clinic</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $refferals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($row->total); ?></td>
                                                    <td><?php echo e($row->name); ?></td>
                                                </tr>
                                                <?php $total+=$row->total ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                            <tfoot>
                                            <tr class="bg-primary">
                                                <td><?php echo e($total); ?></td>
                                                <td>Total</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-danger text-center">
                                        <h5>No Results Found!</h5>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>

                                <hr/>
                                <h4 class="text-center text-danger">Please select a date to retrieve data</h4>
                                <hr/>

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