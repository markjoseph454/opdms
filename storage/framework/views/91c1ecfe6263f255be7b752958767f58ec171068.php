<?php $__env->startComponent('OPDMS.partials.header'); ?>


    <?php $__env->slot('title'); ?>
        Services
    <?php $__env->endSlot(); ?>


<?php $__env->startSection('pagestyle'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_queue.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/partials/patient_information.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_assignation.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/notification.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/partials/consultation_all.css')); ?>" />
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



            
            <?php echo $__env->make('OPDMS.partials.modals.modal_container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

        <?php echo $__env->make('OPDMS.reception.modals.services_add', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>





            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            <?php echo $__env->make('OPDMS.partials.boilerplate.header',
            ['header' => 'Ancillary items & Services offered', 'sub' =>
            'Shown here are all the ancillary items & services offered by this clinic.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        <div class="box-header with-border">

                            <?php
                                $active = 0;
                                $inactive = 0;
                                foreach($data as $row){
                                    if ($row->status == 'active'){
                                        $active = $row->total;
                                    }
                                    if ($row->status == 'inactive'){
                                        $inactive = $row->total;
                                    }
                                }
                            ?>
                            
                            <button class="btn bg-aqua-gradient btn-flat" v-on:click="service_add">
                                Add Service <i class="fa fa-plus"></i>
                            </button>
                            <a href="<?php echo e(url('services_offered/A')); ?>" class="btn bg-green btn-flat">
                                Active <span class="badge"><?php echo e($active); ?></span>
                            </a>
                            <a href="<?php echo e(url('services_offered/I')); ?>" class="btn bg-red btn-flat">
                                Inactive <span class="badge"><?php echo e($inactive); ?></span>
                            </a>
                            <a href="<?php echo e(url('services_offered')); ?>" class="btn bg-black btn-flat">
                                All <span class="badge"><?php echo e($active + $inactive); ?></span>
                            </a>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" id="dataTable1">
                                    <thead>
                                    <tr>
                                        <th>Service Description</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!$services->isEmpty()): ?>
                                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="text-blue text-bold"><?php echo e($service->sub_category); ?></td>
                                                <td>&#8369; <?php echo e(number_format($service->price, 2)); ?></td>
                                                <td>
                                                    <?php if($service->status == 'active'): ?>
                                                        <label class="label label-success">
                                                            Active
                                                        </label>
                                                    <?php else: ?>
                                                        <label class="label label-danger">
                                                            Inactive
                                                        </label>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <button v-on:click="service_edit(<?php echo e($service->sub_id); ?>)" class="btn bg-blue btn-sm btn-flat">
                                                        <i class="fa fa-pencil"></i> Edit
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
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
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>

    <?php if($errors->has('sub_category') || $errors->has('price')): ?>
        <script>
            $('#services_add_modal').modal();
        </script>
    <?php endif; ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>