<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Login
    <?php $__env->endSlot(); ?>

    <?php $__env->startSection('pagestyle'); ?>
        <link href="<?php echo e(asset('public/css/partials/login.css')); ?>" rel="stylesheet" />
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('header'); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>
    <div class="container-fluid loginWrapper">
        <div class="container">
            <div class="row">
                <div class=" col-md-3 logoWrapper">
                    <img src="<?php echo e(asset('public/images/doh-logo2.png')); ?>" class="img-responsive" />
                    <img src="<?php echo e(asset('public/images/evrmc-logo.png')); ?>" class="img-responsive" />
                </div>
                <div class="col-md-9 loginBannerTitle">
                    <h3>Eastern Visayas Regional Medical Center</h3>
                    <h1>OUTPATIENT RECORD MANAGEMENT SYSTEM</h1>
                </div>
            </div>

            <br/>
            <br/>
            <br/>

            <div class="row">
                <form action="<?php echo e(url('login')); ?>" method="post">
                    <div class="container">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="row">
                                <h1 class="text-center">Secure Login</h1>
                                <br/>

                                    <?php echo $__env->make('message.msg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                    <?php echo e(csrf_field()); ?>


                                    <div class="form-group <?php if($errors->has('username')): ?> has-error <?php endif; ?>">
                                        <div class="input-group">
                                            <input type="text" name="username" value="<?php echo e(old('username')); ?>" class="form-control"
                                            placeholder="Enter Username" aria-describedby="usernameaddon" autofocus />
                                            <span class="input-group-addon addonIcon" id="usernameaddon">
                                                <i class="fa fa-user"></i>
                                            </span>
                                        </div>
                                        <?php if($errors->has('username')): ?>
                                            <span class="help-block">
                                                <strong class=""><?php echo e($errors->first('username')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <br/>

                                    <div class="form-group <?php if($errors->has('password')): ?> has-error <?php endif; ?>">
                                        <div class="input-group">
                                        <input type="password" id="pass_input" name="password" class="form-control" placeholder="Enter Password"
                                        aria-describedby="passwordaddon" />
                                        <span class="input-group-addon addonIcon" id="passwordaddon">
                                                <i class="fa fa-unlock-alt"></i>
                                            </span>
                                        </div>
                                        <?php if($errors->has('password')): ?>
                                            <span class="help-block">
                                                <strong class=""><?php echo e($errors->first('password')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <p class="capslockon">
                                        <i class="fa fa-warning"></i>
                                        Caps Lock is on.
                                    </p>

                                    <div class="form-group">
                                        <br/>
                                        <button type="submit" class="btn btn-block btn-default">
                                            Login <i class="fa fa-sign-in"></i>
                                        </button>
                                    </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
        
    <?php $__env->stopSection(); ?>





    <?php $__env->startSection('footer'); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('pagescript'); ?>
        <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <script src="<?php echo e(asset('public/js/partials/login.js')); ?>"></script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
