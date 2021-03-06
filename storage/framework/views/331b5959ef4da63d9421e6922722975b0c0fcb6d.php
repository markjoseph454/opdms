<?php $__env->startComponent('OPDMS.partials.header'); ?>


    <?php $__env->slot('title'); ?>
        Queue History
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
                <?php echo $__env->make('OPDMS.partials.boilerplate.search_form', ['redirector' => 'admin.search'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>



        

            <?php echo $__env->make('OPDMS.partials.modals.modal_container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

        


        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            <?php echo $__env->make('OPDMS.partials.boilerplate.header',
            ['header' => 'Queue History', 'sub' => 'Showing all patients that has been queued on a particular date.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">


                        <?php echo $__env->make('OPDMS.reception.queue_history.search_box', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 


                        <div class="box-body">

                            <?php echo $__env->make('OPDMS.reception.queue_history.header_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

                            
                            <div class="table-responsive selectable_table" id="queue_table">
                                <table class="table table-bordered table-striped table-hover" id="dataTable2">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>No#</th>
                                        
                                        <th>Patient Name</th>
                                        <th>Age</th>
                                        <th>Assigned to Doctor</th>
                                        <th>Status</th>
                                        
                                        <th>Time Queued</th>
                                        <th>Time Assigned</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!$queues->isEmpty()): ?>
                                        <?php $loop_count = $queues->perPage() * ($queues->currentPage() - 1) + 1; ?>
                                        <?php $__currentLoopData = $queues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr v-on:click.prevent="patient_check($event, <?php echo e($queue->pid); ?>)">
                                                <td class="selected_icon">
                                                    <i class="fa fa-circle-o fa-lg text-muted"></i>
                                                </td>
                                                <td><?php echo e($loop_count++); ?></td>


                                                

                                                



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
                                                    
                                                    <?php if($queue->doctors_id): ?>
                                                        <strong class="text-primary text-uppercase">
                                                            DR. <?php echo e($queue->dr_last_name.', '.$queue->dr_first_name.' '.
                                                    $queue->dr_middle_name); ?>

                                                        </strong>
                                                    <?php else: ?>
                                                        <strong class="text-muted">
                                                            None
                                                        </strong>
                                                    <?php endif; ?>

                                                </td>


                                                
                                                <?php echo $__env->make('OPDMS.reception.queue.queue_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                                                
                                                



                                                <td>
                                                    <?php echo e(Carbon::parse($queue->queue_time)->format('M d, Y h:i a')); ?>

                                                    <br>
                                                    <small class="text-muted">
                                                        <?php echo e(Carbon::parse($queue->queue_time)->diffForHumans()); ?>

                                                    </small>
                                                </td>
                                                <td>
                                                    <?php if($queue->assigned_uptime): ?>
                                                        <?php echo e(Carbon::parse($queue->assigned_uptime)->format('M d, Y h:i a')); ?>

                                                        <br>
                                                        <small class="text-muted">
                                                            <?php echo e(Carbon::parse($queue->assigned_uptime)->diffForHumans()); ?>

                                                        </small>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    </tbody>

                                    <?php if(!$queues->isEmpty()): ?>
                                        <tfoot>
                                        <tr>
                                            <th colspan="7" class="text-center">
                                                <?php echo e($queues->links()); ?>

                                            </th>
                                        </tr>
                                        </tfoot>
                                    <?php endif; ?>
                                </table>
                            </div>

                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing todays queued patients.
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
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>


    <script>
        // $('#datemask2').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
        $('[data-mask]').inputmask()
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>