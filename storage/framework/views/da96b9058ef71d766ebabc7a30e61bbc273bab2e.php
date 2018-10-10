<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Admitted Patients
    <?php $__env->endSlot(); ?>

    <?php $__env->startSection('pagestyle'); ?>
        <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo e(asset('public/css/patients/searchpatient.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('public/css/patients/admitted.css')); ?>" />
    <?php $__env->stopSection(); ?>


    <?php $__env->startSection('header'); ?>
        <?php echo $__env->make('patients/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                <h3 class="text-left"><small>PLEASE CHECK IF PATIENT ALREADY REGISTERED</small></h3>
                </div>
                <div class="col-md-4">
                    <br>
                    <form class="text-right" action="<?php echo e(url('ignorepatients')); ?>" method="post">
                         <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="last_name" value="<?php echo e($request->last_name); ?>">
                        <input type="hidden" name="first_name" value="<?php echo e($request->first_name); ?>">
                        <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-user-times"></span> Ignore All</button>
                        <a href="<?php echo e(url('admittedpatient')); ?>" type="submit" class="btn btn-success btn-sm"><span class="fa fa-mail-reply"></span> Cancel Registration</a>
                    </form>
                </div>
            </div>
            <br>
            <div class="table-responsive checkpatient">
                <table class="table table-striped" id="patienttable">
                    <thead>
                        <tr>
                            <th hidden></th>
                            <th>Hospital No</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Birthday</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Address</th>
                            <th>REGISTERED <br>DATETIME</th>
                            <th>Action</th>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $patient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td hidden></td>
                            <td class="bg-info text-center"><b><?php echo e($list->hospital_no); ?></b></td>
                            <td><?php echo e($list->last_name); ?></td>
                            <td><?php echo e($list->first_name); ?></td>
                            <td><?php echo e($list->middle_name); ?></td>
                            <td width="100"><?php echo e(Carbon::parse($list->birthday)->format('M d, Y')); ?></td>
                             <?php
                              $agePatient = App\Patient::age($list->birthday)
                            ?>
                            <td align="center"><?php echo e($agePatient); ?></td>
                            <td><?php echo e($list->sex); ?></td>
                            <td><?php echo e($list->address); ?></td>
                            <?php
                                $inpatient = App\Inpatient::checkInpatient($list->id);
                            ?>
                            <td align="center">
                                <?php if($inpatient): ?>
                                IN-PATIENT <br>
                                <?php echo e(Carbon::parse($inpatient->updated_at)->format('M d, Y')); ?>

                                    <br>
                                <?php echo e(Carbon::parse($inpatient->updated_at)->format('h:i a')); ?>

                                <?php else: ?>
                                OUT-PATIENT <br>
                                <?php echo e(Carbon::parse($list->addate)->format('M d, Y')); ?>

                                    <br>
                                <?php echo e(Carbon::parse($list->addate)->format('h:i a')); ?>

                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <?php if($inpatient): ?>
                                IN-PATIENT <br>
                                <a href="#" class="btn btn-success btn-sm disabled"><span class="fa fa-arrow-right"></span> Select</a>
                                <?php else: ?>
                                <a href="<?php echo e(url('selectpatient')); ?>/<?php echo e($list->id); ?>" class="btn btn-success btn-sm"><span class="fa fa-arrow-right"></span> Select</a>
                                <?php endif; ?>
                               
                            </td>
                                
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    
                </table>
            </div>
           
        </div>
        
    <?php $__env->stopSection(); ?>




    <?php $__env->startSection('pagescript'); ?>
        <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/patients/unprinted.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/patients/admitted.js')); ?>"></script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>

