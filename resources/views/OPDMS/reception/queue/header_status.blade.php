{{-- patient status goes here --}}

<?php

//color coding of patient status

$pending_status = ($status == 'P')? 'bg-orange' : 'bg-outline bg-outline-orange';
$paused_status = ($status == 'H')? 'bg-brown' : 'bg-outline bg-outline-brown';
$canceled_status = ($status == 'C')? 'bg-red' : 'bg-outline bg-outline-red';
$serving_status = ($status == 'S')? 'bg-green' : 'bg-outline bg-outline-green';
$finished_status = ($status == 'F')? 'bg-blue' : 'bg-outline bg-outline-blue';
$all_status = ($status == 'A')? 'bg-black' : 'bg-outline bg-outline-black';
$unassigned_status = ($status)? 'bg-outline bg-outline-purple' : 'bg-purple';



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


<div class="box-header with-border row">

    <div class="col-md-9">
        <a href="{{ url('patient_queue') }}" class="btn btn-flat {{ $unassigned_status }}"
           onclick="full_window_loader()">
            Unassigned
            <span class="badge bg-gray">
            {{ $unassigned_total or 0 }}
        </span>
        </a>
        <a href="{{ url('patient_queue/P') }}" class="btn btn-flat {{ $pending_status }}"
           onclick="full_window_loader()">
            Pending
            <span class="badge bg-gray">
            {{ $pending_total or 0 }}
        </span>
        </a>
        <a href="{{ url('patient_queue/H') }}" class="btn btn-flat {{ $paused_status }}"
           onclick="full_window_loader()">
            Paused
            <span class="badge bg-gray">
            {{ $paused_total or 0 }}
        </span>
        </a>
        <a href="{{ url('patient_queue/C') }}" class="btn btn-flat {{ $canceled_status }}"
           data-toggle="tooltip" title="Not Around When Called"
           onclick="full_window_loader()">
            NAWC
            <span class="badge bg-gray">
            {{ $nawc_total or 0 }}
        </span>
        </a>
        <a href="{{ url('patient_queue/S') }}" class="btn btn-flat {{ $serving_status }}"
           onclick="full_window_loader()">
            Serving
            <span class="badge bg-gray">
            {{ $serving_total or 0 }}
        </span>
        </a>
        <a href="{{ url('patient_queue/F') }}" class="btn btn-flat {{ $finished_status }}"
           onclick="full_window_loader()">
            Finished
            <span class="badge bg-gray">
            {{ $finished_total or 0 }}

        </span>
        </a>
        <a href="{{ url('patient_queue/A') }}" class="btn btn-flat {{ $all_status }}"
           data-toggle="tooltip" title="Show all queued patients"
           onclick="full_window_loader()">
            All
            <span class="badge bg-gray">
            {{ $queue_count_sum }}
        </span>
        </a>
    </div>

    <div class="col-md-3">
        <form action="{{ url('search_queued_patients') }}" method="get" class="" style="margin: 0">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search queued patients..."
                       required onkeyup="filter_result($(this), 'reception_queue_table')" />
                <span class="input-group-btn">
                    <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>

</div>