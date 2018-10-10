

<?php

//color coding of patient status

//$pending_status = ($status == 'P')? 'bg-orange' : 'btn-default';
//$paused_status = ($status == 'H')? 'bg-brown' : 'btn-default';
//$canceled_status = ($status == 'C')? 'bg-red' : 'btn-default';
//$serving_status = ($status == 'S')? 'bg-green' : 'btn-default';
//$finished_status = ($status == 'F')? 'bg-blue' : 'btn-default';
//$all_status = ($status == 'A')? 'bg-black' : 'btn-default';
//$unassigned_status = ($status)? 'btn-default' : 'bg-purple';



        /* queue count show total on button of status */
$queue_count_sum = 0;
foreach ($queue_count as $row){
    $queue_count_sum += $row->total;
    if(!$row->status){ $unassigned_total = $row->total; }
    if($row->status == 'P'){ $pending_total = $row->total; }
    if($row->status == 'H'){ $paused_total = $row->total; }
    if($row->status == 'C'){ $nawc_total = $row->total; }
    if($row->status == 'S'){ $serving_total = $row->total; }
    if($row->status == 'F'){ $finished_total = $row->total; }
}

?>


<div class="box-header with-border">
    <a href="<?php echo e(url('patient_queue')); ?>" class="btn btn-flat bg-purple"
       onclick="full_window_loader()">
        Unassigned
        <span class="badge bg-gray">
            <?php echo e(isset($unassigned_total) ? $unassigned_total : 0); ?>

        </span>
    </a>
    <a href="<?php echo e(url('patient_queue/P')); ?>" class="btn btn-flat bg-orange"
       onclick="full_window_loader()">
        Pending
        <span class="badge bg-gray">
            <?php echo e(isset($pending_total) ? $pending_total : 0); ?>

        </span>
    </a>
    <a href="<?php echo e(url('patient_queue/H')); ?>" class="btn btn-flat bg-brown"
       onclick="full_window_loader()">
        Paused
        <span class="badge bg-gray">
            <?php echo e(isset($paused_total) ? $paused_total : 0); ?>

        </span>
    </a>
    <a href="<?php echo e(url('patient_queue/C')); ?>" class="btn btn-flat bg-red"
       data-toggle="tooltip" title="Not Around When Called"
       onclick="full_window_loader()">
        NAWC
        <span class="badge bg-gray">
            <?php echo e(isset($nawc_total) ? $nawc_total : 0); ?>

        </span>
    </a>
    <a href="<?php echo e(url('patient_queue/S')); ?>" class="btn btn-flat bg-green"
       onclick="full_window_loader()">
        Serving
        <span class="badge bg-gray">
            <?php echo e(isset($serving_total) ? $serving_total : 0); ?>

        </span>
    </a>
    <a href="<?php echo e(url('patient_queue/F')); ?>" class="btn btn-flat bg-blue"
       onclick="full_window_loader()">
        Finished
        <span class="badge bg-gray">
            <?php echo e(isset($finished_total) ? $finished_total : 0); ?>

        </span>
    </a>
    <a href="<?php echo e(url('patient_queue/A')); ?>" class="btn btn-flat bg-black"
       data-toggle="tooltip" title="Show all queued patients"
       onclick="full_window_loader()">
        All
        <span class="badge bg-gray">
            <?php echo e($queue_count_sum); ?>

        </span>
    </a>
</div>