<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Overview
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/patients/register.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/doctors/patientlist.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/designation.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/receptions/status.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/requisition/medicines.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/ancillary/charging.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <br>
    <div class="container-fluid" id="overviewWrapper">

        <?php echo $__env->make('doctors.medicalRecords', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxConsultationList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxRequisitionList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxRefferals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.ajaxFollowup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.requisition.medsWatch', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('doctors.records.radiology', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.chargingmodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('ancillary.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


        <?php
            $chrgingClinics = array(3,5,8,24,32,34,10,48,22,21,25,11);
            $noDoctorsClinic = array(10,48,22,21);
        ?>

        <div class="">

            <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                <?php echo $__env->make('receptions.overview.doctors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>

            <div class="<?php echo e((!in_array(Auth::user()->clinic, $noDoctorsClinic))? 'col-md-8' : 'container'); ?> patientsWrapper">
                <br>

                <?php echo $__env->make('receptions.overview.title', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <?php if(in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                    <hr>
                    <?php echo $__env->make('receptions.ancillary.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php else: ?>
                    <?php echo $__env->make('receptions.overview.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>

                <br>
                <div class="table-responsive patientsOverview">
                    <table class="table" id="patientsTable">

                        <?php echo $__env->make('receptions.overview.thead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                        <tbody>
                            <?php if(count($patients) > 0): ?>
                                <?php
                                    $fin = 0;
                                    $can = 0;
                                    $pau = 0;
                                    $unassgned = 0;
                                    $pen = 0;
                                    $serv = 0;
                                ?>
                                <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if($patient->status == 'P'){
                                        $asgn = 'disabled onclick="return false"';
                                        $reasgn = '';
                                        $cancel = '';
                                        $status = 'pending';
                                        $pen++;
                                        }
                                    elseif($patient->status == 'S'){
                                        $asgn = 'disabled onclick="return false"';
                                        $reasgn = 'disabled onclick="return false"';
                                        $cancel = 'disabled onclick="return false"';
                                        $status = 'serving';
                                        $serv++;
                                        }
                                    elseif($patient->status == 'F'){
                                        /*$asgn = 'disabled onclick="return false"';*/
                                        $asgn = '';
                                        $reasgn = 'disabled onclick="return false"';
                                        $cancel = 'disabled onclick="return false"';
                                        $status = 'finished';
                                        $fin++;
                                        }
                                    elseif($patient->status == 'C'){
                                        $asgn = '';
                                        $reasgn = 'disabled onclick="return false"';
                                        $cancel = 'disabled onclick="return false"';
                                        $status = 'cancel';
                                        $can++;
                                        }
                                    elseif($patient->status == 'H'){
                                        $asgn = '';
                                        $reasgn = 'disabled onclick="return false"';
                                        $cancel = 'disabled onclick="return false"';
                                        $status = 'paused';
                                        $pau++;
                                        }
                                    else{
                                        $asgn = '';
                                        $reasgn = 'disabled onclick="return false"';
                                        $cancel = '';
                                        $status = 'unassigned';
                                        $unassgned++;
                                        }
                                    ?>


                                <tr>

                                    <?php echo $__env->make('receptions.overview.patient', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                    <?php echo $__env->make('receptions.overview.info', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                    <?php
                                        if($patient->ff + $patient->rf > 0){
                                            $assignedDoctor = App\Refferal::countAllNotifications($patient->id);
                                        }else{
                                            $assignedDoctor = array();
                                        }
                                    ?>

                                    <?php if(Auth::user()->clinic != 21 || Auth::user()->clinic != 22): ?>
                                        <?php echo $__env->make('receptions.overview.records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <?php endif; ?>

                                    <?php if(!in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
                                        <?php echo $__env->make('receptions.overview.assign', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php echo $__env->make('receptions.overview.reassign', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <?php endif; ?>



                                    <?php if(in_array(Auth::user()->clinic, $chrgingClinics)): ?>
                                        <?php
                                            $charging = App\Ancillaryrequist::otherCharging($patient->id);
                                        ?>
                                    <?php endif; ?>



                                    <?php echo $__env->make('receptions.overview.cancel', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                    <?php echo $__env->make('receptions.overview.done', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                    <?php echo $__env->make('receptions.overview.charging', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>

                                <?php echo $__env->make('receptions.overview.noPatient', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <?php endif; ?>
                        </tbody>
                    </table>




                </div>

                <?php echo $__env->make('partials.legend', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>

    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/overview.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/ajaxRecords.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/consultation.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/master.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/medsWatch.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/ultrasound.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/radiologyQuickView.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/ancillary/charging.js')); ?>"></script>

    <?php echo $__env->make('receptions.message.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>




<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
