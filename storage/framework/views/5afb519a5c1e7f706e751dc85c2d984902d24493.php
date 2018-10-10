<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Census
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/patients/reports.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('patients/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        <form class="form-horizontal generate-form" method="GET">
            <div class="row">
                <div class="col-md-7">
                    <div class="col-md-4" style="margin-right: 10px;">
                        <div class="form-group">
                            <label>TYPE</label>
                            <select class="form-control type" name="type" required>
                                <option value="" hidden>Select</option>
                                <option value="61" <?php if($request->type == "55"): ?> selected <?php endif; ?>>OUT PATIENT</option>   
                                <option value="54" <?php if($request->type == "54"): ?> selected <?php endif; ?>>IN PATIENT</option>  
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-right: 10px;">
                           
                            <div class="form-group">
                                <label>USER &nbsp;&nbsp;&nbsp;</label>
                                <select class="form-control user" name="user" required>
                                   
                                    
                                </select>
                            </div>
                    </div>
                    <div class="col-md-3" style="margin-right: 10px;">
                        <div class="form-group">
                            <label>GROUP BY</label>
                            <select class="form-control" name="group">
                                <option value="DATE" <?php if($request->group == "DATE"): ?> selected <?php endif; ?>)>DAILY</option>
                                <option value="MONTH" <?php if($request->group == "MONTH"): ?> selected <?php endif; ?>)>MONTHLY</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-7">
                    <div class="col-md-4" style="margin-right: 10px;">
                        <div class="form-group">
                            <label>STARTING DATE</label>
                            <input type="date" name="from" class="form-control" value="<?php if($request->from): ?><?php echo e($request->from); ?><?php else: ?><?php echo e(Carbon::now()->setTime(0,0)->format('Y-m-d')); ?><?php endif; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-right: 10px;">
                        <div class="form-group">
                            <label>ENDING DATE</label>
                            <input type="date" name="to" class="form-control" value="<?php if($request->to): ?><?php echo e($request->to); ?><?php else: ?><?php echo e(Carbon::now()->setTime(0,0)->format('Y-m-d')); ?><?php endif; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3" style="margin-right: 10px;">
                        <div class="form-group">
                            <label>&nbsp;</label><br>
                            <button type="submit" class="btn btn-success"><span class="fa fa-cog"></span> Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <?php
                        if($request->type == 55):
                            $type = 'IN PATIENT';
                        else:
                            $type = 'OUT PATIENT';
                        endif;
                    ?>
                    <?php if(isset($request->type)): ?>
                    <br>
                    <label class="label label-warning census-warning"><span class="fa fa-info-circle"></span> Census of <?php echo e($type); ?>, Date Between <?php echo e(Carbon::parse($request->from)->format('F d, Y')); ?> to <?php echo e(Carbon::parse($request->to)->format('F d, Y')); ?></label>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <br>
        <div class="table-responsive" id="referralcontainer">
            <table class="table table-striped" id="reportsTable">
                <thead class="success">
                    <tr style="background-color: #ccc">
                        <th hidden></th>
                        <th class="text-center">
                            <?php if($request->group): ?>
                                <?php echo e($request->group); ?>

                            <?php else: ?>
                                <?php echo e("DATE"); ?>

                            <?php endif; ?>
                        </th>
                        <th class="text-center">NUMBER</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i=0;
                    ?>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td hidden></td>
                        <td align="center">
                            <?php if($request->group == "DATE"): ?>
                            <?php echo e(Carbon::parse($list->date)->format('m/d/Y')); ?>

                            <?php elseif($request->group == "MONTH"): ?>
                            <?php echo e(Carbon::parse($list->date)->format('F 0f Y')); ?>

                            <?php endif; ?>
                        </td>
                        <td align="center"><?php echo e($list->result); ?></td>
                        <?php
                        $i+=$list->result;
                        ?>
                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <table class="table table-bordered">
                 <tr>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center"><?php echo e($i); ?></th>
                </tr>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/patients/reports.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->renderComponent(); ?>
