<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(isset($title) ? $title : 'OPD'); ?></title>

        <!-- Styles -->
        <link href="<?php echo e(asset('public/plugins/css/font-awesome.min.css')); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo e(asset('public/plugins/css/bootstrap.css')); ?>">
        <link href="<?php echo e(asset('public/plugins/css/toastr.min.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/css/master.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/css/partials/navigation.css')); ?>" rel="stylesheet" />
        <!-- Load page style -->
        <?php echo $__env->yieldContent('pagestyle'); ?>

    </head>

    <body>

        <?php echo $__env->yieldContent('header'); ?>


        <?php echo $__env->yieldContent('content'); ?>


        <?php echo $__env->yieldContent('footer'); ?>

        <!-- Scripts -->
        <script src="<?php echo e(asset('public/plugins/js/jquery.js')); ?>"></script>
        <script src="<?php echo e(asset('public/plugins/js/bootstrap.js')); ?>"></script>
        <script src="<?php echo e(asset('public/plugins/js/toastr.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/master.js')); ?>"></script>

        <?php echo $__env->yieldContent('pagescript'); ?>



        <script src="<?php echo e(asset('public/js/patients/watcher.js')); ?>"></script>



            
    </body>
</html>
