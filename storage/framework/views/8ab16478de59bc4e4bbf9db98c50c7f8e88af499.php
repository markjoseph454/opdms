<div class="box-header with-border">
    <form action="<?php echo e(url('queued_history')); ?>" class="form-inline" method="post">
        <?php echo e(csrf_field()); ?>

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
        <div class="form-group">
            <select name="status" class="form-control select2">
                <option value="A" <?php if($status == 'A'): ?> selected <?php endif; ?>>All</option>
                <option value="F" <?php if($status == 'F'): ?> selected <?php endif; ?>>Finished</option>
                <option value="S" <?php if($status == 'S'): ?> selected <?php endif; ?>>Serving</option>
                <option value="P" <?php if($status == 'P'): ?> selected <?php endif; ?>>Pending</option>
                <option value="H" <?php if($status == 'H'): ?> selected <?php endif; ?>>Paused</option>
                <option value="C" <?php if($status == 'C'): ?> selected <?php endif; ?>>NAWC</option>
                <option value="U" <?php if($status == 'U'): ?> selected <?php endif; ?>>Unassigned</option>
            </select>
        </div>
        <div class="form-group">
            <select name="doctor_id" class="form-control select2">
                <option value="">SHOW ALL</option>
                <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($doctor->id); ?>" <?php if($doctor_id == $doctor->id): ?> selected <?php endif; ?>>
                        <?php echo e($doctor->last_name.', '.$doctor->first_name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-flat bg-green" onclick="full_window_loader()">
                Submit
            </button>
        </div>
    </form>
</div>