<?php

//color coding of patient status

if($queue->status == 'F'){
    $text = 'Finished';
    $status_color = 'bg-blue';
}elseif($queue->status == 'P'){
    $text = 'Pending';
    $status_color = 'bg-orange';
}elseif($queue->status == 'H'){
    $text = 'Paused';
    $status_color = 'bg-brown';
}elseif($queue->status == 'C'){
    $text = 'NAWC';
    $status_color = 'bg-red';
}else{
    $text = 'Serving';
    $status_color = 'bg-green';
}

?>

<td class="<?php echo e($status_color); ?>" id="<?php echo e('assgn_status_'.$queue->pid); ?>"><?php echo e($text); ?></td>
