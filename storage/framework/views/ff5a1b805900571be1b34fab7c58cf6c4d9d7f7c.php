<?php if(in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>

    <td>

        <?php if($patient->queue_status == 'F'): ?>



                <a href="<?php echo e(url('queueStatus/'.$patient->qid.'/P')); ?>"
                   data-placement="top" data-toggle="tooltip" title="Click to revert"
                   class="btn btn-warning btn-circle" data-toggle=""
                   onclick="return confirm('Do you really want to revert this patient?')">
                    <i class="fa fa-refresh"></i>
                </a>

        <?php else: ?>
            <?php $done = 'disabled' ?>
            <?php $__currentLoopData = $charging; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $done = ($row->paid <= 0 || $patient->queue_status == 'D')? 'disabled' : '';
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                <a href="<?php echo e(url('queueStatus/'.$patient->qid.'/F')); ?>"
                   data-placement="top" data-toggle="tooltip" title="Click to mark as done"
                   class="btn btn-circle <?php echo e($done); ?> <?php echo e(($done != 'disabled')? 'btn-primary' : 'btn-default'); ?>"
                   onclick="return confirm('Do you really want to marked this patient as done?')">
                    <i class="fa fa-check"></i>
                </a>


        <?php endif; ?>

    </td>

<?php endif; ?>