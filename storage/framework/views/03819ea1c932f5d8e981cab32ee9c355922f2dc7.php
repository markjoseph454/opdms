<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Register
    <?php $__env->endSlot(); ?>

    <?php $__env->startSection('pagestyle'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('public/AdminLTE/bower_components/select2/dist/css/select2.min.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('public/AdminLTE/dist/css/AdminLTE.min.css')); ?>"> <!-- Theme style -->

         <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/css/patients/register.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/css/patients/address.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/css/triage/triage_support.css')); ?>" rel="stylesheet" />
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('header'); ?>
        <?php echo $__env->make('patients/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>

        <form action='<?php echo e(url("patients/$patient->id")); ?>' method="post" id="registerForm">
            <div class="container">
                <div class="col-md-12">
                    <div class="row">
                        <h3 class="text-center">EDIT PATIENT INFORMATION</h3>
                        <br/>

                            <?php echo $__env->make('message.msg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <?php echo e(csrf_field()); ?>

                            <?php echo e(method_field('PATCH')); ?>


                            <input type="hidden" name="triage" value="<?php echo e(isset($triage->id) ? $triage->id : ''); ?>" />
                            <input type="hidden" name="vital_signs" value="<?php echo e(isset($vital_signs->id) ? $vital_signs->id : ''); ?>" />

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group <?php if($errors->has('last_name')): ?> has-error <?php endif; ?>">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name" class="form-control names" value="<?php echo e($patient->last_name); ?>" 
                                        placeholder="Enter Last Name" autofocus />
                                        <?php if($errors->has('last_name')): ?>
                                            <span class="help-block">
                                                <strong class=""><?php echo e($errors->first('last_name')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group <?php if($errors->has('first_name')): ?> has-error <?php endif; ?>">
                                        <label>First Name</label>
                                        <input type="text" name="first_name" class="form-control names" value="<?php echo e($patient->first_name); ?>" 
                                        placeholder="Enter First Name" />
                                        <?php if($errors->has('first_name')): ?>
                                            <span class="help-block">
                                                <strong class=""><?php echo e($errors->first('first_name')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control names" value="<?php echo e($patient->middle_name); ?>" 
                                        placeholder="Enter Middle Name" />
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Suffix</label>
                                        <select class="form-control select" name="suffix">
                                            <option value="">--</option>
                                            <option <?php if($patient->suffix == 'Jr'): ?> selected <?php endif; ?> >Jr</option>
                                            <option <?php if($patient->suffix == 'Sr'): ?> selected <?php endif; ?> >Sr</option>
                                            <option <?php if($patient->suffix == 'Sra'): ?> selected <?php endif; ?> >Sra</option>
                                            <option <?php if($patient->suffix == 'II'): ?> selected <?php endif; ?> >II</option>
                                            <option <?php if($patient->suffix == 'III'): ?> selected <?php endif; ?> >III</option>
                                            <option <?php if($patient->suffix == 'IV'): ?> selected <?php endif; ?> >IV</option>
                                            <option <?php if($patient->suffix == 'V'): ?> selected <?php endif; ?> >V</option>
                                            <option <?php if($patient->suffix == 'VI'): ?> selected <?php endif; ?> >VI</option>
                                        </select>
                                    </div>
                                </div>

                            </div><!-- first row -->

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group <?php if($errors->has('birthday')): ?> has-error <?php endif; ?>">
                                        <label>Birthday</label>
                                        <input type="text" name="birthday" class="form-control birthday" id="datepicker" 
                                        value="<?php echo e($patient->birthday); ?>" 
                                        placeholder="Enter Patient Birthday" />
                                        <?php if($errors->has('birthday')): ?>
                                            <span class="help-block">
                                                <strong class=""><?php echo e($errors->first('birthday')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Age</label>
                                        <input type="text" name="age" id="age" class="form-control" value="<?php echo e($patient->age); ?>" 
                                        placeholder="Age" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Sex</label>
                                        <select class="form-control select" name="sex">
                                            <option value="">Select Sex</option>
                                            <option value="M" <?php if($patient->sex == 'M'): ?> selected <?php endif; ?> >Male</option>
                                            <option value="F" <?php if($patient->sex == 'F'): ?> selected <?php endif; ?> >Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Civil Status</label>
                                        <select class="form-control select" name="civil_status">
                                            <option value="">Select Civil Status</option>
                                            <option <?php if($patient->civil_status == 'Single'): ?> selected <?php endif; ?> >
                                                Single
                                            </option>
                                            <option <?php if($patient->civil_status == 'Married'): ?> selected <?php endif; ?> >
                                                Married
                                            </option>
                                            <option <?php if($patient->civil_status == 'Common Law'): ?> selected <?php endif; ?> >
                                                Common Law
                                            </option>
                                            <option <?php if($patient->civil_status == 'Widow'): ?> selected <?php endif; ?> >
                                                Widow
                                            </option>
                                            <option <?php if($patient->civil_status == 'Separated-Legal'): ?> selected <?php endif; ?> >
                                                Separated-Legal
                                            </option>
                                            <option <?php if($patient->civil_status == 'Separated-InFact'): ?> selected <?php endif; ?> >
                                                Separated-InFact
                                            </option>
                                            <option <?php if($patient->civil_status == 'Divorce'): ?> selected <?php endif; ?> >
                                                Divorce
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group <?php if($errors->has('contact_no')): ?> has-error <?php endif; ?>">
                                        <label>Contact Number</label>
                                        <input type="text" name="contact_no" class="form-control" value="<?php echo e($patient->contact_no); ?>" 
                                        placeholder="Enter Contact Number" />
                                        <?php if($errors->has('contact_no')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('contact_no')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div><!-- second row -->
                            <?php if(Auth::user()->clinic != 54): ?>
                            <div class="row">
                                <div class="<?php if(Carbon::parse($patient->created_at)->format('m-d-Y') >= Carbon::parse()->now()->format('m-d-Y')): ?> 
                                                col-md-10
                                            <?php else: ?>
                                                col-md-12
                                            <?php endif; ?>">
                                    <div class="form-group">
                                        <label>Permanent Address</label>
                                        <input type="text" name="address" class="form-control" id="address" value="<?php echo e($patient->address); ?>" 
                                        placeholder="Please Enter Patient Address"  />
                                    </div>
                                </div>
                                <?php if(Carbon::parse($patient->created_at)->format('m-d-Y') >= Carbon::parse()->now()->format('m-d-Y')): ?>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Referral</label>
                                            <select name="referral" class="form-control select" id="referral">
                                                <option value="no" <?php if(!$referral): ?> selected <?php endif; ?>>NO</option>
                                                <option value="yes" <?php if($referral): ?> selected <?php endif; ?>>YES</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php else: ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Permanent Address</label>
                                        <input type="text" name="address" class="form-control" id="address" value="<?php echo e($patient->address); ?>" 
                                        placeholder="Please Enter Patient Address"  />
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php echo $__env->make('patients.address', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    </div>
                </div>
            </div>


            
            
            <?php if(Auth::user()->clinic != 54): ?>
            <?php echo $__env->make('triage.edit_triage_support', ['clinics' => $clinics, 'triage' => $triage, 'vital_signs' => $vital_signs], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>

        </form>
            

            <div class="container">
                <div class="form-group text-right">
                    <button type="submit" form="registerForm" class="btn btn-success">Update&nbsp; <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>

            <br><br>
            

        
    <?php $__env->stopSection(); ?>





    <?php $__env->startSection('footer'); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('pagescript'); ?>
        <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/patients/register.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/patients/address.js')); ?>"></script>

        <script src="<?php echo e(asset('public/AdminLTE/bower_components/select2/dist/js/select2.full.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/AdminLTE/dist/js/adminlte.min.js')); ?>"></script>


        <script>
            $(function () {
                //Initialize Select2 Elements
                $('.select2').select2();
            });
        </script>

        <?php if($errors->has('province') || $errors->has('region')): ?>
            <script>
                $("#addressModal").modal("show");
            </script>
        <?php endif; ?>
    <?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
