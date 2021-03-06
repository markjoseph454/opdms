<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Search Patients
    <?php $__env->endSlot(); ?>

    <?php $__env->startSection('pagestyle'); ?>
        <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo e(asset('public/css/patients/searchpatient.css')); ?>" />
    <?php $__env->stopSection(); ?>


    <?php $__env->startSection('header'); ?>
        <?php echo $__env->make('patients/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>
        <div class="container">
            <br/>
            <div class="row searchpatient">
                <form action="<?php echo e(url('search')); ?>" method="post">
                    <?php echo e(csrf_field()); ?>

                    <div class="col-md-6">
                        <a href="<?php echo e(url('patients')); ?>" class="btn btn-success btn-sm"
                            data-toggle="tooltip"
                            title="Register new out-patient">
                            <span class="fa fa-user-plus"></span> ADD PATIENT</a>
                    </div>
                    <div class="col-md-6">
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

            <br>
            <?php echo $__env->make('message.msg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="unprintedTable">
                    <thead>
                        <tr>
                            <th hidden></th>
                            <th>HOSPITAL#</th>
                            <th>BARCODE</th>
                            <th>FULLNAME</th>
                            <th>ADDRESS</th>
                            <th>BIRTHDAY</th>
                            <th>AGE</th>
                            <th>SEX</th>
                            <th>REG.DATE</th>
                            <th>PRINTED</th>
                            <th>PAID</th>
                            <th>PRINT</th>
                            <th>EDIT</th>
                            <!-- <th>WATCHER</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($patients)): ?>
                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           
                            <tr>
                                <td hidden></td>
                                <td align="center"><?php echo e($patient->hospital_no); ?></td>
                                <td align="center"><?php echo e($patient->barcode); ?></td>
                                <td><?php echo e($patient->last_name.' '.$patient->first_name.' '.$patient->middle_name); ?></td>
                                <td><?php echo e($patient->address); ?></td>
                                <td align="center"><?php echo e(Carbon::parse($patient->birthday)->toFormattedDateString()); ?></td>
                                 <?php
                                  $agePatient = App\Patient::age($patient->birthday)
                                ?>
                                <td align="center"><?php echo e($agePatient); ?></td>
                                <td align="center"><?php echo e($patient->sex); ?></td>
                                <td align="center"><?php echo e(Carbon::parse($patient->created_at)->toFormattedDateString()); ?></td>
                                <td>
                                    <?php if($patient->printed == 'Y'): ?>
                                    <span class="label label-success">Printed </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if($patient->paid > 0): ?>
                                    <span class="label label-success">Paid: &nbsp; <?php echo e($patient->paid); ?> </span>
                                    <?php else: ?>
                                    <span class="label label-danger">Unpaid</span>
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                    <a 
                                            href="<?php echo e(url('hospitalcard/'.$patient->id)); ?>"
                                       target="_blank" data-id="<?php echo e($patient->id); ?>" class="btn btn-primary btn-circle">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </td>
                                <td align="center">
                                    <a href="<?php echo e(url('patients/'.$patient->id.'/edit')); ?>" class="btn btn-info btn-circle edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
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
        <script src="<?php echo e(asset('public/js/patients/unprinted.js')); ?>"></script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
