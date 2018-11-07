<div class="box-header with-border">

    <div class="col-md-3">
        <h3 style="margin: 5px 0 0 0 " class="text-blue"><?php echo e($clinic->name); ?></h3>
    </div>
    <div class="col-md-9 text-right">
        <form action="<?php echo e(url('demographicSummary')); ?>" method="post" class="form-inline" style="display: inline">
            <?php echo e(csrf_field()); ?>

            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                <input type="text" required name="starting" class="form-control datepicker1" required placeholder="Starting date">
            </div>
            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                <input type="text" required name="ending" class="form-control datepicker1" required placeholder="Ending date">
            </div>
            <div class="form-group">
                <button class="btn btn-success btn-flat" type="submit">Submit</button>
            </div>
        </form>
    </div>


</div>