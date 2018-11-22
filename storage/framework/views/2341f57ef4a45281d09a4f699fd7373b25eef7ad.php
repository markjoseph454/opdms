<?php $__env->startComponent('OPDMS.partials.header'); ?>


    <?php $__env->slot('title'); ?>
        Update Account
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
                <?php if(Auth::user()->role == 5): ?> 
                    <?php echo $__env->make('OPDMS.reception.partials.search_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>





        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            <?php echo $__env->make('OPDMS.partials.boilerplate.header',
            ['header' => 'Update Account', 'sub' => 'Change your account information.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger" id="registerWrapper">


                        <div class="box-body">
                            <div class="col-md-6 col-md-offset-3">

                                <form action="<?php echo e(url('account/'.$user->id)); ?>" method="post" enctype="multipart/form-data">

                                    <?php echo e(csrf_field()); ?>

                                    <?php echo e(method_field('PATCH')); ?>


                                    <input type="hidden" name="id" value="<?php echo e($user->id); ?>" />

                                    <div class="form-group text-center <?php if($errors->has('profile')): ?> has-error <?php endif; ?>">

                                        <?php if($user->profile): ?>
                                            <?php
                                                $src = asset('public/users/'.$user->profile);
                                            ?>
                                        <?php else: ?>
                                            <?php
                                                $src = asset('public/images/user.svg')
                                            ?>
                                        <?php endif; ?>
                                        <img src="<?php echo e($src); ?>" class="img-responsive img-circle img-thumbnail center-block" />

                                        <?php if($errors->has('profile')): ?>
                                            <span class="help-block">
                                                <?php echo e($errors->first('profile')); ?>

                                            </span>
                                        <?php endif; ?>
                                        <br>
                                        <label class="btn btn-default btn-file text"
                                               title="Click to upload your profile picture"
                                               data-placement="left" data-container="body"
                                               data-toggle="tooltip">
                                            Upload Profile Picture
                                            <i class="fa fa-file-image-o"></i>
                                            <input type="file" name="profile" style="display: none;">
                                        </label>
                                        <span class="help-block fileDisplay"></span>
                                    </div>

                                    <br>

                                    <div class="form-group <?php if($errors->has('last_name')): ?> has-error <?php endif; ?>">
                                        <label for="">Last Name</label>
                                        <input type="text" name="last_name" class="form-control text-uppercase"
                                               value="<?php echo e($user->last_name); ?>"
                                               placeholder="Please Enter Last Name" />
                                        <?php if($errors->has('last_name')): ?>
                                            <span class="help-block">
                                                <?php echo e($errors->first('last_name')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>


                                            <div class="form-group <?php if($errors->has('first_name')): ?> has-error <?php endif; ?>">
                                                <label>First Name</label>
                                                <input type="text" name="first_name" class="form-control text-uppercase"
                                                       value="<?php echo e($user->first_name); ?>"
                                                       placeholder="Please Enter First Name" />
                                                <?php if($errors->has('first_name')): ?>
                                                    <span class="help-block">
                                                        <?php echo e($errors->first('first_name')); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>


                                    <div class="form-group <?php if($errors->has('middle_name')): ?> has-error <?php endif; ?>">
                                        <label>Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control text-uppercase"
                                               value="<?php echo e($user->middle_name); ?>"
                                               placeholder="Please Enter Middle Name" />
                                        <?php if($errors->has('middle_name')): ?>
                                            <span class="help-block">
                                                 <?php echo e($errors->first('middle_name')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group <?php if($errors->has('username')): ?> has-error <?php endif; ?>">
                                        <label>Username</label>
                                        <input type="text" name="username"
                                               class="form-control" value="<?php echo e($user->username); ?>"
                                               placeholder="Please Enter Username" />
                                        <?php if($errors->has('username')): ?>
                                            <span class="help-block">
                                                <?php echo e($errors->first('username')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group <?php if($errors->has('password')): ?> has-error <?php endif; ?>">
                                        <label>New Password</label>
                                        <input type="password" name="password" class="form-control password"
                                               placeholder="Please Enter New Password" />
                                        <?php if($errors->has('password')): ?>
                                            <span class="help-block">
                                                <?php echo e($errors->first('password')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm New Password</label>
                                        <input type="password" name="password_confirmation" class="form-control password"
                                               placeholder="Please Confirm New Password" />
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-flat btn-sm btn-default" toggle="on" id="showPassword">
                                            Show <i class="fa fa-eye"></i>
                                        </button>
                                        <button class="btn btn-flat btn-sm btn-default" id="generatePassword">
                                            Generate Password <i class="fa fa-key"></i>
                                        </button>
                                    </div>

                                    <div class="form-group <?php if($errors->has('old_password')): ?> has-error <?php endif; ?>">
                                        <label>Old Password</label>
                                        <input type="password" name="old_password" class="form-control"
                                               placeholder="Please Enter Old Password" />
                                        <?php if($errors->has('old_password')): ?>
                                            <span class="help-block">
                                                <?php echo e($errors->first('old_password')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>


                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-flat btn-success btn-loading">
                                            Submit & Save
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Change your account information.
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
    <script src="<?php echo e(asset('public/OPDMS/js/partials/register.js')); ?>"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>