<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Pharmacy
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
     <link href="<?php echo e(asset('public/css/pharmacy/logs.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('pharmacy.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('pharmacy/dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>


            <div class="content-wrapper logs">
                <br>
                <br>
                <div class="banner">
                    <h3 class="text-left"> <i class="fa fa-book"></i> REPORTS</h3>
                </div>
                
                <div class="col-md-12" style="padding-top: 10px;">
                    <form class="form" method="GET" target="_blank">
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>TYPE</label>
                              <select class="form-control" name="filter" required>
                                <option value="" hidden>--FILTER BY--</option>
                                <option value="class-c">MSS CLASS-C</option>
                                <option value="class-d">MSS CLASS-D</option>
                                <option value="full-pay">FULL PAY</option>
                                <option value="free-meds">FREE MEDS</option>
                                <option value="all">ALL</option>
                                <!-- <option>INVENTORY</option> -->
                              </select>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>FROM</label>
                              <input type="date" name="from" class="form-control" value="<?php if(isset($_GET['from'])): ?><?php echo e($_GET['from']); ?><?php endif; ?>" required>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>TO</label>
                              <input type="date" name="to" class="form-control" value="<?php if(isset($_GET['to'])): ?><?php echo e($_GET['to']); ?><?php endif; ?>" required>
                          </div>
                      </div>
                      <div class="col-md-3 text-center">
                          <br>
                          <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-cogs"></span> GENERATE</button>
                      </div>
                    </form>
                </div>  
            </div> 
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
    <script src="<?php echo e(asset('public/js/pharmacy/main.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
