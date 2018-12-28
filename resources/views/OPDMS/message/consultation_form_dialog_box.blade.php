<div class="close_consultation_form">

    <div class="col-md-3 col-xs-12 bg-danger close_consultation_form_content">

        @include('OPDMS.partials.loader_notification')

        <h5 class="text-red">
            <i class="fa fa-warning"></i>
            Warning, any unsaved changes will be lost.
        </h5>
        <h5>
            Do you really want close this consultation form?
        </h5>
        <button class="btn btn-sm btn-flat btn-default just_cancel">
            Cancel
        </button>
        <button class="btn btn-sm btn-flat bg-black just_close">
            Just Close
        </button>
        <button class="btn btn-sm btn-flat bg-red close_and_end_consultation">
            Close & End Consultation
        </button>
    </div>
</div>