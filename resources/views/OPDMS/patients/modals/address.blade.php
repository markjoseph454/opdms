<div class="modal" id="modal-address">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Select Address
            </div>
            <div class="modal-body">
                <div class="row">
                    
                    <div class="col-md-12 col-sm-12 divider">
                        <label>Region <b class="text-red">*</b></label>
                        <select name="region" class="form-control region select2" id="region" 
                                onchange="showProvince($(this).val())" style="width: 100%">
                            <option value="" hidden>Select Region</option>
                        </select>
                            <!-- <span class="help-block">
                                <strong>{{ $errors->first('region') }}</strong>
                            </span> -->
                    </div>

                    <div class="col-md-12 col-sm-12 divider">
                        <label class="provinceLabel">Province <b class="text-red">*</b></label>
                        <select name="province" class="form-control province select2" id="province" style="width: 100%">
                            <option value="" hidden>Select Province</option>
                        </select>
                       <!--  @if ($errors->has('province'))
                            <span class="help-block">
                                <strong>{{ $errors->first('province') }}</strong>
                            </span>
                        @endif -->
                        
                    </div>

                    <div class="col-md-12 col-sm-12 divider">
                        <label class="citymunicipalityLabel">City / Municipality <b class="text-red">*</b></label>
                        <select name="city_municipality" class="form-control city_municipality select2" id="city_municipality" style="width: 100%">
                            <option value="" hidden>Select City / Municipality</option>
                        </select>
                        <!-- @if ($errors->has('city_municipality'))
                            <span class="help-block">
                                <strong>{{ $errors->first('city_municipality') }}</strong>
                            </span>
                        @endif -->
                    </div>

                    <div class="col-md-12 col-sm-12 divider">
                        <label class="brgyLabel">Barangay </label>
                        <select name="brgy" class="form-control brgy select2" id="brgy" style="width: 100%">
                            <option value="" hidden>Select Barangay</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm" id="clone-address" data-dismiss="modal"><span class="fa fa-check"></span> OK</button>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->