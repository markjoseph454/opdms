<div class="modal" id="consultation_show_modal">

    <div class="modal-dialog modal-lg">


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
                <a v-bind:href="consultation_print_btn" target="_blank"
                   class="btn btn-flat btn-info">Print <i class="fa fa-print"></i>
                </a>
                <a v-bind:href="create_nurse_notes_link" class="btn btn-flat bg-navy"
                   v-if="create_nurse_notes" v-on:click.prevent="write_nurse_notes_two">Write Nurse Notes
                    <i class="fa fa-pencil"></i>
                </a>
                <a v-bind:href="edit_consultation_link" class="btn btn-flat bg-blue"
                   v-if="edit_consultation">Edit Consultation
                    <i class="fa fa-pencil"></i>
                </a>
                <br>
                <small>
                    <em class="text-muted">Clinic:</em> {{ consultation_clinic_name | capitalize  }} |
                    <em class="text-muted">Consulted / Assisted by:</em> {{ consultation_consulted_by | capitalize  }} |
                    <em class="text-muted">Last Modified:</em> {{ consultation_date | capitalize  }}
                </small>
            </div>
            <div class="modal-body">
                <div id="consultation_show_wrapper">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</button>
                <small class="text-muted">
                    Only the doctor who created this consultation are allowed to edit.
                </small>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>