<div class="modal" id="referral_modal">

    <div class="modal-dialog modal-xl">


        <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 


        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

                <h4 class="modal-title text-primary text-uppercase">{{ p_name }}</h4>

                <button class="btn btn-flat btn-default" v-on:click.prevent="patient_information">
                    <i class="fa fa-user-circle fa-lg text-blue"></i>
                    <span>Patient Information</span>
                </button>

                <small>
                    Refer this patient to other clinics / department.
                </small>
            </div>

            <div class="modal-body">

                <div class="row">


                    <div class="col-md-8">
                        <h4 class="text-center text-blue">
                            Referral History
                        </h4>
                        <div class="table-responsive referral_history_table_parent">
                            <table class="table table-bordered table-hover table-striped" style="font-size: 11px">
                                <thead>
                                    <tr>
                                        <th>From Clinic</th>
                                        <th>From Doctor</th>
                                        <th>To Clinic</th>
                                        <th>To Doctor</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(referral, index) in referrals">
                                        <td>{{ referral.fromClinic }}</td>
                                        <td>
                                            <strong class="text-blue text-uppercase">DR. {{ referral.fromDoctor }}</strong>
                                        </td>
                                        <td>{{ referral.toClinic }}</td>
                                        <td v-if="referral.toDoctor">
                                            <strong class="text-blue text-uppercase">DR. {{ referral.toDoctor }}</strong>
                                        </td>
                                        <td v-else>
                                            <strong class="text-muted">None</strong>
                                        </td>
                                        <td>{{ referral.reason }}</td>
                                        <td>
                                            <label class="label label-warning" v-if="referral.status == 'P'">
                                                Pending
                                            </label>
                                            <label class="label label-info" v-else>
                                                Finished
                                            </label>
                                        </td>
                                        <td>{{ referral.created_at | formatted_date }}</td>
                                        <td>
                                            <button class="btn btn-circle btn-circle-red"
                                                    v-on:click="delete_referral(referral.id, index)"
                                                    v-if="auth_delete_referral(referral.status, referral.users_id)">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <tr v-if="referrals.length <= 0">
                                        <td class="text-red text-bold text-center" colspan="9">
                                            No referral history found
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="col-md-4 border_left">
                        <h4 class="text-center text-blue">
                            Referral Form
                        </h4>
                        <form action="" v-on:submit.prevent="referral_form_submit($event)" id="referral_form">
                            <input type="hidden" name="patient_id" v-bind:value="pid" />
                            <div class="form-group">
                                <label class="small">
                                    Reasons for referral
                                </label>
                                <small class="text-yellow pull-right">(Optional)</small>
                                <textarea name="reason" cols="30" rows="3" class="form-control"
                                          placeholder="Type your reasons here..."></textarea>
                            </div>

                            <div class="form-group">
                                <label class="small">
                                    Medical Clinic / Department
                                </label>
                                <small class="text-yellow pull-right">(Required)</small>
                                <select name="to_clinic" class="form-control select2" required style="width: 100%"
                                onchange="referral_selected_clinic($(this))">
                                    <option value="">--Select--</option>
                                    <option v-for="clinic in referral_other_clinics" v-bind:value="clinic.id">
                                        {{ clinic.name | trimmed }}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="small">
                                    Assign to specific doctor
                                    <i class="fa fa-spinner fa-spin text-green referral_clinic_doctor"></i>
                                </label>
                                <small class="text-yellow pull-right">(Optional)</small>
                                <select name="doctor" class="form-control select2" style="width: 100%">
                                    <option value="">--Select--</option>
                                    <option v-bind:value="doctor.id" v-for="doctor in referral_doctors">
                                        {{ doctor.last_name | uppercase }}, {{ doctor.first_name | uppercase}}
                                    </option>
                                </select>
                                <small class="help-block text-red">
                                    {{ referral_doctor_has_found }}
                                </small>
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
                    In order to generate statistical data about outgoing and incoming referrals of this clinic, it is highly
                    important that referrals be created here.
                </small>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>