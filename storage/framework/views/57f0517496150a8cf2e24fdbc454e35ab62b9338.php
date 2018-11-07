<div class="box-header with-border">

    <div class="row">
        <div class="col-md-3">
            <h3 style="margin: 0" class="text-blue"><?php echo e($clinic->name); ?></h3>
        </div>
        <div class="col-md-9 text-right">
            <form action="<?php echo e(url('receptionCensus')); ?>" class="form-inline" method="post" onsubmit="full_loader()">
                <?php echo e(csrf_field()); ?>



                <div class="form-group <?php if($errors->has('startingDate')): ?> has-error <?php endif; ?>">
                    <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-filter"></i>
                                </span>
                        <select name="filter" id="" class="form-control">
                            <option value="5000" <?php echo e(($limit == 5000)? 'selected' : ''); ?>>Show All</option>
                            <option value="10" <?php echo e(($limit == 10)? 'selected' : ''); ?>>Top 10 Diseases</option>
                            <option value="20" <?php echo e(($limit == 20)? 'selected' : ''); ?>>Top 20 Diseases</option>
                            <option value="50" <?php echo e(($limit == 50)? 'selected' : ''); ?>>Top 50 Diseases</option>
                        </select>
                    </div>
                </div>



                

                


                &nbsp;



                <div class="form-group <?php if($errors->has('startingDate')): ?> has-error <?php endif; ?>">
                    <div class="input-group">
                                <span class="input-group-addon" onclick="document.getElementById('starting').focus()">
                                    <i class="fa fa-calendar"></i>
                                </span>
                        <input type="text" name="startingDate" value="<?php echo e(isset($starting) ? $starting : ''); ?>"
                               id="starting" placeholder="Enter Starting Date" class="form-control datepicker1" />
                    </div>
                    <?php if($errors->has('startingDate')): ?>
                        <span class="help-block">
                                     <strong class=""><?php echo e($errors->first('startingDate')); ?></strong>
                                 </span>
                    <?php endif; ?>
                </div>



                

                


                &nbsp;




                <div class="form-group <?php if($errors->has('endingDate')): ?> has-error <?php endif; ?>">
                    <div class="input-group">
                                <span class="input-group-addon" onclick="document.getElementById('endingDate').focus()">
                                    <i class="fa fa-calendar"></i>
                                </span>
                        <input type="text" id="endingDate" value="<?php echo e(isset($ending) ? $ending : ''); ?>" name="endingDate"
                               placeholder="Enter Ending Date" class="form-control datepicker1" />
                    </div>
                    <?php if($errors->has('endingDate')): ?>
                        <span class="help-block">
                                     <strong class=""><?php echo e($errors->first('endingDate')); ?></strong>
                                 </span>
                    <?php endif; ?>
                </div>



                &nbsp;




                <div class="form-group">
                    <button type="submit" class="btn btn-flat btn-success">Submit</button>
                </div>



            </form>
        </div>
    </div>

</div>