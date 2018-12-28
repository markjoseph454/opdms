<div class="box-header with-border">
    <div class="row">
        <div class="col-md-3">
            <h3 style="margin: 5px 0 0 0 " class="text-blue"><?php echo e($clinic->name); ?></h3>
        </div>
        <div class="col-md-9 text-right">
            <form action="<?php echo e(url('demographic')); ?>" method="post" class="form-inline" style="display: inline" onsubmit="full_loader()">
                <?php echo e(csrf_field()); ?>

                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                    <input type="text" required name="starting" class="form-control datepicker1"
                           required placeholder="Starting date" value="<?php echo e($starting); ?>">
                </div>

                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                    <input type="text" required name="ending" class="form-control datepicker1"
                           required placeholder="Ending date" value="<?php echo e($ending); ?>">
                </div>
                <div class="form-group">
                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-filter"></i>
                                    </span>
                        <select name="category" id="" class="form-control">
                            <option value="All">Show All</option>
                            <option value="New">New Patient</option>
                            <option value="Old">Old Patient</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-success btn-flat" type="submit">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>