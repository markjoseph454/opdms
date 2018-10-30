<?php 
  use App\Patient;
?>
<?php $__env->startComponent('OPDMS.partials.header'); ?>


<?php $__env->slot('title'); ?>
    MEDICAL RECORDS
<?php $__env->endSlot(); ?>


<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/OPDMS/css/patients/main.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/action.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/check_patient.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/result_patient.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/print_patient.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/edit_patient.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/remove.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/OPDMS/css/patients/patient_information.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('navigation'); ?>
    <?php echo $__env->make('OPDMS.partials.boilerplate.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('dashboard'); ?>
    <?php $__env->startComponent('OPDMS.partials.boilerplate.dashboard'); ?>
        
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="main-page">

        <?php echo $__env->make('OPDMS.partials.boilerplate.header',
        ['header' => 'Patients List', 'sub' => 'All patients that was been registered will be shown here.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- Main content -->
        <section class="content">

            <div class="box">
                <?php echo $__env->make('OPDMS.patients.action', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="box-body">
                    <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="table table-striped table-hover" id="patient-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><span class="fa fa-user-o"></span></th>
                                    <th>ID No</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Suffix</th>
                                    <th>Gender</th>
                                    <th>Birthdate</th>
                                    <th>Address</th>
                                    <th>Reg.Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-id="<?php echo e($list->id); ?>" <?php if($list->fordelete): ?> status="remove" <?php endif; ?>>
                                    <td><span class="fa fa-caret-right"></span></td>
                                    <td class=""><span class="fa fa-user-o <?php if($list->fordelete): ?> text-red <?php endif; ?>"></span></td>
                                    <td><?php echo e($list->hospital_no); ?></td>
                                    <td class="last_name"><?php echo e($list->last_name); ?></td>
                                    <td class="first_name"><?php echo e($list->first_name); ?></td>
                                    <td class="middle_name"><?php echo e($list->middle_name); ?></td>
                                    <td class="suffix"><?php echo e($list->suffix); ?></td>
                                    <td class="sex"><?php echo e(($list->sex == "M")?'Male':'Female'); ?></td>
                                    <td class="birthday"><?php if($list->birthday): ?> <?php echo e(Carbon::parse($list->birthday)->format('m/d/Y')); ?> <?php endif; ?></td>
                                    <td class="address"><?php echo e($list->brgyDesc.' '.$list->citymunDesc.', '.$list->provDesc); ?></td>
                                    <td><?php echo e(Carbon::parse($list->regdate)->format('m/d/Y')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="box-footer">
                    <small>
                        <em class="text-muted">
                              <?php if(count($request->post()) > 0): ?>
                                Showing <b> <?php echo e(count($data)); ?> </b> search result(s).
                              <?php else: ?>  
                                Showing <b> <?php echo e(count($data)); ?> </b> of <?php echo e(count(Patient::whereDate('created_at', '=', Carbon::today())->get())); ?> registered patient(s) today.
                              <?php endif; ?>
                            <!-- Carbon::today() -->
                        </em>
                    </small>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>

    <?php echo $__env->make('OPDMS.patients.modals.check_patient', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.patients.modals.check_result', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.patients.modals.store_patient', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.patients.modals.edit_patient', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.patients.modals.remove', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.patients.modals.address', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.patients.modals.print', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.patients.modals.patient_information', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('OPDMS.patients.modals.medical_records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>





<?php $__env->startSection('aside'); ?>
    <?php echo $__env->make('OPDMS.partials.boilerplate.aside', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('pluginscript'); ?>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pagescript'); ?>
    <script>
        var dateToday = '<?php echo e(Carbon::today()->format("m/d/Y")); ?>';
    </script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/action.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/check_patient.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/result_patient.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/print_patient.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/store_patient.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/edit_patient.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/remove.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/search.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/table.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/roles.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/patient_information.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/patients/medical_record.js')); ?>"></script>

    <script src="<?php echo e(asset('public/OPDMS/js/patients/address.js')); ?>"></script>



   <!--  <script src="<?php echo e(asset('public/AdminLTE/bower_components/select2/dist/js/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/dist/js/adminlte.min.js')); ?>"></script> -->


    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>