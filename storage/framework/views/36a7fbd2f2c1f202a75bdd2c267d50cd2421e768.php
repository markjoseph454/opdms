<?php $__env->startComponent('OPDMS.partials.header'); ?>


    <?php $__env->slot('title'); ?>
        Charged Patients
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



        

        <?php echo $__env->make('OPDMS.reception.modals.patient_assignation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
        <?php echo $__env->make('OPDMS.reception.modals.patient_re_assignation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
        <?php echo $__env->make('OPDMS.partials.modals.medical_records', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
        <?php echo $__env->make('OPDMS.partials.modals.consultation_show', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
        <?php echo $__env->make('OPDMS.partials.modals.nurse_notes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
        
        <?php echo $__env->make('OPDMS.partials.modals.patient_notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('OPDMS.partials.modals.patient_information', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
        <?php echo $__env->make('OPDMS.partials.modals.vital_signs_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 



        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            <?php echo $__env->make('OPDMS.partials.boilerplate.header',
            ['header' => 'Charged Patients', 'sub' => 'Showing all patients that has been charged.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        <div class="box-header with-border">
                            <form action="<?php echo e(url('charged_patients')); ?>" method="get" class="form-inline">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="start" class="form-control datepicker1" placeholder="Starting Date"
                                           data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="<?php echo e($start); ?>" />
                                </div>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="end" class="form-control datepicker1" placeholder="Ending Date"
                                           data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="<?php echo e($end); ?>" />
                                </div>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </div>
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Enter Patient Name"/>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-flat bg-green" onclick="full_window_loader()">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="box-body">


                            
                            <div class="table-responsive selectable_table" id="queue_table">
                                <table class="table table-bordered table-striped table-hover" id="dataTable2">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>No#</th>
                                        <th>Patient Name</th>
                                        <th>Age</th>
                                        
                                        <th>Date Requested</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($queues): ?>
                                        <?php $__currentLoopData = $queues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr v-on:click.prevent="patient_check($event, <?php echo e($queue->pid); ?>)">
                                                <td class="selected_icon">
                                                    <i class="fa fa-circle-o fa-lg text-muted"></i>
                                                </td>
                                                <td><?php echo e($loop->index + 1); ?></td>

                                                <td>
                                                    
                                                    <strong class="text-primary text-uppercase">
                                                        <?php echo e($queue->last_name.', '.$queue->first_name.' '.
                                                    $queue->suffix.' '.$queue->middle_name); ?>

                                                    </strong>
                                                </td>
                                                <td>
                                                    
                                                    <?php $age = App\Patient::age($queue->birthday) ?>
                                                    <?php if($age >= 60): ?>
                                                        <strong class="text-red">
                                                            <?php echo e($age); ?>

                                                        </strong>
                                                    <?php else: ?>
                                                        <?php echo e($age); ?>

                                                    <?php endif; ?>
                                                </td>
                                                
                                                <td>
                                                    <?php echo e(Carbon::parse($queue->created_at)->format('M d, Y h:i a')); ?>

                                                    <br>
                                                    <small class="text-muted">
                                                        <?php echo e(Carbon::parse($queue->created_at)->diffForHumans()); ?>

                                                    </small>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                </table>
                            </div>

                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing all patients that has been charged.
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
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js')); ?>"></script>
    <script src="<?php echo e(asset('public/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('pagescript'); ?>
    <script src="<?php echo e(asset('public/OPDMS/vue/reception/queue.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/reception/notification.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/partials/texteditor.js')); ?>"></script>
    <script>
        $('[data-mask]').inputmask()
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>