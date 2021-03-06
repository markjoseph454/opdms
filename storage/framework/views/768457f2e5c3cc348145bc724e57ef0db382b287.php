<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | SEARCH PATIENT
    <?php $__env->endSlot(); ?>

    <?php $__env->startSection('pagestyle'); ?>
        <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo e(asset('public/css/mss/searchpatient.css')); ?>" />
    <?php $__env->stopSection(); ?>


    <?php $__env->startSection('header'); ?>
        <?php echo $__env->make('mss/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>
        <div class="container">
            <br/>
            <div class="row searchpatient">
                <form action="<?php echo e(url('searchrecord')); ?>" method="post">
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
                <h3 class="text-center">Search Results</h3>
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
                            <th>STATUS</th>
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
                                <td>
                                    <?php if($patient->mss_id == ''): ?>
                                    <form action="<?php echo e(url('classification')); ?>" method="post">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="barcode" value="<?php echo e($patient->barcode); ?>" class="form-control inputbarcode">
                                        <button type="submit" class="btn btn-default">Classify</button>
                                    </form>
                                    <?php else: ?>
                                    <a href="#" class="btn btn-success printcard">
                                        <!-- <?php echo e(url('mss/'.$patient->patients_id.'/edit')); ?> -->
                                        Done <?php echo e($patient->label.'-'.$patient->description); ?>

                                            <?php if(is_numeric($patient->description)): ?>
                                                %
                                            <?php else: ?>
                                            <?php endif; ?> 
                                            <i class="fa fa-check"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
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
        <script src="<?php echo e(asset('public/js/mss/searchpatient.js')); ?>"></script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
