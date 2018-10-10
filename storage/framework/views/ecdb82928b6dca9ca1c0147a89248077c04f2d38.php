<?php $__env->startComponent('partials/header'); ?>

  <?php $__env->slot('title'); ?>
    OPD | REPORT
  <?php $__env->endSlot(); ?>

  <?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/mss/report.css')); ?>" rel="stylesheet" />
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('header'); ?>
    <?php echo $__env->make('mss/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('content'); ?>
    <div class="container mainWrapper" id="wrapper">
        <div class="submitclassificationgenerate">
            <img src="public/images/loader.svg">
        </div>
        <div class="panel" id="mssreportgenarete">
            <div class="panel-heading">
            <h3>MSS REPORT <i class="fa fa-file-text-o"></i></h3>
            </div>
            <div class="panel-body" id="generatereportbody">
                <form class="form-horizontal generatemssreport" method="post" action="<?php echo e(url('genaratedreport')); ?>">
                     <?php echo e(csrf_field()); ?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>EMPLOYEE NAME</th>
                                <th colspan="2">DATE OF TRANSACTION</th>
                            </tr>
                            <tr>
                                <td rowspan="2">
                                    <select name="users_id" class="form-control" required>
                                        <option value="" hidden>--choose--</option>
                                        <?php $__currentLoopData = $employee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>;
                                        <option value="<?php echo e($list->id); ?>"><?php echo e($list->last_name.' '.$list->first_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <option value="ALL">ALL</option>
                                        
                                    </select>
                                </td>
                                <td>FROM(start of date transact)</td>
                                <td>TO(end of date transact)</td>
                            </tr>
                            <tr>
                                <td><input type="date" name="from" class="form-control" required></td>
                                <td><input type="date" name="to" class="form-control" required></td>
                            </tr>
                        </table>
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success">GENERATE <i class="fa fa-cog"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  <?php $__env->stopSection(); ?>
  <?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message/toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/js/mss/report.js')); ?>"></script>
  <?php $__env->stopSection(); ?>
<?php echo $__env->renderComponent(); ?>
