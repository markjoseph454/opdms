<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Edit Result
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

                        <form action="<?php echo e(url('radiology/'.$radiology->id)); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

                            <?php echo e(method_field('PATCH')); ?>


                            <?php echo $__env->make('radiology.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <textarea name="result" class="my-editor" id="" cols="30" rows="40"><?php echo e(isset($radiology->result) ? $radiology->result : ''); ?></textarea>
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
