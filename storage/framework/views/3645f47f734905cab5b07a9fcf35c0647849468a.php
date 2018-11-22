<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Classified Patient
    <?php $__env->endSlot(); ?>

    <?php $__env->startSection('pagestyle'); ?>
         <link href="<?php echo e(asset('public/css/partials/navigation.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/css/mss/classified.css')); ?>" rel="stylesheet" />
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('header'); ?>
        <?php echo $__env->make('mss/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>
        <div class="container">
            <!-- <h3 class="text-center" style="font-weight: bold;">CLASSIFIED PATIENT's <i class="fa fa-users"></i><span class="pull-right">
            <?php if(isset($date)): ?>
                <?php echo e($date); ?>

            <?php else: ?>
                <?php echo e(Carbon::today()->toDateString()); ?>

            <?php endif; ?>
            &nbsp;<i class="fa fa-calendar calendar" data-toggle="tooltip" data-placement="left" title="Click to view Another Day"></i></span></h3>

            <br> -->
            <br>
            <div class="data-adjustment">
                <form class="form-inline pull-left" method="GET">
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" placeholder="Patient name.." 
                        value="<?php echo e($request->name); ?>" 
                        >
                        <span class="input-group-addon fa fa-user"></span>
                    </div>
                    <div class="input-group">
                        <input type="text" name="hospital_no" class="form-control" placeholder="Hospital no.." 
                        value="<?php echo e($request->hospital_no); ?>" 
                        >
                        <span class="input-group-addon fa fa-building"></span>
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-sm">Filter</button>
                </form>
                <form class="form-inline text-right" method="GET">
                    <!-- <select class="form-control" name="type">
                        <option value="mss" hidden="" <?php if($request->type == ""): ?> selected <?php endif; ?>>TYPE</option>
                        <option value="mss" <?php if($request->type == "mss"): ?> selected <?php endif; ?>>MSS</option>
                        <option value="malasakit" <?php if($request->type == "malasakit"): ?> selected <?php endif; ?>>MALASAKIT</option>
                        <option value="mss" <?php if($request->type == "all"): ?> selected <?php endif; ?>>ALL</option>
                    </select> -->
                    <div class="input-group">
                        <input type="date" name="from" class="form-control" 
                        <?php if(isset($_GET['from'])): ?> value="<?php echo e($_GET['from']); ?>" <?php endif; ?> 
                         required>
                        <span class="input-group-addon fa fa-calendar"></span>
                    </div>
                    <div class="input-group">
                         <input type="date" name="to" class="form-control" 
                         <?php if(isset($_GET['to'])): ?> value="<?php echo e($_GET['to']); ?>" <?php endif; ?> 
                          required>
                        <span class="input-group-addon fa fa-calendar"></span>
                    </div>
                    
                   
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                </form>
            </div>
            <div class="text-left bg-default">
                <br>
            </div>
            <div>
              <ul class="nav nav-tabs">
                    <?php
                        $total = 0;
                    ?>
                    <?php $__currentLoopData = $tab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li <?php if($request->id == $list->mss_id): ?> class="active" <?php endif; ?>>
                        <a href="classified?id=<?php echo e($list->mss_id); ?>&type=<?php echo e($request->type); ?>&from=<?php echo e($request->from); ?>&to=<?php echo e($request->to); ?>&name=<?php echo e($request->name); ?>&hospital_no=<?php echo e($request->hospital_no); ?>"
                           class="" 
                           data-toggle="tooltip" data-placement="top" title="VIEW ONLY <?php echo e($list->label.' - '.$list->description); ?>">
                            <?php echo e($list->label.' - '.$list->description); ?>

                            <span class="badge"><?php echo e($list->counts); ?></span>
                        </a>
                    </li>
                    <?php
                        $total += $list->counts;
                    ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li <?php if(!$request->id): ?> class="active" <?php endif; ?>>
                        <a href="classified?type=<?php echo e($request->type); ?>&from=<?php echo e($request->from); ?>&to=<?php echo e($request->to); ?>&name=<?php echo e($request->name); ?>&hospital_no=<?php echo e($request->hospital_no); ?>"
                           class="" 
                           data-toggle="tooltip" data-placement="top" title="TOTAL">
                            TOTAL
                            <span class="badge"><?php echo e($total); ?></span>
                        </a>
                    </li>
                  
              </ul>
              <br>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="classifiedTable">
                    <thead>
                        <tr>
                            <th hidden></th>
                            <th>HOSPITAL#</th>
                            <th>PATIENTNAME</th>
                            <th>ADDRESS</th>
                            <th>BIRTHDAY</th>
                            <th>SEX</th>
                            <th>CLASSIFICATION</th>
                            <th>REFERRAL</th>
                            <th>CLASSIFIED BY</th>
                            <th>CLASSIFIED.DATE</th>
                            <th>PRINT</th>
                            <th>EDIT</th>
                            <th>VIEW</th>
                            <!-- <th>MALASAKIT</th> -->
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $classified; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $var): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td hidden></td>
                                <td><?php echo e($var->hospital_no); ?></td>
                                <td><?php echo e($var->last_name.', '.$var->first_name.' '.$var->middle_name); ?></td>
                                <td><?php echo e($var->address); ?></td>
                                <td><?php echo e(Carbon::parse($var->birthday)->format('m/d/Y')); ?></td>
                                <td><?php echo e($var->sex); ?></td>
                                <td><?php echo e($var->mss); ?></td>
                                <td><?php echo e($var->referral); ?></td>
                                <td><?php echo e($var->users); ?></td>
                                <td><?php echo e(Carbon::parse($var->created_at)->format('m/d/Y g:ia')); ?></td>
                                <td><a href="<?php echo e(url('mssform/'.$var->id)); ?>" class="btn btn-primary" target="_blank" data-id="<?php echo e($var->id); ?>"><span class="fa fa-print"></span></a>
                                    
                                </td>
                                <td><a href="<?php echo e(url('mss/'.$var->id.'/edit')); ?>" class="btn btn-success"><i class="fa fa-pencil"></i></a></td>
                                <td><a href="<?php echo e(url('view/'.$var->id)); ?>" class="btn btn-default"><i class="fa fa-eye"></i></a></td>
                                
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="choosedatemodal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <form method="post" action="<?php echo e(url('classifiedbyday')); ?>">
                       <?php echo e(csrf_field()); ?>

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">CHOOSE DATE</h4>
                    </div>
                    <div class="modal-body">
                        <input type="date" name="date" id="choose_date" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">OK</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    <?php $__env->stopSection(); ?>




    <?php $__env->startSection('pagescript'); ?>
        <?php echo $__env->make('message/toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/mss/classified.js')); ?>"></script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
