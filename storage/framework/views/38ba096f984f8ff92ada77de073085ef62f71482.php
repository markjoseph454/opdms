<?php $__env->startComponent('OPDMS.partials.header'); ?>


    <?php $__env->slot('title'); ?>
        Search Patients
    <?php $__env->endSlot(); ?>


<?php $__env->startSection('pagestyle'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_queue.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/partials/patient_information.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_assignation.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/notification.css')); ?>" />
<?php $__env->stopSection(); ?>




<?php $__env->startSection('vue-container-start'); ?>
    <div id="vue-queue">
    <?php $__env->stopSection(); ?>





    <?php $__env->startSection('navigation'); ?>
        <?php echo $__env->make('OPDMS.partials.boilerplate.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>


    <?php $__env->startSection('dashboard'); ?>
        <?php $__env->startComponent('OPDMS.partials.boilerplate.dashboard'); ?>
            <?php $__env->startSection('search_form'); ?>
                <?php echo $__env->make('OPDMS.reception.partials.search_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>



        

            <?php echo $__env->make('OPDMS.partials.modals.modal_container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

        



        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            <?php echo $__env->make('OPDMS.partials.boilerplate.header',
            ['header' => 'Search Patients', 'sub' => 'Showing all matching patients found with your search query.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">

                        <div class="box-body">

                            
                            <div class="table-responsive selectable_table" id="queue_table">
                                <table class="table table-bordered table-striped table-hover" id="dataTable2">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>No#</th>
                                        <th>Hospital_No.</th>
                                        <th>QR Code</th>
                                        <th>Patient Name</th>
                                        <th>Birthday</th>
                                        <th>Age</th>
                                        <th>Address</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!$patients->isEmpty()): ?>
                                        <?php $loop_count = $patients->perPage() * ($patients->currentPage() - 1) + 1; ?>
                                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr v-on:click.prevent="patient_check($event, <?php echo e($patient->id); ?>)">
                                                <td class="selected_icon">
                                                    <i class="fa fa-circle-o fa-lg text-muted"></i>
                                                </td>
                                                <td><?php echo e($loop_count++); ?></td>


                                                

                                                

                                                <td><?php echo e($patient->hospital_no); ?></td>
                                                <td><?php echo e($patient->barcode); ?></td>
                                                <td>
                                                    
                                                    <strong class="text-primary text-uppercase">
                                                        <?php echo e($patient->last_name.', '.$patient->first_name.' '.
                                                    $patient->suffix.' '.$patient->middle_name); ?>

                                                    </strong>
                                                </td>
                                                <td><?php echo e(Carbon::parse($patient->birthday)->toFormattedDateString()); ?></td>
                                                <td>
                                                    
                                                    <?php $age = App\Patient::age($patient->birthday) ?>
                                                    <?php if($age >= 60): ?>
                                                        <strong class="text-red">
                                                            <?php echo e($age); ?>

                                                        </strong>
                                                    <?php else: ?>
                                                        <?php echo e($age); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($patient->address); ?></td>




                                                
                                                



                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="8" class="text-center">
                                            <?php echo e($patients->links()); ?>

                                        </th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing all matching patients found with your search query.
                                </em>
                            </small>
                        </div>

                    </div>



                </section>
                <!-- /.content -->

            </div>
            <!-- /.content-wrapper -->
        <?php $__env->stopSection(); ?>



        <?php $__env->startSection('footer'); ?>
            <?php echo $__env->make('OPDMS.partials.boilerplate.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php $__env->stopSection(); ?>



        <?php $__env->startSection('aside'); ?>
            <?php echo $__env->make('OPDMS.partials.boilerplate.aside', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php $__env->stopSection(); ?>



        
        <?php $__env->startSection('vue-container-end'); ?>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('pluginscript'); ?>
    <script src="<?php echo e(asset('public/plugins/js/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/preventDelete.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('pagescript'); ?>
    <script src="<?php echo e(asset('public/OPDMS/vue/reception/queue.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/reception/notification.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/partials/texteditor.js')); ?>"></script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>