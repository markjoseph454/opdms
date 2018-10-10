<ul class="nav nav-tabs">



    <?php if(Request::is('addTemplate')): ?>
        <li class="active">
            <a data-toggle="tab" href="#addResultWrapper">
                Add Template <i class="fa fa-file-text-o"></i>
            </a>
        </li>
    <?php else: ?>
        <li class="active">
            <a data-toggle="tab" href="#addResultWrapper">
                Edit Template <i class="fa fa-file-text-o"></i>
            </a>
        </li>
    <?php endif; ?>


    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            Ultrasound
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <?php $__currentLoopData = $ultrasound; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e(url('editTemplate/'.$row->id)); ?>">
                    <?php echo e($row->description); ?>

                </a>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </li>



    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            X-Ray
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <?php $__currentLoopData = $xray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e(url('editTemplate/'.$row->id)); ?>">
                        <?php echo e($row->description); ?>

                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </li>



    <?php if(Request::is('radiology/*/edit')): ?>
        <li>
            <a href="<?php echo e(url('radiologyPrint/'.$radiology->id)); ?>" target="_blank">
                Print <i class="fa fa-print"></i>
            </a>
        </li>
    <?php endif; ?>



</ul>