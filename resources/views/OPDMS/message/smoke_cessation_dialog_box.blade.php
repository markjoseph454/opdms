<div class="smoke_cessation_dialog_box">

    <div class="col-md-3 col-xs-12 bg-danger close_consultation_form_content">

        @include('OPDMS.partials.loader_notification')

        <h5 class="text-red">
            <i class="fa fa-info-circle fa-lg"></i>
            A smoked cessation record of this patient has been found.
        </h5>
        <h5>
            Smoke cessation was been ordered by.
        </h5>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="smoke in smoke_cessation_doctors">
                        <td>
                            <strong class="text-blue">DR. @{{ smoke.last_name }}, @{{ smoke.first_name }}</strong>
                        </td>
                        <td>@{{ smoke.smoking_date | formatted_date }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <button class="btn btn-flat bg-black just_close_smoke_cessation"
        onclick="$('.smoke_cessation_dialog_box').fadeOut('fast')">
            Cancel
        </button>
        <button class="btn btn-flat bg-red"
        v-on:click="insert_smoke_cessation_anyway">
            Insert Smoke Cessation Anyway
        </button>
    </div>
</div>