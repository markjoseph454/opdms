<div class="modal fade" id="vital_signs_modal">

    <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-primary text-uppercase">{{ p_name }}</h4>
                <h4 class="modal-title">Vital Signs <i class="fa fa-heartbeat text-red"></i></h4>
                <p class="small text-muted">
                    Insert todays vital signs of this patient.
                </p>
            </div>

            <div class="modal-body">

                <?php echo $__env->make('message.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <form action="<?php echo e(url('vital_signs')); ?>" method="post" id="vital_signs_form" v-on:submit.prevent="vital_signs_insert($event)">

                    <?php echo e(csrf_field()); ?>


                    <input type="hidden" name="patient_id" v-bind:value="pid" />

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Blood Pressure</label>
                                <div class="input-group">
                                    <input type="text" name="bp" value="<?php echo e(old('bp')); ?>" class="form-control" required>
                                    <span class="input-group-addon">BP</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pulse Rate</label>
                                <div class="input-group">
                                    <input type="text" name="pr" value="<?php echo e(old('pr')); ?>" class="form-control">
                                    <span class="input-group-addon">BPM</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Respiration Rate</label>
                                <div class="input-group">
                                    <input type="text" name="rr" value="<?php echo e(old('rr')); ?>" class="form-control">
                                    <span class="input-group-addon">RM</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Body Temperature</label>
                                <div class="input-group">
                                    <input type="text" name="temp" value="<?php echo e(old('temp')); ?>" class="form-control">
                                    <span class="input-group-addon">°C</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Weight</label>
                                <div class="input-group">
                                    <input type="text" name="wt" value="<?php echo e(old('wt')); ?>" class="form-control">
                                    <span class="input-group-addon">KG.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Height</label>
                                <div class="input-group">
                                    <input type="text" name="ht" value="<?php echo e(old('ht')); ?>" class="form-control">
                                    <span class="input-group-addon">CM.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>
                <button type="submit" form="vital_signs_form" class="btn btn-flat btn-success">Save Vital Signs</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>