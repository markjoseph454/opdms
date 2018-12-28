<div class="modal" id="followup_modal">

    <div class="modal-dialog modal-xl">

        @include('OPDMS.partials.loader') {{-- loader icon --}}

        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

                <h4 class="modal-title text-primary text-uppercase">@{{ p_name }}</h4>

                <button class="btn btn-flat btn-default" v-on:click.prevent="patient_information">
                    <i class="fa fa-user-circle fa-lg text-blue"></i>
                    <span>Patient Information</span>
                </button>

                <small>
                    Schedule this patient for follow-up appointments.
                </small>
            </div>

            <div class="modal-body">

                <div class="row">


                    <div class="col-md-8">
                        <h4 class="text-center text-blue">
                            Follow-up History
                        </h4>
                        <div class="table-responsive referral_history_table_parent">
                            <table class="table table-bordered table-hover table-striped" style="font-size: 11px">
                                <thead>
                                <tr>
                                    <th>Clinic</th>
                                    <th>Consulted By</th>
                                    <th>Assigned To</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Follow-up Date</th>
                                    <th>Date Created</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="(followup, index) in followups">
                                    <td>@{{ followup.clinic }}</td>
                                    <td>
                                        <strong class="text-blue text-uppercase">DR. @{{ followup.fromDoctor }}</strong>
                                    </td>
                                    <td>
                                        <strong class="text-blue text-uppercase" v-if="followup.toDoctor">
                                            DR. @{{ followup.toDoctor }}
                                        </strong>
                                        <strong class="text-muted" v-else>None</strong>
                                    </td>
                                    <td>@{{ followup.reason }}</td>
                                    <td>
                                        <label class="label label-warning" v-if="followup.status == 'P'">
                                            Pending
                                        </label>
                                        <label class="label label-info" v-else>
                                            Finished
                                        </label>
                                    </td>
                                    <td>@{{ followup.followupdate | formatted_date }}</td>
                                    <td>@{{ followup.created_at | formatted_date }}</td>
                                    <td>
                                        <button class="btn btn-circle btn-circle-red"
                                                v-on:click="delete_followup(followup.id, index)"
                                                v-if="auth_delete_followup(followup.status, followup.users_id)">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr v-if="followups.length <= 0">
                                    <td class="text-red text-bold text-center" colspan="9">
                                        No followup history found
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="col-md-4 border_left">
                        <h4 class="text-center text-blue">
                            Follow-up Form
                        </h4>

                        @include('OPDMS.message.errors_ajax')

                        <form action="" v-on:submit.prevent="followup_form_submit($event)" id="followup_form">
                            <input type="hidden" name="patient_id" v-bind:value="pid" />
                            <div class="form-group">
                                <label class="small">
                                    Reasons for follow-up
                                </label>
                                <small class="text-yellow pull-right">(Optional)</small>
                                <textarea name="reason" cols="30" rows="3" class="form-control"
                                          placeholder="Type your reasons here..."></textarea>
                            </div>

                            <div class="form-group">
                                <label class="small">
                                    Follow-up Date
                                </label>
                                <small class="text-yellow pull-right">(Required)</small>
                                <input type="text" name="date" class="form-control datepicker4"
                                       placeholder="Select date for follow-up" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label class="small">
                                    Medical Clinic / Department
                                </label>
                                <small class="text-yellow pull-right">(Required)</small>
                                <input type="text" name="clinic" class="form-control"
                                       v-bind:value="followup_clinic" readonly="" />
                            </div>

                            <div class="form-group">
                                <label class="small">
                                    Assign to specific doctor
                                    <i class="fa fa-spinner fa-spin text-green referral_clinic_doctor"></i>
                                </label>
                                <small class="text-yellow pull-right">(Optional)</small>
                                <select name="doctor" class="form-control select2" style="width: 100%">
                                    <option value="">--Select--</option>
                                    <option v-bind:value="doctor.id" v-for="doctor in followup_doctors">
                                        @{{ doctor.last_name | uppercase }}, @{{ doctor.first_name | uppercase}}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-flat bg-green">
                                    Submit & Save
                                </button>
                            </div>

                        </form>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal"
                        aria-label="Close">Close
                </button>
                <small class="text-muted">
                    In order to generate statistical data about scheduled follow-up's of this clinic, it is highly
                    important that follow-up's be created here.
                </small>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>