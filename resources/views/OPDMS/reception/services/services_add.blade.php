<div class="modal" id="services_add_modal">

    <div class="modal-dialog">

        @include('OPDMS.partials.loader') {{-- loader icon --}}


        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-blue">
                    Ancillary items & Services offered
                </h4>
                <small class="text-muted">
                    This is were you add ancillary items or services offered of this clinic.
                </small>
            </div>

            <div class="modal-body">

                @include('OPDMS.message.errors')

                <form action="{{ url('services_store') }}" method="post" id="services_add_form">

                    {{ csrf_field() }}

                    <input type="hidden" name="service_patch">

                    <div class="form-group">
                        <label>Service Name / Description</label>
                        <input type="text" name="sub_category" class="form-control" placeholder="Enter Service Name / Description">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Price</label>
                                <div class="input-group">
                                    <span class="input-group-addon">&#8369;</span>
                                    <input type="number" name="price" class="form-control" placeholder="Enter Price">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" id="">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" form="services_add_form" class="btn btn-flat btn-success">Submit & Save</button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>