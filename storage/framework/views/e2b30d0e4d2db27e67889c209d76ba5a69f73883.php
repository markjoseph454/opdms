<!-- Modal -->
<div id="addressModal" class="modal" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title text-center">SELECT ADDRESS</h3>
        </div>
        <div class="modal-body" id="addressWrapper">

                <div class="form-group <?php if($errors->has('region')): ?> has-error <?php endif; ?>">
                    <label>Region</label>
                    <select name="region" class="form-control select select2"
                            onchange="showProvince($(this))" style="width: 100%">
                        <option value="">Select Region</option>
                    </select>
                    <?php if($errors->has('region')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('region')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>



                <div class="form-group <?php if($errors->has('province')): ?> has-error <?php endif; ?>">
                    <label class="provinceLabel">Province </label>
                    <select name="province" class="form-control select select2" style="width: 100%">
                        <option value="">Select Province</option>
                    </select>
                    <?php if($errors->has('province')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('province')); ?></strong>
                        </span>
                    <?php endif; ?>
                    <p class="text-danger provinceError">Please select region first.</p>
                </div>




                <div class="form-group <?php if($errors->has('city_municipality')): ?> has-error <?php endif; ?>">
                    <label class="citymunicipalityLabel">City / Municipality </label>
                    <select name="city_municipality" class="form-control select select2" style="width: 100%">
                        <option value="">Select City / Municipality</option>
                    </select>
                    <?php if($errors->has('city_municipality')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('city_municipality')); ?></strong>
                        </span>
                    <?php endif; ?>
                    <p class="text-danger citymunError">Please select province first.</p>
                </div>



                <div class="form-group">
                    <label class="brgyLabel">Barangay </label>
                    <select name="brgy" class="form-control select select2" style="width: 100%">
                        <option value="">Select Barangay</option>
                    </select>
                    <p class="text-danger brgyError">Please select city / municipality first.</p>
                </div>

            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">
                OK <i class="fa fa-check"></i>
            </button>
        </div>
    </div>

    </div>
</div>