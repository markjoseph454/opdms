<div class="modal" id="medical_records_modal">

    <div class="modal-dialog modal-xl">




        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-primary text-uppercase">{{ p_name }}</h4>
                <p class="small text-muted">
                    Shown here are all the medical records that identifies the patient and contains information regarding the patient's case history.
                </p>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="list-group" id="medical_records_div_menu_container">
                            <a href="" class="list-group-item bg-light-blue highlight_consultation_menu"
                            v-on:click.prevent="consultation_records($event)">
                                Consultations
                                <span class="badge">{{ consultations_count }}</span>
                            </a>
                            <a href="#" class="list-group-item" data-toggle="collapse" data-target="#other_forms_content"
                            v-on:click="active_link_record($event)">
                                Other Forms
                                
                                
                                <i class="fa fa-caret-down pull-right small"></i>
                            </a>
                            <div id="other_forms_content" class="collapse">
                                <a href="" class="list-group-item small"
                                v-on:click.prevent="pediatric_records">
                                    <span class="fa fa-circle-o"></span>
                                    Pediatrics Clinic
                                    <span class="badge">{{ pedia_total }}</span>
                                </a>
                                <a href="" class="list-group-item small"
                                   v-on:click.prevent="industrial_records">
                                    <span class="fa fa-circle-o"></span> Industrial Clinic
                                    <span class="badge">{{ industrial_count }}</span>
                                </a>
                            </div>
                            <a href="" class="list-group-item"
                               v-on:click.prevent="referral_records($event)">
                                Referrals
                                <span class="badge">{{ referrals_count }}</span>
                            </a>
                            <a href="" class="list-group-item"
                               v-on:click.prevent="followup_records($event)">
                                Follow-up
                                <span class="badge">{{ followup_count }}</span>
                            </a>
                            <a href="" class="list-group-item"
                               v-on:click.prevent="ultrasound_records($event)">
                                Ultrasound
                                <span class="badge">{{ ultrasound_count }}</span>
                            </a>
                            <a href="" class="list-group-item"
                               v-on:click.prevent="xray_records($event)">
                                X-ray
                                <span class="badge">{{ xray_count }}</span>
                            </a>
                            <a href="" class="list-group-item"
                               v-on:click.prevent="ecg_records($event)">
                                ECG Requests
                                <span class="badge">{{ ecg_count }}</span>
                            </a>
                            <a href="" class="list-group-item"
                               v-on:click.prevent="laboratory_records($event)">
                                Laboratory / Other Requests
                                <span class="badge">{{ laboratory_count }}</span>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-9 medical_records_content_show">






                        <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="medical_records_main_thead">
                                    <tr>
                                        <th v-for="row in medical_records_thead">
                                            {{ row }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="medical_records_tbody">
                                </tbody>
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