<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Add Result
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/css/radiology/master.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/css/radiology/addResult.css')); ?>">
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('radiology/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="container">


            <div class="container">

                <h2 class="text-left">
                    <?php echo e($radiology->category); ?> | <span class="text-danger"><?php echo e($radiology->sub_category); ?></span></h2>
                <hr>


                <?php echo $__env->make('radiology.store.tabs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                <div class="tab-content">
                    <div id="addResultWrapper" class="tab-pane fade in active">

                        <?php echo $__env->make('message.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <form action="<?php echo e(url('radiology')); ?>" method="post">

                            <?php echo e(csrf_field()); ?>



                                <?php echo $__env->make('radiology.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                            <textarea name="result" class="my-editor" id="" cols="30" rows="40"><?php echo e($radiology->content); ?></textarea>
                            <input type="hidden" name="patient_id" value="<?php echo e($radiology->patients_id); ?>" />
                            <input type="hidden" name="user_id" value="<?php echo e($radiology->users_id); ?>" />
                            <input type="hidden" name="ancillaryrequest_id" value="<?php echo e($radiology->id); ?>" />
                        </form>

                    </div>
                </div>


            </div>


        </div>
    </div>

<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/radiology/richtexteditor.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/preventDelete.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/radiology/template.js')); ?>"></script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
