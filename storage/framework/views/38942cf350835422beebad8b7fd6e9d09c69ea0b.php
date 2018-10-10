<div class="col-md-4 doctorsMainWrapper">
    <h2 class="text-center">DOCTORS</h2>
    <br>
    <div class="table-responsive">
        <table class="table" id="doctorsTable">
            <thead>
            <tr>
                <th>DOCTORS</th>
                <th data-placement="top" data-toggle="tooltip" title="Serving Patients">SERV</th>
                <th data-placement="top" data-toggle="tooltip" title="Pending Patients">PEND</th>
                <th data-placement="top" data-toggle="tooltip" title="Canceled Patients">NAWC</th>
                <th data-placement="top" data-toggle="tooltip" title="Finished Patients">FIN</th>
                <th data-placement="top" data-toggle="tooltip" title="Paused Patients">PAUSED</th>
            </tr>
            </thead>
            <tbody>
            <?php if(count($doctors) > 0): ?>
                <?php
                    $badgeServe = 0;
                    $badgePaused = 0;
                    $badgeFinished = 0;
                    $badgeUnassigned = 0;
                    $badgeCancel = 0;
                    $badgePending = 0;
                    $badgeTotal = 0;
                    $activeDoctor = false;
                ?>
                <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        if ($doctor->serving){
                            $badgeServe += $doctor->serving;
                        }
                        if ($doctor->pending){
                            $badgePending += $doctor->pending;
                        }
                        if ($doctor->pending){
                            $badgePending += $doctor->pending;
                        }
                        if ($doctor->pending){
                            $badgePending += $doctor->pending;
                        }
                        if ($doctor->pending){
                            $badgePending += $doctor->pending;
                        }
                        if ($doctor->pending){
                            $badgePending += $doctor->pending;
                        }
                        if ($doctor->pending){
                            $badgePending += $doctor->pending;
                        }
                    ?>




                    <?php if(App\User::isActive($doctor->id) || $doctor->serving
                    || $doctor->pending || $doctor->finished || $doctor->paused || $doctor->cancel): ?>
                    <?php
                        $activeDoctor = true;
                    ?>
                    <tr>
                        <td>
                             <?php if(App\User::isActive($doctor->id)): ?>
                                <?php echo "<div class='online'></div> <span class='text-uppercase'>Dr. $doctor->name</span>"; ?>

                            <?php else: ?>
                                <?php echo "<div class='offline'></div> <span class='text-uppercase'>Dr. $doctor->name</span>"; ?>

                            <?php endif; ?>
                        </td>
                        <td>
                            <a href='<?php echo e(url("status/$doctor->id/S")); ?>'
                               class="btn btn-circle <?php echo e(($doctor->serving)? 'btn-success' : 'btn-default'); ?>">
                                <?php echo e(($doctor->serving)? $doctor->serving : '0'); ?>

                            </a>
                        </td>
                        <td>
                            <a href='<?php echo e(url("status/$doctor->id/P")); ?>'
                               class="btn btn-circle <?php echo e(($doctor->pending)? 'btn-warning' : 'btn-default'); ?>">
                                <?php echo e(($doctor->pending)? $doctor->pending : '0'); ?>

                            </a>
                        </td>
                        <td>
                            <a href='<?php echo e(url("status/$doctor->id/C")); ?>'
                               class="btn btn-circle <?php echo e(($doctor->cancel)? 'btn-danger' : 'btn-default'); ?>">
                                <?php echo e(($doctor->cancel)? $doctor->cancel : '0'); ?>

                            </a>
                        </td>
                        <td>
                            <a href='<?php echo e(url("status/$doctor->id/F")); ?>'
                               class="btn btn-circle <?php echo e(($doctor->finished)? 'btn-info' : 'btn-default'); ?>">
                                <?php echo e(($doctor->finished)? $doctor->finished : '0'); ?>

                            </a>
                        </td>
                        <td>
                            <a href='<?php echo e(url("status/$doctor->id/H")); ?>'
                               class="btn btn-circle <?php echo e(($doctor->paused)? '' : 'btn-default'); ?>" <?php echo ($doctor->paused)? 'style="background-color:saddlebrown;color:#fff"' : ''; ?>>
                                <?php echo e(($doctor->paused)? $doctor->paused : '0'); ?>

                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if(!$activeDoctor): ?>
                <tr>
                    <td colspan="6">
                        <div class="well text-danger text-center">
                            <strong>No Active Doctors <i class="fa fa-stethoscope"></i></strong>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>

            <?php else: ?>
                <tr class="text-danger text-center">
                    <td colspan="5">
                        NO DOCTORS FOUND <i class="fa fa-exclamation"></i>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>