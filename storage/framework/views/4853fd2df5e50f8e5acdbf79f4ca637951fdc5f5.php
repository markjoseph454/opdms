<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Edit Account
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/css/doctors/consultation.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/partials/account.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('doctors.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('doctors/dashboard'); ?>
<?php $__env->startSection('main-content'); ?>


    <div class="content-wrapper">
        <br/>

        <div class="container-fluid">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Consultation</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td><?php echo e($row->patient); ?></td>
                        <td><?php echo e($row->doctor); ?></td>
                        <td><?php echo e($row->consultation); ?></td>
                        <td><?php echo e($row->created_at->toFormattedDateString()); ?></td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

        </div>

    </div> <!-- .content-wrapper -->


<?php $__env->stopSection(); ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>




<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/form.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/main.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
