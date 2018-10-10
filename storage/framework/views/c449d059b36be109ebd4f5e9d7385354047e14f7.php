<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Information
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('public/css/radiology/master.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/css/radiology/information.css')); ?>">
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('radiology/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="container">

            <br>

            <ul class="nav nav-pills nav-justified">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        Personal Information <i class="fa fa-user-o"></i>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#menu1">
                        Vital Signs <i class="fa fa-heartbeat"></i>
                    </a>
                </li>
            </ul>

            <div class="tab-content">


                <?php echo $__env->make('radiology.personalInfo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <?php echo $__env->make('radiology.vitalSigns', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            </div>



        </div>
    </div>

<?php $__env->stopSection(); ?>




<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
