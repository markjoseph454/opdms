<ul class="nav nav-pills">
    <li>
        <a href="<?php echo e(url('overview')); ?>"
           class="unassignedTab <?php echo e(($status == false)? 'unassignedTabActive' : ''); ?>">
            Unassigned <span class="badge"><?php echo e(count($unassigend)); ?></span>
        </a>
    </li>
    <li>
        <a href="<?php echo e(url('overview/P')); ?>"
           class="pendingTab <?php echo e(($status == 'P')? 'pendingTabActive' : ''); ?>">
            Pending <span class="badge"><?php echo e((isset($survey[0]->pending))? $survey[0]->pending : 0); ?></span>
        </a>
    </li>
    <li>
        <a href="<?php echo e(url('overview/H')); ?>"
           class="pausedTab <?php echo e(($status == 'H')? 'pausedTabActive' : ''); ?>">
            Paused <span class="badge"><?php echo e((isset($survey[0]->paused))? $survey[0]->paused : 0); ?></span>
        </a>
    </li>
    <li>
        <a href="<?php echo e(url('overview/C')); ?>"
           class="nawcTab <?php echo e(($status == 'C')? 'nawcTabActive' : ''); ?>">
            NAWC <span class="badge"><?php echo e((isset($survey[0]->nawc))? $survey[0]->nawc : 0); ?></span>
        </a>
    </li>
    <li>
        <a href="<?php echo e(url('overview/S')); ?>"
           class="servingTab <?php echo e(($status == 'S')? 'servingTabActive' : ''); ?>">
            Serving <span class="badge"><?php echo e((isset($survey[0]->serving))? $survey[0]->serving : 0); ?></span>
        </a>
    </li>
    <li>
        <a href="<?php echo e(url('overview/F')); ?>"
           class="finishedTab <?php echo e(($status == 'F')? 'finishedTabActive' : ''); ?>">
            Finished <span class="badge"><?php echo e((isset($survey[0]->finished))? $survey[0]->finished : 0); ?></span>
        </a>
    </li>
    <li>
        <a href="<?php echo e(url('overview/T')); ?>"
           class="totalTab <?php echo e(($status == 'T')? 'totalTabActive' : ''); ?>">
            Total <span class="badge">
                <?php if(isset($survey) && $survey): ?>
                <?php echo e($survey[0]->serving + $survey[0]->pending + $survey[0]->nawc + $survey[0]->finished + $survey[0]->paused + count($unassigend)); ?>

                <?php else: ?>
                    <?php echo e(count($unassigend)); ?>

                <?php endif; ?>
                </span>
        </a>
    </li>
</ul>