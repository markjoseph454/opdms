<div class="callout callout-danger" v-if="errors.length">
    <strong>
        <i class="icon fa fa-ban"></i>
        Whoops! looks like something went wrong.
    </strong>
    <br/>
    <ul v-for="error in errors">
        <li>@{{ error }}</li>
    </ul>
</div>