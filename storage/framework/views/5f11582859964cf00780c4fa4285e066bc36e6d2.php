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
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('pharmacy.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('pharmacy/dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>


            <div class="content-wrapper logs">
              <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" >&times;</a>
                <div>
                  <br>
                  <br>
                  <br>
                </div>
                <div class="table-responsive" style="margin: 10px;">
                  <table class="table table-bordered">
                    <tr>
                      <th>EMPLOTYEE NAME:</th>
                    </tr>
                    <tr>
                      <td class="names"></td>
                    </tr>
                  </table>
                </div>
                <div class="bg-success bannersidenav">
                  <p class="actions"></p>
                </div>
                <div class="table-responsive" style="margin: 10px;">
                    <table class="table table-bordered">
                      <tr>
                        <th colspan="2" style="text-align: center;"><span class="fa fa-info"></span> ITEM INFORMATIONS</th>
                      </tr>
                      <tr>
                        <th>ITEM CODE</th>
                        <td class="itemcodes"></td>
                      </tr>
                      <tr>
                        <th>BRAND</th>
                        <td class="brands"></td>
                      </tr>
                      <tr>
                        <th>GENERIC NAME</th>
                        <td class="genericnames"></td>
                      </tr>
                       <tr>
                        <th>EXPIRE DATE</th>
                        <td class="expires"></td>
                      </tr>
                      <tr>
                        <th>STOCK</th>
                        <td class="stocks"></td>
                      </tr>
                      <tr>
                        <th>STATUS</th>
                        <td class="statuss"></td>
                      </tr>
                      
                    </table>
                </div>
              </div>
                <br>
                <br>
                <div class="banner">
                    <h3 class="text-left"> <i class="fa fa-book"></i> LOGS</h3>

                </div>
                <div>
                  <br>
                </div>

                <div class="col-md-12 select-date">
                    <form class="form" method="GET">
                      <div class="col-md-3 col-md-offset-2">
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
                      <div class="col-md-3">
                          <br>
                          <button type="submit" class="btn btn-default btn-sm"><span class="fa fa-cogs"></span> PROCEED</button>
                      </div>
                    </form>
                   
                </div>  

                <div class="table table-responsive content-logs">
                    <table class="table table-striped table-bordered" id="logs">
                        <thead>
                            <tr>
                                <th hidden></th>
                                <th id="infos"><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="CLICK BY ROW TO VIEW FULL DETAILS"></i> </th>
                                <th class="info">LOG</th>
                                <th class="danger">REMARKS</th>
                                <th>BRAND</th>
                                <th>NAME/DESCRIPTION</th>
                               
                                <th>USER</th>
                                <th>DATETIME</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="logs-info">
                              <td hidden></td>
                              <td><i class="fa fa-info-circle info-icon" id="<?php echo e($list->id); ?>" data-toggle="tooltip" data-placement="right" title="CLICK BY ROW TO VIEW FULL DETAILS"></i></td>
                              <td class="info"><?php echo e($list->action); ?></td>
                              <td class="danger"><?php echo e($list->remarks); ?></td>
                              <td><?php echo e($list->brand); ?></td>
                              <td><?php echo e($list->item_description); ?></td>
                             
                              <td><?php echo e($list->user_name); ?></td>
                              <td><?php echo e(Carbon::parse($list->created_at)->toDayDateTimeString()); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
            </div> 
           
            <!-- .content-wrapper -->

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
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/pharmacy/logs.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
