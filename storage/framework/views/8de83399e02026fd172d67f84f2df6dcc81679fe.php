<div class="container">
	<div class="row">
		<br/>
		<h3 class="text-center">TRIAGE SUPPORT</h3>
		
			<div class="col-md-8">
				<div class="form-group">
					<label>Assign Clinic / Ancillary</label>
					<select name="clinic" class="form-control select select2" style="height: 40px;">
						<option value="">Select Clinic</option>
						<?php $__currentLoopData = $clinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($clinic->code); ?>"><?php echo e($clinic->name); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</div>
			</div>
			
			<div class="col-md-2">
				<div class="form-group">
					<label>Weight</label>
					<div class="input-group">
					    <input type="text" name="weight" class="form-control" value="<?php echo e(old('weight')); ?>" placeholder="Enter Weight" />
					    <div class="input-group-addon">KG.</div>
					</div>
				</div>
			</div>

			<div class="col-md-2">
				<div class="form-group">
					<label>Height</label>
					<div class="input-group">
					    <input type="text" name="height" class="form-control" value="<?php echo e(old('height')); ?>" placeholder="Enter Height" />
					    <div class="input-group-addon">CM.</div>
					</div>
				</div>
			</div>
		
			<div class="col-md-3">
				<div class="form-group">
					<label>Blood Pressure</label>
					<div class="input-group">
					    <input type="text" name="blood_pressure" class="form-control" value="<?php echo e(old('blood_pressure')); ?>" 
					    placeholder="Enter Blood Pressure" />
					    <div class="input-group-addon">BP</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label>Pulse Rate</label>
					<div class="input-group">
					    <input type="text" name="pulse_rate" class="form-control" value="<?php echo e(old('pulse_rate')); ?>" placeholder="Enter Pulse Rate" />
					    <div class="input-group-addon">BPM</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label>Respiration Rate</label>
					<div class="input-group">
					    <input type="text" name="respiration_rate" class="form-control" value="<?php echo e(old('respiration_rate')); ?>" 
					    placeholder="Enter Respiration Rate" />
					    <div class="input-group-addon">RM</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label>Body Temperature</label>
					<div class="input-group">
					    <input type="text" name="body_temperature" class="form-control" value="<?php echo e(old('body_temperature')); ?>" 
					    placeholder="Enter Body Temperature" />
					    <div class="input-group-addon">°C</div>
					</div>
				</div>
			</div>
		

	</div>
</div>


<br>





