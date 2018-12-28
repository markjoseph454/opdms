<div class="modal" id="patient_notifications_modal">

    <div class="modal-dialog modal-xl">


        <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 


        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-primary text-uppercase">{{ p_name }}</h4>
                <button class="btn btn-flat bg-blue" v-on:click.prevent="patient_information">
                    <i class="fa fa-user-o"></i>
                    <span>Patient Information</span>
                </button>
                <small class="text-muted">
                    Showing all consultations, referrals, and follow-up notifications of this patient.
                </small>
            </div>

            <div class="modal-body">

                <div class="row">

                    
                    <div class="col-md-5">
                        <div class="table table-responsive">
                            <h4>
                                Consultations Overview
                                <button class="btn bg-green-inverse" onclick="open_all_consultations()"
                                        v-if="patient_consultations.length">
                                    Open All Consultations
                                </button>
                            </h4>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr class="bg-green-gradient">
                                    <th>Clinic/Department</th>
                                    <th>Consulted/Assisted by</th>
                                    <th>Last Modified</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="consultation in patient_consultations">
                                        <td class="text-uppercase">{{ consultation.name }}</td>
                                        <td class="text-uppercase text-blue text-bold">
                                            <small v-if="consultation.role == 7" class="text-muted">DR. </small>
                                            <small v-else class="text-muted">OTHERS </small>
                                            {{ consultation.last_name }}, {{ consultation.first_name }}
                                        </td>
                                        <td>{{ consultation.updated_at | formatted_date}}</td>
                                    </tr>
                                </tbody>
                                <tfoot v-if="patient_consultations.length <= 0">
                                <tr>
                                    <td colspan="8" class="text-red text-center">
                                        Consultation records of this patient is currently empty.
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>



                    <div class="col-md-7">

                        
                        <div class="table table-responsive">
                            <h4>Follow-up Overview</h4>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr class="bg-blue-gradient">
                                    <th>Clinic/Department</th>
                                    <th>Consulted/Assisted By</th>
                                    <th>Follow-up To</th>
                                    <th>Follow-up Date</th>
                                    <th>Reason</th>
                                    <th>Date Created</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="followup in patient_followup">
                                    <td class="text-uppercase">{{ followup.name }}</td>
                                    <td class="text-uppercase text-blue text-bold">
                                        <small v-if="followup.role == 7" class="text-muted">DR. </small>
                                        <small v-else class="text-muted">OTHERS </small>
                                        {{ followup.last_name }}, {{ followup.first_name }}
                                    </td>
                                    <td class="text-uppercase text-blue text-bold" v-if="followup.ft_last_name">
                                        <small v-if="followup.role == 7" class="text-muted">DR. </small>
                                        <small v-else class="text-muted">OTHERS </small>
                                        {{ followup.ft_last_name }}, {{ followup.ft_first_name }}
                                    </td>
                                    <td v-else class="text-muted">
                                        None
                                    </td>
                                    <td>Today {{ followup.followupdate | formatted_date }}</td>
                                    <td>{{ followup.reason }}</td>
                                   <td>{{ followup.created_at | formatted_date}}</td>
                                </tr>
                                </tbody>
                                <tfoot v-if="patient_followup.length <= 0">
                                    <tr>
                                        <td colspan="7" class="text-red text-center">
                                            This is patient has no scheduled follow-up today
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>



                        
                        <div class="table table-responsive">
                            <h4>Referrals Overview</h4>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr class="bg-yellow-gradient">
                                    <th>From Clinic</th>
                                    <th>Referred By</th>
                                    <th>To Clinic</th>
                                    <th>Referred To</th>
                                    <th>Reason</th>
                                    <th>Date Created</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="referral in patient_referrals">
                                        <td class="text-uppercase">{{ referral.from_clinic }}</td>
                                        <td class="text-uppercase text-blue text-bold">
                                            <small v-if="referral.role == 7" class="text-muted">DR. </small>
                                            <small v-else class="text-muted">OTHERS </small>
                                            {{ referral.last_name }}, {{ referral.first_name }}
                                        </td>
                                        <td class="text-uppercase">{{ referral.to_clinic }}</td>
                                        <td class="text-uppercase text-blue text-bold" v-if="referral.rt_last_name">
                                            <small v-if="referral.role == 7" class="text-muted">DR. </small>
                                            <small v-else class="text-muted">OTHERS </small>
                                            {{ referral.rt_last_name }}, {{ referral.rt_first_name }}
                                        </td>
                                        <td v-else class="text-muted">
                                            None
                                        </td>
                                        <td>{{ referral.reason }}</td>
                                        <td>{{ referral.created_at | formatted_date}}</td>
                                    </tr>
                                </tbody>
                                <tfoot v-if="patient_referrals.length <= 0">
                                <tr>
                                    <td colspan="8" class="text-red text-center">
                                        This is patient has no pending referrals from other clinics.
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>


                </div>



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>