<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Edit Templates
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/css/radiology/master.css')); ?>">
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('radiology/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="container">


            <div class="container">

                <h3>
                    Edit Templates
                </h3>

                <hr>

                <?php echo $__env->make('radiology.store.templatesTabs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                <div class="tab-content">
                    <div id="addResultWrapper" class="tab-pane fade in active">
                        <br>
                        <form action="<?php echo e(url('editTemplate')); ?>" method="post">
                            <?php echo e(csrf_field()); ?>


                            <input type="hidden" name="id" value="<?php echo e($template->id); ?>" />


                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group <?php if($errors->has('description')): ?> has-error <?php endif; ?>">
                                        <small class="help text-danger">Required Field</small>
                                        <input type="text" name="description" value="<?php echo e($template->description); ?>"
                                               class="form-control" placeholder="Enter Description" required />
                                        <?php if($errors->has('description')): ?>
                                            <span class="help-block">
                                        <strong class=""><?php echo e($errors->first('description')); ?></strong>
                                    </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <small class="help text-danger">Optional Field</small> &nbsp;
                                        <small class="text-muted">Please select a service where this template will be preloaded.</small>
                                        <select name="subcategory_id" id="" class="form-control">
                                            <option value="">--Template For--</option>
                                            <?php $__currentLoopData = $radiology; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($row->id); ?>" <?php echo e(($row->id == $template->subcategory_id)? 'selected':''); ?>>
                                                    <?php echo e($row->sub_category); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                            </div>





                            <textarea name="result" class="my-editor" id="" cols="30" rows="40"><?php echo e($template->content); ?></textarea>
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
    <script src="<?php echo e(asset('public/js/radiology/templates/ultrasound.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/radiology/templates/xray.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/radiology/richtexteditor.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/preventDelete.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
