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
    <!-- <link href="<?php echo e(asset('public/css/doctors/patientlist.css')); ?>" rel="stylesheet" /> -->
    <!-- <link href="<?php echo e(asset('public/css/receptions/designation.css')); ?>" rel="stylesheet" /> -->
    <!-- <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" /> -->
    <link href="<?php echo e(asset('public/css/pharmacy/logs.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/pharmacy/report.css')); ?>" rel="stylesheet" />

    
<?php $__env->stopSection(); ?>




<?php $__env->startSection('content'); ?>
 

            <div class="container-fluid logs">
                <br>
                <div class="container">
                  <div class="banner">
                      <h3 class="text-left"> <i class="fa fa-bar-chart-o" style="color: #2db22d;"></i> CENSUS</h3>
                  </div>
                  <div class="col-md-12" style="padding-top: 10px;">
                    <?php echo $__env->make('message.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                      <form class="form census-form" method="GET">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>TYPE</label>
                                <select class="form-control type" name="type" required>
                                  <option value="1000" hidden>--TYPE--</option>
                                 
                                  <option value="CHARGE" <?php if($request->type == "CHARGE"): ?> selected <?php endif; ?>>CHARGE TO FUND</option>
                                  <option value="DISPENSED" <?php if($request->type == "DISPENSED"): ?> selected <?php endif; ?>>10 DISPENSED MEDICINES</option>
                                  <option value="DEMOGRAPHIC" <?php if($request->type == "DEMOGRAPHIC"): ?> selected <?php endif; ?>>DEMOGRAPHIC REPORT</option>
                                
                                </select>
                            </div>
                        </div>
                        <div class="dual_month" <?php if($request->month != ""): ?>) hidden <?php endif; ?>>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="">FROM(MONTH)</label>
                                    <select class="form-control start_month" name="start_month">
                                        <?php $__currentLoopData = $month; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <option value="<?php echo e($list->months); ?>" <?php if($request->start_month == $list->months): ?> selected <?php endif; ?>><?php echo e(Carbon::parse($list->dates)->format('F')); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>TO(MONTH)</label>
                                    <select class="form-control end_month" name="end_month">
                                        <?php $__currentLoopData = $month; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <option value="<?php echo e($list->months); ?>" <?php if($request->end_month == $list->months): ?> selected <?php endif; ?>><?php echo e(Carbon::parse($list->dates)->format('F')); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="single_month" <?php if($request->month == ""): ?>) hidden <?php endif; ?>>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="">CHOOSED MONTH</label>
                                    <select class="form-control month" name="month">
                                        <option value="" hidden>SELECT</option>
                                        <?php $__currentLoopData = $month; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <option value="<?php echo e($list->months); ?>" <?php if($request->month == $list->months): ?> selected <?php endif; ?>><?php echo e(Carbon::parse($list->dates)->format('F')); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>YEAR</label>
                                <!-- <input type="text" name="to" class="form-control datepicker" placeholder="Ending Date" aria-describedby="endingDate" id="to" required> -->
                                <select class="form-control" name="year">
                                    <?php $__currentLoopData = $year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list->years); ?>"><?php echo e($list->years); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 text-center">
                            <br>
                            <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-cogs"></span> GENERATE</button>
                        </div>
                      </form>
                  </div> 
                </div> 
                <?php if($request->type == "CHARGE"): ?>
                  <?php echo $__env->make('pharmacy.census.chargetofund', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php elseif($request->type == "DISPENSED"): ?>
                  <?php echo $__env->make('pharmacy.census.dispensedmeds', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php elseif($request->type == "DEMOGRAPHIC"): ?>
                  <?php echo $__env->make('pharmacy.census.demographic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>
               
            </div> 

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
   <!--  <script src="<?php echo e(asset('public/plugins/js/form.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/pharmacy/main.js')); ?>"></script> -->
    <!-- <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script> -->
    <script src="<?php echo e(asset('public/js/pharmacy/report.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
