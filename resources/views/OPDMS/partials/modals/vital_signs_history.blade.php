<div class="modal fade" id="vital_signs_history_modal">


    <div class="modal-dialog">

        @include('OPDMS.partials.loader') {{-- loader icon --}}


        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-primary text-uppercase">@{{ p_name }}</h4>
                <h4 class="modal-title">Vital Signs History <i class="fa fa-heartbeat text-red"></i></h4>
                <p class="small text-muted">
                    Showing all of the vital signs history of this patient.
                </p>
            </div>

            <div class="modal-body">

                <div class="table-responsive height420">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>BP</th>
                                <th>PR</th>
                                <th>RR</th>
                                <th>TEMP</th>
                                <th>KG</th>
                                <th>CM</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="vs in vs_history_array">
                                <td>@{{ vs.blood_pressure }}</td>
                                <td>@{{ vs.pulse_rate }}</td>
                                <td>@{{ vs.respiration_rate }}</td>
                                <td>@{{ vs.body_temperature }}</td>
                                <td>@{{ vs.weight }}</td>
                                <td>@{{ vs.height }}</td>
                                <td>@{{ vs.created_at | time_calculate }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>