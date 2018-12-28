<div class="modal" id="create_consultation_modal">

    <div class="modal-dialog modal-xl">


        <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 


        <div class="modal-content">
            <div class="modal-header">

                <?php echo $__env->make('OPDMS.doctors.queue.consultation_header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            </div>

            <div class="modal-body">
                <div id="create_consultation_wrapper">
                    <form action="<?php echo e(url('consultation_save')); ?>" id="create_consultation_form">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="patient_id" v-bind:value="pid"/> 
                        
                        <input type="hidden" name="consultation_patch" v-bind:value="consultation_open_patch"/>
                        <textarea name="consultation" id="create_consultation_editor" rows="30"></textarea>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default pull-left close_create_consultation">Close</button>
                <small class="text-muted">
                    This is where you create or edit the consultation of this patient.
                </small>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>