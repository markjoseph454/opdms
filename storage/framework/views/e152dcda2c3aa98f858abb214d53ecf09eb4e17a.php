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
            <br/>
            <div class="row searchpatient">

                <form method="post" action="<?php echo e(url('searchadmitted')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <div class="col-md-6">
                        <a href="#" class="btn btn-success btn-sm"
                            data-toggle="tooltip"
                            title="Register new in-patient"
                            id="addinpatient">
                            <span class="fa fa-user-plus"></span> REGISTER PATIENT</a>
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
                            <!-- <th><i class="fa fa-user-circle-o"></i></th> -->
                            <th>HOSPITAL#</th>
                            <!-- <th>BARCODE</th> -->
                            <th>FULLNAME</th>
                            <!-- <th>ADDRESS</th> -->
                            <th>BIRTHDAY</th>
                            <th>AGE</th>
                            <th>SEX</th>
                            <th>REGISTERED<br>DATETIME</th>
                            <!-- <th class="info">STATUS</th>
                            <th>ACTION</th> -->
                            <th>PRINT ID</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                            <th>WATCHER</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($data)): ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td hidden></td>
                                <!-- <td><i class="fa fa-user"></i></td> -->
                                <td align="center"><?php echo e($list->hospital_no); ?></td>
                                <!-- <td align="center"><?php echo e($list->barcode); ?></td> -->
                                <td><?php echo e($list->last_name.', '.$list->first_name.' '.substr($list->middle_name, 0,1).'.'); ?> <?php echo e($list->suffix); ?></td>
                                <!-- <td><?php echo e($list->address); ?></td> -->
                                <?php if($list->birthday): ?>
                                <td align="center"><?php echo e(Carbon::parse($list->birthday)->format('M d, Y')); ?></td>
                                <?php else: ?>
                                <td align="center">N/A</td>
                                <?php endif; ?>
                                 <?php
                                  $agePatient = App\Patient::age($list->birthday)
                                ?>
                                <td align="center"><?php echo e(($agePatient)?$agePatient:'N/A'); ?></td>
                                <td align="center"><?php echo e(($list->sex == 'M')?"MALE":"FEMALE"); ?></td>
                                <td align="center"><?php echo e(Carbon::parse($list->created_at)->format('M d, Y')); ?><br><?php echo e(Carbon::parse($list->created_at)->format('h:i a')); ?></td>
                                
                               <td align="center">
                                   <a href="<?php echo e(url('hospitalcard/'.$list->patients_id)); ?>"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Print Patient ID CARD"
                                        target="_blank" 
                                        data-id="<?php echo e($list->patients_id); ?>" 
                                        class="btn btn-primary btn-circle">
                                       <i class="fa fa-print"></i>
                                   </a>
                               </td>
                               <td align="center">
                                   <a href="<?php echo e(url('patients/'.$list->patients_id.'/edit')); ?>" 
                                    data-toggle="tooltip"
                                    title="Edit Patient Information"
                                    class="btn btn-info btn-circle edit">
                                       <i class="fa fa-pencil"></i>
                                   </a>
                               </td>
                               <td align="center">
                                   <a href="<?php echo e(url('deleteinpatient/'.$list->patients_id)); ?>" 
                                    data-toggle="tooltip"
                                    title="Delete Patient"
                                    class="btn btn-danger btn-circle delete"
                                    onclick="return confirm('Delete This Row?')">
                                       <i class="fa fa-remove"></i>
                                   </a>
                               </td>
                                <td align="center">
                                    <a  href="#" 
                                        data-toggle="tooltip"
                                        title="Patient Watcher"
                                        class="btn btn-warning btn-circle"
                                        data-id="<?php echo e($list->patients_id); ?>"
                                        id="viewwatcher">
                                        <i class="fa fa-user-plus"></i>
                                    </a>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php echo $__env->make('patients.watchermodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('patients.addpatientmodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <br><br>
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
