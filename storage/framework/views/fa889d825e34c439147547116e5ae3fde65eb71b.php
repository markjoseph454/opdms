<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Search
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('public/css/patients/searchpatient.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/css/radiology/master.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/css/radiology/patients.css')); ?>">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('radiology.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <div class="container">

        <?php echo $__env->make('radiology.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make('radiology.quickView', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <br/>
        <div class="row searchpatient">
            <form action="<?php echo e(url('radiologySearch')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <div class="col-md-8 col-md-offset-2">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter By <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="" class="name">Patient Name</a></li>
                                    <li><a href=""  class="birthday">Patient Birthday</a></li>
                                    <li><a href="" class="barcode">Patient Barcode</a></li>
                                    <li><a href="" class="hospital_no">Patient Hospital No.</a></li>
                                    <li><a href="" class="created_at">Date Registered</a></li>
                                </ul>
                            </div><!-- /btn-group -->
                            <input type="text" name="name" id="searchInput" class="form-control" placeholder="Search For Patient Name..." autofocus />
                            <span class="input-group-btn">
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </span>
                        </div><!-- /input-group -->
                    </div>
                </div>
            </form>
        </div>

        <br/>
        <h3 class="text-center">SEARCH RESULTS</h3>
        <br/>

        <?php echo $__env->make('message.msg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover" id="unprintedTable">
                <thead>
                <tr>
                    <th>HOSPITAL#</th>
                    <th>BARCODE</th>
                    <th>FULLNAME</th>
                    <th>ADDRESS</th>
                    <th>BIRTHDAY</th>
                    <th>SEX</th>
                    <th>REG.DATE</th>
                    <th>VIEW</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($patients)): ?>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($patient->hospital_no); ?></td>
                            <td><?php echo e($patient->barcode); ?></td>
                            <td><?php echo e($patient->last_name.' '.$patient->first_name.' '.$patient->middle_name); ?></td>
                            <td><?php echo e($patient->address); ?></td>
                            <td><?php echo e(Carbon::parse($patient->birthday)->toFormattedDateString()); ?></td>
                            <td><?php echo e($patient->sex); ?></td>
                            <td><?php echo e(Carbon::parse($patient->created_at)->toFormattedDateString()); ?></td>
                            <?php if($patient->rid): ?>
                                <td>
                                    <button class="btn btn-success btn-sm"
                                            data-toggle="modal" data-target="#radiologyModal"
                                            onclick="manageRequest(<?php echo e($patient->id); ?>)">
                                        <i class="fa fa-file-text-o"></i> Request
                                    </button>
                                </td>
                            <?php else: ?>
                                <td>
                                    <label class="label label-danger">No Request</label>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <br><br>
<?php $__env->stopSection(); ?>




<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/patients/unprinted.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/radiology/manage.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/radiology/quickView.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/master.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
