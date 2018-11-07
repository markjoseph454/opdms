<?php $__env->startComponent('OPDMS.partials.header'); ?>


    <?php $__env->slot('title'); ?>
        Doctors Queue
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
                <?php echo $__env->make('OPDMS.partials.boilerplate.search_form', ['redirector' => 'admin.search'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>

        

            <?php echo $__env->make('OPDMS.partials.modals.modal_container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;


       



        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">

            <?php echo $__env->make('OPDMS.partials.boilerplate.header',
            ['header' => 'Doctors Queue', 'sub' => 'Showing the queuing status of doctors.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">



                        <div class="box-body">



                            
                            <div class="table-responsive selectable_table">
                                <table class="table table-bordered table-striped table-hover" id="dataTable2">
                                    <thead>
                                    <tr>
                                        <th>No#</th>
                                        <th>Connectivity</th>
                                        <th>Doctors Name</th>
                                        <th>Pending</th>
                                        <th>Paused</th>
                                        <th>NAWC</th>
                                        <th>Serving</th>
                                        <th>Finished</th>
                                        <th>All</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(count($doctors)): ?>
                                        <?php $count_doctors = 1; ?>
                                        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(Cache::has('active_'.$doctor->id) || $doctor->pending || $doctor->paused
                                            || $doctor->nawc || $doctor->serving || $doctor->finished ): ?>
                                                <tr>
                                                    <td><?php echo e($count_doctors++); ?></td>
                                                    <td>
                                                        <?php if(Cache::has('active_'.$doctor->id)): ?>
                                                            <i class="fa fa-circle text-green"></i>
                                                            Online
                                                        <?php else: ?>
                                                            <i class="fa fa-circle text-muted"></i>
                                                            Offline
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        
                                                        <strong class="text-primary text-uppercase">
                                                            <?php echo e($doctor->last_name.', '.$doctor->first_name.' '.
                                                            $doctor->middle_name); ?>

                                                        </strong>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e(url('status_filtering/'.$doctor->id.'/P')); ?>" class="btn btn-circle
                                                            <?php if($doctor->pending): ?> bg-orange <?php else: ?> btn-default disabled <?php endif; ?>"
                                                           onclick="full_window_loader()">
                                                            <?php echo e(isset($doctor->pending) ? $doctor->pending : 0); ?>

                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e(url('status_filtering/'.$doctor->id.'/H')); ?>" class="btn btn-circle
                                                             <?php if($doctor->paused): ?> bg-brown <?php else: ?> btn-default disabled <?php endif; ?>"
                                                           onclick="full_window_loader()">
                                                            <?php echo e(isset($doctor->paused) ? $doctor->paused : 0); ?>

                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e(url('status_filtering/'.$doctor->id.'/C')); ?>" class="btn btn-circle
                                                            <?php if($doctor->nawc): ?> bg-red <?php else: ?> btn-default disabled <?php endif; ?>"
                                                           onclick="full_window_loader()">
                                                            <?php echo e(isset($doctor->nawc) ? $doctor->nawc : 0); ?>

                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e(url('status_filtering/'.$doctor->id.'/S')); ?>" class="btn btn-circle
                                                            <?php if($doctor->serving): ?> bg-green <?php else: ?> btn-default disabled <?php endif; ?>"
                                                           onclick="full_window_loader()">
                                                            <?php echo e(isset($doctor->serving) ? $doctor->serving : 0); ?>

                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e(url('status_filtering/'.$doctor->id.'/F')); ?>" class="btn btn-circle
                                                            <?php if($doctor->finished): ?> bg-blue <?php else: ?> btn-default disabled <?php endif; ?>"
                                                           onclick="full_window_loader()">
                                                            <?php echo e(isset($doctor->finished) ? $doctor->finished : 0); ?>

                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php $count_all = $doctor->pending + $doctor->paused + $doctor->nawc +
                                                            $doctor->serving + $doctor->finished; ?>
                                                        <a href="<?php echo e(url('status_filtering/'.$doctor->id.'/A')); ?>" class="btn btn-circle
                                                            <?php if($count_all): ?> bg-black <?php else: ?> btn-default disabled <?php endif; ?>"
                                                           onclick="full_window_loader()">
                                                            <?php echo e($count_all); ?>

                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing the today`s queue status of online and offline doctors.
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




<?php $__env->startSection('pagescript'); ?>
    <script src="<?php echo e(asset('public/OPDMS/vue/reception/queue.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/reception/notification.js')); ?>"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>