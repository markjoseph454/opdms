<form action="<?php echo e(url('weeklyCensus')); ?>" method="post" class="form-inline text-right" role="form">
    <?php echo e(csrf_field()); ?>


    <div class="form-group">
        <div class="input-group">
        <span class="input-group-addon" id="startingDate" onclick="document.getElementById('start').focus()">
            <i class="fa fa-calendar"></i>
        </span>
            <input type="text" name="dateTime" class="form-control datepicker" value="<?php echo e($originalDate); ?>"
                   placeholder="Enter Date" aria-describedby="startingDate" id="start" required />
        </div>
        <?php if($errors->has('dateTime')): ?>
            <span class="help-block">
                <strong class=""><?php echo e($errors->first('dateTime')); ?></strong>
            </span>
        <?php endif; ?>
    </div>

    &nbsp;

    <div class="form-group">
        <button class="btn btn-success">Submit</button>
    </div>

</form>


<br>