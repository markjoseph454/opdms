<div class="modal" id="charging_modal">

    <div class="modal-dialog modal-xl">

        <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-blue text-uppercase" id="p_name_holder">
                    {{ p_name }}
                </h4>
                <button class="btn btn-flat bg-blue" v-on:click.prevent="patient_information">
                    Patient Information <i class="fa fa-user-circle"></i>
                </button>
                <a href="<?php echo e(url('services_offered')); ?>" target="_blank"
                   class="btn btn-flat bg-aqua-gradient">
                    Ancillary & Services <i class="fa fa-wrench"></i>
                </a>
                <br>
                <small class="text-muted">
                    Showing all ancillary items, services offered by this clinic and the charging history
                    of this patient.
                </small>
                <label class="pull-right text-red">
                    {{ mss_status }}
                </label>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-4">

                        <input type="text" class="form-control filter_ancillary" v-model="search_ancillary_services"
                               placeholder="Filter Results">

                        <div class="table-responsive ancillary_services_wrapper">

                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Add</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr v-for="(anc, index) in search_filter_charging">
                                            <td>
                                                <button class="btn btn-sm btn-circle btn-circle-green"
                                                v-on:click="add_charging(index)">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </td>
                                            <td class="text-blue text-bold">{{ anc.sub_category }}</td>
                                            <td>
                                                &#8369; {{ anc.price | formatMoney }}
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div class="col-md-8">


                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#requisition_table">Requisition</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#unpaid_tab">
                                    Unpaid Requests 
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#paid_but_undone_tab">
                                    Paid but Undone Requests 
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#paid_and_done_tab">
                                    Paid and Done Requests 
                                </a>
                            </li>

                        </ul>


                        <div class="tab-content">

                            <div id="requisition_table" class="tab-pane fade in active">
                                <div class="table-responsive ancillary_services_wrapper">

                                    <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

                                    <form action="<?php echo e(url('charging_save')); ?>" method="post" id="charging_form"
                                          v-on:submit.prevent="save_charging">
                                    <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="pid" v-bind:value="pid" />
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                            <th>Discount</th>
                                            <th>Net Amount</th>
                                            <th>Remove</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(selected_item, index) in add_charging_array">
                                                <td class="text-blue text-bold">{{ selected_item.sub_category }}</td>
                                                <td>&#8369; {{ selected_item.price | formatMoney }}</td>
                                                <td>
                                                    <input type="number" v-on:change.prevent="charging_quantity($event, index)"
                                                           value="1" min="1" name="qty[]"
                                                           class="charging_qty form-control">
                                                </td>
                                                <td>&#8369; {{ selected_item.amount | formatMoney }}</td>
                                                <td>&#8369; {{ selected_item.discount | formatMoney }}</td>
                                                <td>&#8369; {{ selected_item.net | formatMoney }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-circle btn-circle-red" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Click to remove"
                                                    v-on:click="add_charging_array.splice(index, 1)">
                                                        <i class="fa fa-remove"></i>
                                                    </button>
                                                    <input type="hidden" name="sub_id[]" v-bind:value="selected_item.sub_id">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr v-if="add_charging_array.length">
                                                <th colspan="3"></th>
                                                <th class="text-green text-bold">&#8369; {{ charging_amount | formatMoney }}</th>
                                                <th class="text-green text-bold">&#8369; {{ charging_discount | formatMoney }}</th>
                                                <th colspan="2" class="text-red text-bold">&#8369; {{ charging_net | formatMoney }} Total</th>
                                            </tr>
                                            <tr v-else>
                                                <th class="text-center text-red text-bold" colspan="7">
                                                    Requisition currently empty.
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="form-group text-right" v-if="add_charging_array.length">
                                        <button type="submit" class="btn btn-flat bg-green">
                                            Submit & Save
                                        </button>
                                        <button type="button" class="btn btn-flat btn-default"
                                        v-on:click="add_charging_array = []">
                                            Cancel
                                        </button>
                                    </div>
                                    </form>
                                    <p class="text-muted small" style="margin-top: 5px">
                                        This is were all of your requested ancillary items and services offered will be shown.
                                    </p>
                                </div>
                            </div>

                            <div id="unpaid_tab" class="tab-pane fade">
                                <div class="table-responsive ancillary_services_wrapper">

                                    <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

                                        <table class="table table-striped table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Amount</th>
                                                <th>Discount</th>
                                                <th>Net Amount</th>
                                                <th>Date</th>
                                                <th>Remove</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(unpaid, index) in unpaid_request_array">
                                                <td class="text-blue text-bold">{{ unpaid.sub_category }}</td>
                                                <td>&#8369; {{ unpaid.price | formatMoney }}</td>
                                                <td>{{ unpaid.qty }}</td>
                                                <td>&#8369; {{ unpaid.amount | formatMoney }}</td>
                                                <td>&#8369; {{ unpaid.discount | formatMoney }}</td>
                                                <td>&#8369; {{ unpaid.net | formatMoney }}</td>
                                                <td>{{ unpaid.created_at | formatted_date }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-circle btn-circle-red" type="button"
                                                            title="Click to remove"
                                                            v-on:click="unpaid_remove(index)">
                                                        <i class="fa fa-remove"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr v-if="unpaid_request_array.length">
                                                <th colspan="3"></th>
                                                <th class="text-green text-bold">&#8369; {{ unpaid_amount | formatMoney }}</th>
                                                <th class="text-green text-bold">&#8369; {{ unpaid_discount | formatMoney }}</th>
                                                <th colspan="3" class="text-red text-bold">&#8369; {{ unpaid_net | formatMoney }} Total</th>
                                            </tr>
                                            <tr v-else>
                                                <th class="text-center text-red text-bold" colspan="8">
                                                    There has no unpaid requests found.
                                                </th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    <p class="text-muted small" style="margin-top: 5px">
                                        This is were all of your unpaid requests will be shown.
                                    </p>
                                </div>
                            </div>

                            <div id="paid_but_undone_tab" class="tab-pane fade">
                                <div class="table-responsive ancillary_services_wrapper">

                                    <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                            <th>Discount</th>
                                            <th>Net Amount</th>
                                            <th>Date</th>
                                            <th>
                                                <button class="btn btn-sm btn-flat bg-green-inverse"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Click to done all of this requests"
                                                        v-on:click.prevent="done_all"
                                                        v-if="paid_but_undone_array.length > 1">
                                                    <i class="fa fa-check"></i> Done All
                                                </button>
                                                <span v-else>Done</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(undone, index) in paid_but_undone_array">
                                            <td class="text-blue text-bold">{{ undone.sub_category }}</td>
                                            <td>&#8369; {{ undone.price | formatMoney }}</td>
                                            <td>{{ undone.qty }}</td>
                                            <td>&#8369; {{ undone.amount | formatMoney }}</td>
                                            <td>&#8369; {{ undone.discount | formatMoney }}</td>
                                            <td>&#8369; {{ undone.net | formatMoney }}</td>
                                            <td>{{ undone.created_at | formatted_date }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-circle btn-circle-green" type="button"
                                                        title="Click to done this request"
                                                        v-on:click="paid_done(index)">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr v-if="paid_but_undone_array.length">
                                            <th colspan="3"></th>
                                            <th class="text-green text-bold">&#8369; {{ paid_amount | formatMoney }}</th>
                                            <th class="text-green text-bold">&#8369; {{ paid_discount | formatMoney }}</th>
                                            <th colspan="3" class="text-red text-bold">&#8369; {{ paid_net | formatMoney }} Total</th>
                                        </tr>
                                        <tr v-else>
                                            <th class="text-center text-red text-bold" colspan="8">
                                                There has no paid but undone requests found.
                                            </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <p class="text-muted small" style="margin-top: 5px">
                                        This is were all of your already paid but undone requests will be shown.
                                    </p>
                                </div>
                            </div>




                            <div id="paid_and_done_tab" class="tab-pane fade">
                                <div class="table-responsive ancillary_services_wrapper">

                                    <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                            <th>Discount</th>
                                            <th>Net Amount</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(done, index) in paid_and_done_array">
                                            <td class="text-blue text-bold">{{ done.sub_category }}</td>
                                            <td>&#8369; {{ done.price | formatMoney }}</td>
                                            <td>{{ done.qty }}</td>
                                            <td>&#8369; {{ done.amount | formatMoney }}</td>
                                            <td>&#8369; {{ done.discount | formatMoney }}</td>
                                            <td>&#8369; {{ done.net | formatMoney }}</td>
                                            <td>{{ done.created_at | formatted_date }}</td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr v-if="paid_and_done_array.length">
                                            <th colspan="3"></th>
                                            <th class="text-green text-bold">&#8369; {{ done_amount | formatMoney }}</th>
                                            <th class="text-green text-bold">&#8369; {{ done_discount | formatMoney }}</th>
                                            <th colspan="2" class="text-red text-bold">&#8369; {{ done_net | formatMoney }} Total</th>
                                        </tr>
                                        <tr v-else>
                                            <th class="text-center text-red text-bold" colspan="7">
                                                There has no paid and done requests found.
                                            </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <p class="text-muted small" style="margin-top: 5px">
                                        This is were all of your already paid and done requests will be shown.
                                    </p>
                                </div>
                            </div>


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