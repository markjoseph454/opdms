<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | History
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('public/css/radiology/master.css')); ?>">
    <link href="<?php echo e(asset('public/css/doctors/patientlist.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/requisition/medicines.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('public/css/radiology/patients.css')); ?>">
    <link href="<?php echo e(asset('public/css/receptions/status.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('radiology/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="container">

          <?php echo $__env->make('doctors.medicalRecords', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php echo $__env->make('doctors.ajaxConsultationList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php echo $__env->make('doctors.ajaxRequisitionList', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php echo $__env->make('doctors.ajaxRefferals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php echo $__env->make('doctors.ajaxFollowup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php echo $__env->make('doctors.requisition.medsWatch', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php echo $__env->make('doctors.records.radiology', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            <?php echo $__env->make('radiology.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <?php echo $__env->make('radiology.quickView', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <hr>
            <?php echo $__env->make('radiology.historyForm', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <hr>

            <?php if($patients && count($patients) > 0): ?>

            <div class="table-responsive">

                <table class="table" id="historyTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Age</th>
                        <th>Information</th>
                        <th>Records</th>
                        <th>Action</th>
                        <th>Event</th>
                        <th>Timestamp</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $waiting = 0;
                        $posted = 0;
                    ?>

                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <?php
                                      switch ($patient->queue_status){
                                          case 'F':
                                              $stats = 'finishedTabActive';
                                              $waiting++;
                                              break;
                                          default:
                                              $stats = 'servingTabActive';
                                              $posted++;
                                              break;
                                      }
                                      $age = App\Patient::age($patient->birthday);
                              ?>
                                <td class="<?php echo e($stats); ?>"><?php echo e($loop->index + 1); ?></td>
                                <td><?php echo e($patient->patient); ?></td>
                                <td>
                                    <?php echo ( $age >= 60)? '<strong style="color:red">'.$age.'</strong>' : $age; ?>

                                </td>
                                <td>
                                    <a href="<?php echo e(url('radiology/'.$patient->patients_id)); ?>" class="btn btn-default btn-circle">
                                        <i class="fa fa-user-o"></i>
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-circle"
                                            onclick="medicalRecords(<?php echo e($patient->patients_id); ?>)" title="View medical record's">
                                        <i class="fa fa-file-text-o"></i>
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                            data-toggle="modal" data-target="#radiologyModal"
                                            onclick="manageRequest(<?php echo e($patient->patients_id); ?>)">
                                        <i class="fa fa-cog fa-spin"></i> Result
                                    </button>
                                </td>
                                <td>
                                    <?php if($patient->queue_status == 'F'): ?>
                                        <a href="<?php echo e(url('markedDone/'.$patient->id.'/D')); ?>"
                                           class="btn btn-circle btn-success"
                                           data-toggle="tooltip" data-placement="top" title="Click to marked as finished?">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo e(url('markedDone/'.$patient->id.'/F')); ?>"
                                           class="btn btn-circle btn-danger <?php echo e(($patient->queue_status == 'D')? 'disabled' : ''); ?>"
                                           data-toggle="tooltip" data-placement="top" title="Revert this patient?">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e(Carbon::parse($patient->created_at)->format('M d, h:i:s a')); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <ul class="nav nav-pills">
                                <li><a href="#" class="finishedTabActive">Waiting for Result <span class="badge"><?php echo e($waiting); ?></span></a></li>
                                <li><a href="#" class="servingTabActive">Posted Result <span class="badge"><?php echo e($posted); ?></span></a></li>
                                <li><a href="#" class="totalTabActive">Total <span class="badge"><?php echo e($waiting + $posted); ?></span></a></li>
                            </ul>
                        </tr>
                        <hr>
                    </tfoot>

                </table>

            </div>


            <?php else: ?>
                <tr>
                    <?php if($starting): ?>

                        <h4 class="text-center text-danger">No Results Found <i class="fa fa-exclamation"></i></h4>
                        <hr>
                    <?php else: ?>
                            <h4 class="text-center text-danger">Please select a date to be retrieve <i class="fa fa-calendar"></i></h4>
                        <hr>
                    <?php endif; ?>
                </tr>
            <?php endif; ?>


        </div>
    </div>

<?php $__env->stopSection(); ?>





<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>

    <script src="<?php echo e(asset('public/js/doctors/ajaxRecords.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/receptions/consultation.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/master.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/medsWatch.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/ultrasound.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/radiologyQuickView.js')); ?>"></script>


    <script src="<?php echo e(asset('public/js/radiology/manage.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/radiology/quickView.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/results/master.js')); ?>"></script>


    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd',
            });
        });
    </script>
    <script>
      $(document).ready(function(){
        $('#historyTable').dataTable();
      });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
