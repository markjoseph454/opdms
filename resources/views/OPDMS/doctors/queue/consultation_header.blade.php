

<button type="button" class="close close_create_consultation">
    <span aria-hidden="true">&times;</span>
</button>
<h4 class="modal-title text-primary text-uppercase">@{{ p_name }}</h4>

<button class="btn btn-flat btn-default" v-on:click.prevent="patient_information">
    <i class="fa fa-user-circle fa-lg text-blue"></i>
    <span>Patient Information</span>
</button>

<button class="btn btn-flat btn-default" data-toggle="tooltip" title="Create a new blank consultation form"
        v-on:click="blank_consultation_form" {{--v-if="new_blank_nurse_form"--}}>
    <img src="{{ asset('public/images/blank-consultation-form.svg') }}" class="img-responsive img-12 inline"  alt="">
    <i class="fa fa-check icon_indicator"></i>
</button>

<button class="btn btn-flat btn-default" data-toggle="tooltip" title="Request for medical certificate"
        v-on:click="blank_consultation_form" {{--v-if="new_blank_nurse_form"--}}>
    <img src="{{ asset('public/images/medical-certificate.svg') }}" class="img-responsive img-12 inline"  alt="">
    <i class="fa fa-check icon_indicator"></i>
</button>

<a v-bind:href="show_nurse_notes_print_link" target="_blank" class="btn btn-flat btn-default"
   data-toggle="tooltip" title="Print this consultation."
   v-if="show_nurse_notes_print">
    <i class="fa fa-print fa-lg text-info"></i>
</a>


<div class="btn-group">
    <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown"
            title="Vital Signs">
        <i class="fa fa-heartbeat fa-lg text-red"></i>
        <i class="fa fa-check icon_indicator"></i>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="" v-on:click.prevent="insert_vs">Insert vital signs on consultation form</a>
        </li>
        <li>
            <a href="" v-on:click.prevent="vs_history">View vital signs history</a>
        </li>
    </ul>
</div>

<button class="btn btn-flat btn-default" data-toggle="tooltip"
        title="Click to insert smoke cessation"
        v-on:click="inset_smoke_cessation">
    <img src="{{ asset('public/images/smoke-cessation.svg') }}" class="img-responsive img-12 inline" />
    <i class="fa fa-check icon_indicator"></i>
</button>

<button class="btn btn-flat btn-default" data-toggle="tooltip" v-on:click.prevent="get_patient_notifications"
        title="Consultations, Follow-up and Referrals Notifications">
    <i class="fa fa-bell fa-lg text-yellow"></i>
</button>

<button class="btn btn-flat btn-default" data-toggle="tooltip" v-on:click.prevent="medical_records"
        title="Medical Records">
    <img src="{{ asset('public/images/medical-records.svg') }}" class="img-responsive img-12" />
</button>

<div class="inline pull-right">
    <button class="btn btn-flat btn-default" data-toggle="tooltip"
            title="Refer to other clinics" v-on:click.prevent="referral_insert">
        <img src="{{ asset('public/images/referrals.svg') }}" class="img-responsive img-12 inline" />
        <i class="fa fa-check icon_indicator"></i>
        Referrals
    </button>
    <button class="btn btn-flat btn-default" data-toggle="tooltip"
            title="Schedule for follow-up" v-on:click.prevent="followup_show">
        <img src="{{ asset('public/images/follow-up.svg') }}" class="img-responsive img-12 inline" />
        <i class="fa fa-check icon_indicator"></i>
        Follow-up
    </button>
    <button class="btn btn-flat btn-default" data-toggle="tooltip"
            title="Request ancillary items / services.">
        <img src="{{ asset('public/images/requisition.svg') }}" class="img-responsive img-12 inline" />
        <i class="fa fa-check icon_indicator"></i>
        Requisition
    </button>
    <button class="btn btn-flat btn-default" data-toggle="tooltip"
            title="Select ICD 10 Codes"
    v-on:click.prevent="icd_codes">
        <img src="{{ asset('public/images/icd-10-codes.svg') }}" class="img-responsive img-12 inline" />
        <i class="fa fa-check icon_indicator"></i>
        ICD 10 Codes
    </button>
    <button class="btn btn-flat btn-default" data-toggle="tooltip"
            title="Select RVS Code">
        <img src="{{ asset('public/images/rvs-codes.svg') }}" class="img-responsive img-12 inline" />
        <i class="fa fa-check icon_indicator"></i>
        RVS Codes
    </button>
</div>

<br>
<small>
    If you have previously consulted this patient then its latest saved consultation will
    be shown in order to enhance continuity and coordination of care.
</small>
