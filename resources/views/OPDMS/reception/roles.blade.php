<!-- Sidebar Menu -->




<ul class="sidebar-menu" data-widget="tree">

     {{--dashboard header title--}}


    <li class="header action_buttons bg-green" v-if="action_btn_loader">
        <i class="fa fa-spinner fa-pulse fa-lg"></i> Please wait...
    </li>

    <li class="header action_buttons" v-if="action_btn_header">
        Action Buttons
    </li>

    <li v-if="assignations" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-on:click.prevent="patient_assignation"
           v-bind:class="{ active_link : is_active_link }">
            <i class="fa fa-arrow-left"></i>
            <span>Assignations</span>
        </a>
    </li>
    <li v-if="re_assign" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-on:click.prevent="patient_re_assignation"
           v-bind:class="{ active_link : is_active_link }">
            <i class="fa fa-arrow-left"></i>
            <span>Re-assign</span>
        </a>
    </li>
    <li v-if="nawc" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-on:click.prevent="remove_queued_patient"
           v-bind:class="{ active_link : is_active_link }">
            <i class="fa fa-trash-o"></i>
            <span>Remove</span>
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
        <a href="" v-on:click.prevent="write_nurse_notes"
           v-bind:class="{ active_link : is_active_link }">
            <i class="fa fa-pencil"></i>
            <span>Nurse Notes</span>
        </a>
    </li>
    {{-- for industrial only --}}
    <li v-if="patient_selected" v-bind:class="{ active_li : is_active_li }">
        <a href="" v-bind:class="{ active_link : is_active_link}"
           v-on:click.prevent="show_vs_modal"
           v-if="user_clinic == 43">
            <i class="fa fa-file-text"></i>
            <span>Industrial Form</span>
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
    <li v-if="charging_allowed" v-bind:class="{ active_li : is_active_li }">
        <a href="#"
           v-bind:class="{ active_link : is_active_link }"
        v-on:click.prevent="charged_patient">
            <i class="fa fa-database"></i>
            <span>Charging</span>
            <span class="pull-right-container">
                <small class="label pull-right bg-green" title="Paid" v-if="paid_request">
                    @{{ paid_request }}
                </small>
                <small class="label pull-right bg-blue" title="Request" v-if="service_request">
                    @{{ service_request }}
                </small>
            </span>
        </a>
    </li>






    {{-- dashboard header title --}}
    {{--<li class="header">Active Links</li>


    <li class="treeview">
        <a href="#"><i class="fa fa-paste"></i>
            <span>Reception</span>
            <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="{{ url('patient_queue') }}">
                    <i class="fa fa-user-circle"></i>
                    Patients Queue
                </a>
            </li>
            <li class="">
                <a href="{{ url('doctors_queue') }}">
                    <i class="fa fa-user-md"></i>
                    Doctors Queue
                </a>
            </li>
            <li class="">
                <a href="{{ url('queued_history') }}">
                    <i class="fa fa-history"></i>
                    Queuing History
                </a>
            </li>
        </ul>
    </li>--}}





    {{-- Reports Links --}}

    {{-- dashboard secondary title --}}
    <li class="header">Secondary</li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-file-text-o"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="{{ url('censusWatch') }}" onclick="full_loader()">
                    <i class="fa fa-circle-o"></i>
                    Queuing Statistic
                </a>
            </li>
            <li>
                <a href="{{ url('famedcensus') }}" onclick="full_loader()">
                    <i class="fa fa-circle-o"></i>
                    Age, Gender Distribution
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-circle-o"></i>
                    Medical Services
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ url('medServicesAccomplished') }}" onclick="full_loader()">
                            <i class="fa fa-circle-o"></i>
                            Services Accomplished
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('topLeadingServices') }}" onclick="full_loader()">
                            <i class="fa fa-circle-o"></i>
                            Top Leading Services
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('ancillarycensus') }}?top=ALL&from={{Carbon::now()->setTime(0,0)->format('Y-m-d')}}&to={{Carbon::now()->setTime(0,0)->format('Y-m-d')}}"
                           onclick="full_loader()">
                            <i class="fa fa-circle-o"></i>
                            Service Per Patient
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ url('highestCases') }}" onclick="full_loader()">
                    <i class="fa fa-circle-o"></i>
                    Highest Cases
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-circle-o"></i>
                    Demographic
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ url('demographic') }}" onclick="full_loader()"><i class="fa fa-circle-o"></i>
                           Detailed Census
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('demographicSummary') }}" onclick="full_loader()"><i class="fa fa-circle-o"></i>
                            Summary Census
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ url('ancillaryreport') }}" onclick="full_loader()">
                    <i class="fa fa-circle-o"></i>
                    MSS Report
                </a>
            </li>
            <li>
                <a href="{{ url('refferalsReport') }}" onclick="full_loader()">
                    <i class="fa fa-circle-o"></i>
                    Referrals Report
                </a>
            </li>
        </ul>
    </li>




</ul>
