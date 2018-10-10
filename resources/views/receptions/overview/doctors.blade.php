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
            @if(count($doctors) > 0)
                @php
                    $badgeServe = 0;
                    $badgePaused = 0;
                    $badgeFinished = 0;
                    $badgeUnassigned = 0;
                    $badgeCancel = 0;
                    $badgePending = 0;
                    $badgeTotal = 0;
                    $activeDoctor = false;
                @endphp
                @foreach($doctors as $doctor)
                    @php
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
                    @endphp




                    @if(App\User::isActive($doctor->id) || $doctor->serving
                    || $doctor->pending || $doctor->finished || $doctor->paused || $doctor->cancel)
                    @php
                        $activeDoctor = true;
                    @endphp
                    <tr>
                        <td>
                             @if(App\User::isActive($doctor->id))
                                {!! "<div class='online'></div> <span class='text-uppercase'>Dr. $doctor->name</span>" !!}
                            @else
                                {!! "<div class='offline'></div> <span class='text-uppercase'>Dr. $doctor->name</span>" !!}
                            @endif
                        </td>
                        <td>
                            <a href='{{ url("status/$doctor->id/S") }}'
                               class="btn btn-circle {{ ($doctor->serving)? 'btn-success' : 'btn-default' }}">
                                {{ ($doctor->serving)? $doctor->serving : '0' }}
                            </a>
                        </td>
                        <td>
                            <a href='{{ url("status/$doctor->id/P") }}'
                               class="btn btn-circle {{ ($doctor->pending)? 'btn-warning' : 'btn-default' }}">
                                {{ ($doctor->pending)? $doctor->pending : '0' }}
                            </a>
                        </td>
                        <td>
                            <a href='{{ url("status/$doctor->id/C") }}'
                               class="btn btn-circle {{ ($doctor->cancel)? 'btn-danger' : 'btn-default' }}">
                                {{ ($doctor->cancel)? $doctor->cancel : '0' }}
                            </a>
                        </td>
                        <td>
                            <a href='{{ url("status/$doctor->id/F") }}'
                               class="btn btn-circle {{ ($doctor->finished)? 'btn-info' : 'btn-default' }}">
                                {{ ($doctor->finished)? $doctor->finished : '0' }}
                            </a>
                        </td>
                        <td>
                            <a href='{{ url("status/$doctor->id/H") }}'
                               class="btn btn-circle {{ ($doctor->paused)? '' : 'btn-default' }}" {!! ($doctor->paused)? 'style="background-color:saddlebrown;color:#fff"' : '' !!}>
                                {{ ($doctor->paused)? $doctor->paused : '0' }}
                            </a>
                        </td>
                    </tr>
                    @endif
                @endforeach

                @if(!$activeDoctor)
                <tr>
                    <td colspan="6">
                        <div class="well text-danger text-center">
                            <strong>No Active Doctors <i class="fa fa-stethoscope"></i></strong>
                        </div>
                    </td>
                </tr>
                @endif

            @else
                <tr class="text-danger text-center">
                    <td colspan="5">
                        NO DOCTORS FOUND <i class="fa fa-exclamation"></i>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>