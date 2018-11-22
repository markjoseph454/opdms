<div class="modal" id="consultation_all_modal">

    <div class="modal-dialog modal-xl">


        <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 


        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-primary text-uppercase">
                    {{ p_name }}
                </h4>
                <small class="text-muted">
                    Shown here are all the saved consultations of this patient.
                </small>
            </div>



            <div class="modal-body">



                <div class="row consultation_view_mother">

                    <div class="col-md-2 thumbnail_main_container">

                        <div class="search_consultation_container">
                            <form action="">
                                <input type="text" class="form-control input-sm" placeholder="Filter by clinic or doctor..."
                                v-model="search_filter">
                            </form>
                            <small class="text-muted">
                                <em>Consultations found {{ consultation_count }}</em>
                            </small>
                        </div>


                        <div class="thumbnail_container">



                            <div class="thumbnail_wrapper_main" v-for="(consultation, index) in search_filter_consultation">
                                <div class="thumbnail_wrapper" v-html="consultation.consultation" v-on:click="open_consultation($event, index)">
                                </div>
                                <p class="page_number">
                                    {{ index + 1 }}
                                </p>
                            </div>

                        </div>




                    </div>

                    <div class="col-md-10 consultation_view_main_container">

                        <div class="consultation_header_wrapper row">
                            <a v-bind:href="consultation_print_btn" target="_blank"
                               class="btn btn-flat btn-sm btn-info">Print <i class="fa fa-print"></i>
                            </a>
                            <button class="btn btn-flat btn-sm bg-navy"
                            v-if="featured_nurse_notes" v-on:click.prevent="write_nurse_notes_two">
                                Write Nurse Notes
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-flat btn-sm bg-blue"
                            v-if="featured_edit_consultation">Edit Consultation
                                <i class="fa fa-pencil"></i>
                            </button>

                            <div>
                                <small class="text-muted">Clinic: </small>
                                <small class="text-blue">{{ featured_clinic | uppercase }}</small> |
                                <small class="text-muted">Consulted/Assisted By:</small>
                                <small class="text-blue">
                                    <small class="small">{{ featured_ext }}</small>
                                    {{ featured_doctor | uppercase }}</small> |
                                <small class="small text-muted">Last Modified: </small>
                                <small class="text-blue">{{ featured_date | formatted_date }}</small>
                            </div>
                        </div>


                        <div class="consultation_body_wrapper row">

                            <div class="consultation_container" v-html="featured_consultation">
                            </div>

                        </div>


                    </div>

                </div>


            </div>



            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</button>
                <small class="text-muted">
                    Showing all saved consultations of this patient.
                </small>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>