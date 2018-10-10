<table style="width: 265px;padding-bottom: 30px;">
    <tbody>
        <?php $__currentLoopData = $print; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td width="130px"><?php echo e($list->item_description.'('.$list->brand.')'); ?></td>
                <td width="70px"><?php echo e($list->unitofmeasure); ?></td>
                <td width="70px">QTY: <?php echo e($list->qty); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>