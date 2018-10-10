<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Requisition
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/css/doctors/requisition.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('doctors.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('doctors/dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>






            <div class="content-wrapper" style="padding: 55px 10px">

                <div class="container-fluid">

                    <?php echo $__env->make('doctors.requisition.patientName', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <div class="col-md-12 requsitionWrapper">

                        <div class="row">


                            <?php echo $__env->make('doctors.requisition.departments', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <?php echo $__env->make('doctors.requisition.selection', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        </div>

                    </div>


                    <?php echo $__env->make('doctors.requisition.selectedItems', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                </div>

            </div> <!-- .content-wrapper -->







        <?php $__env->stopSection(); ?>
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>






<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/requisition/master.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/requisition/meds.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/requisition/radiology.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->renderComponent(); ?>
