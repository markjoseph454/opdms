<?php if(count($errors) > 0): ?>
    <div class="callout callout-danger">
        <strong><i class="icon fa fa-ban"></i> Whoops! looks like something went wrong.</strong>
        <br/>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>