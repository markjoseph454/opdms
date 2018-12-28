<!-- Sidebar Menu -->




<ul class="sidebar-menu" data-widget="tree">


    <li class="header action_buttons bg-green" v-if="action_btn_loader">
        <i class="fa fa-spinner fa-pulse fa-lg"></i> Please wait...
    </li>

    <li class="header action_buttons" v-if="!action_btn_loader && patient_selected && !currently_serving">
        Action Buttons
    </li>

    <li class="header action_buttons" v-if="currently_serving">
        <span class="text-green">Now Serving Patient</span> <br>
        <small class="text-gray">
            To consult this patient please finish the patient <br>
            you are now serving.
            <a href="" class="text-aqua">End Consultation</a>
        </small>
    </li>

    <li v-if="consultation_open" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-bind:class="{ active_link : is_active_link}"
           v-on:click.prevent="start_consultation_now">
            <i class="fa fa-folder-open-o text-aqua" style="font-size: 16px"></i>
            <span>Open Consultation</span>
        </a>
    </li>
    <li v-if="start_consultation" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-bind:class="{ active_link : is_active_link}"
           v-on:click.prevent="start_consultation_now">
            <i class="fa fa-play text-green"></i>
            <span>Start Consultation</span>
        </a>
    </li>
    <li v-if="end_consultation" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-bind:class="{ active_link : is_active_link}"
           v-on:click.prevent="end_consultation_now">
            <i class="fa fa-ban text-red" style="font-size: 16px"></i>
            <span>End Consultation</span>
        </a>
    </li>
    <li v-if="reconsult" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-bind:class="{ active_link : is_active_link}"
           v-on:click.prevent="reconsult_now">
            <i class="fa fa-refresh text-green"></i>
            <span>Reconsult</span>
        </a>
    </li>
    <li v-if="pause_consultation" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-bind:class="{ active_link : is_active_link}"
           v-on:click.prevent="pause_consultation_now">
            <i class="fa fa-pause text-brown"></i>
            <span>Pause Consultation</span>
        </a>
    </li>
    <li v-if="nawc_consultation" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-bind:class="{ active_link : is_active_link}"
           v-on:click.prevent="nawc_consultation_now">
            <i class="fa fa-remove text-red" style="font-size: 16px"></i>
            <span>Not Around When Called</span>
        </a>
    </li>



    

   

    <li class="header action_buttons" v-if="patient_selected">
        Main Menu
    </li>


    <li v-if="patient_selected" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-on:click.prevent="patient_information"
           v-bind:class="{ active_link : is_active_link }">
            <i class="fa fa-user-o"></i>
            <span>Patient Information</span>
        </a>
    </li>
    <li v-if="patient_selected" v-bind:class="{ active_li : is_active_li }">
        <a href="" id="medical_records_btn" v-on:click.prevent="medical_records"
           v-bind:class="{ active_link : is_active_link }">
            <i class="fa fa-file-text-o"></i>
            <span>Medical Records</span>
        </a>
    </li>
    <li v-if="patient_selected" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-on:click.prevent="get_patient_notifications"
           v-bind:class="{ active_link : is_active_link }">
            <i class="fa fa-bell-o"></i> <span>Notifications</span>
            <span class="pull-right fa fa-circle text-yellow" v-if="rr_notification_show"
                  title="Referrals"></span>
            <span class="pull-right fa fa-circle text-blue" v-if="ff_notification_show"
                  title="Today`s Follow-up"></span>
            <span class="pull-right fa fa-circle text-green" v-if="ls_notification_show"
                  title="Last Consultation"></span>
        </a>
    </li>
    <li v-if="patient_selected" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-bind:class="{ active_link : is_active_link}"
           v-on:click.prevent="show_vs_modal">
            <i class="fa fa-heartbeat"></i>
            <span>Vital Signs</span>
        </a>
    </li>








    

    

    




</ul>
