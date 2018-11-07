<div class="modal" id="nurse_notes_modal">

    <div class="modal-dialog modal-xl">


        @include('OPDMS.partials.loader') {{-- loader icon --}}

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-primary text-uppercase">@{{ p_name }}</h4>
                <button class="btn btn-flat bg-blue" v-on:click.prevent="patient_information">
                    Patient Information <i class="fa fa-user-circle"></i>
                </button>
                {{-- show print btn if a consultation has already been saved --}}
                <a v-bind:href="show_nurse_notes_print_link" target="_blank" class="btn btn-flat btn-info"
                   v-if="show_nurse_notes_print">
                    Print <i class="fa fa-print"></i>
                </a>
                {{-- insert vs on active editor --}}
                <button class="btn btn-flat bg-red" data-toggle="tooltip" title="Insert VS on Consultation Form"
                        v-on:click="insert_vs">
                    Insert Vital Signs <i class="fa fa-heartbeat"></i>
                </button>
                <button class="btn btn-flat bg-purple" data-toggle="tooltip" title="Create a new blank consultation form"
                        v-on:click="blank_nurse_form" v-if="new_blank_nurse_form">
                    <i class="fa fa-file"></i>
                </button>
                <br>
                <small>Taking accurate nurses notes is one of the most important parts of caring for a patient.</small>
            </div>
            <div class="modal-body">
                <div class="">
                    <form action="{{ url('nurse_notes_save') }}" id="nurse_notes_form">
                        {{ csrf_field() }}
                        <input type="hidden" name="patient_id" v-bind:value="pid"/> {{-- patients id --}}
                        {{-- assigned patch if a consultation has already been found--}}
                        <input type="hidden" name="consultation_patch" v-bind:value="nurse_notes_id"/>
                        <textarea name="consultation" id="nurse_notes_editor" rows="30"></textarea>
                    </form>
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