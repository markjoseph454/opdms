<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Register
    <?php $__env->endSlot(); ?>

    <?php $__env->startSection('pagestyle'); ?>

        <link rel="stylesheet" href="<?php echo e(asset('public/AdminLTE/bower_components/select2/dist/css/select2.min.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('public/AdminLTE/dist/css/AdminLTE.min.css')); ?>"> <!-- Theme style -->

        <link href="<?php echo e(asset('public/css/doctors/patientlist.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/plugins/css/jquery-ui.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/css/patients/register.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/css/patients/address.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/css/patients/referral.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/css/triage/triage_support.css')); ?>" rel="stylesheet" />
         <link href="<?php echo e(asset('public/css/patients/search.css')); ?>" rel="stylesheet" />
         <style>
            .camera{
                background-color: #ccc;
                padding: 15px;
                margin: 15px;
                border-radius: 5px;
            }
             .camera i{
                font-size: 80px;
             }
         </style>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('header'); ?>
        <?php echo $__env->make('patients/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>
        <form action="<?php echo e(url('patients')); ?>" method="post" id="registerForm" enctype="multipart/form-data">
            <div class="container">
                <div class="col-md-12">
                    <div class="row">
                        <h3 class="text-center">PATIENT REGISTRATION FORM</h3>
                        <br/>

                            <?php echo $__env->make('message.msg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <?php echo $__env->make('message.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <?php echo e(csrf_field()); ?>


                            <div class="row">
                                <div class="row col-md-12 " style="margin-top: -10px;">
                                    <div class="col-md-9 text-center">
                                        <label class="error_msg" hidden style="color: red">Data in Lastname and Firstname are required </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group <?php if($errors->has('last_name')): ?> has-error <?php endif; ?>">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control names" value="<?php echo e(old('last_name')); ?>" placeholder="Enter Last Name" autofocus />
                                        <input type="hidden" name="users_id" value="<?php echo e(Auth::user()->id); ?>"/>
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
                                        <div class="input-group">
                                            <input type="text" name="first_name" id="first_name" class="form-control names" value="<?php echo e(old('first_name')); ?>" placeholder="Enter First Name" />
                                            <span class="input-group-addon fa fa-search" id="search-button" 
                                                style="background-color: rgb(68, 157, 68);
                                                        border: 1px solid rgb(57, 132, 57);
                                                        color: #fff;
                                                        cursor: pointer;
                                                "></span>
                                        </div>
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
                                        <input type="text" name="middle_name" id="middle_name" class="form-control names" value="<?php echo e(old('middle_name')); ?>" placeholder="Enter Middle Name" required />
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Suffix</label>
                                        <select class="form-control select" name="suffix">
                                            <option value="">--</option>
                                            <option <?php if(old('suffix') == 'Jr'): ?> selected <?php endif; ?> >Jr</option>
                                            <option <?php if(old('suffix') == 'Sr'): ?> selected <?php endif; ?> >Sr</option>
                                            <option <?php if(old('suffix') == 'Sra'): ?> selected <?php endif; ?> >Sra</option>
                                            <option <?php if(old('suffix') == 'II'): ?> selected <?php endif; ?> >II</option>
                                            <option <?php if(old('suffix') == 'III'): ?> selected <?php endif; ?> >III</option>
                                            <option <?php if(old('suffix') == 'IV'): ?> selected <?php endif; ?> >IV</option>
                                            <option <?php if(old('suffix') == 'V'): ?> selected <?php endif; ?> >V</option>
                                            <option <?php if(old('suffix') == 'VI'): ?> selected <?php endif; ?> >VI</option>
                                        </select>
                                    </div>
                                </div>

                            </div><!-- first row -->

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group <?php if($errors->has('birthday')): ?> has-error <?php endif; ?>">
                                        <label>Birthday</label>
                                        <input type="text" name="birthday" class="form-control birthday" id="datepicker" value="<?php echo e(old('birthday')); ?>" 
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
                                        <input type="text" name="age" id="age" class="form-control" value="<?php echo e(old('age')); ?>" placeholder="Age" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Sex</label>
                                        <select class="form-control select" name="sex">
                                            <option value="">Select Sex</option>
                                            <option value="M" <?php if(old('sex') == 'Male'): ?> selected <?php endif; ?> >Male</option>
                                            <option value="F" <?php if(old('sex') == 'Female'): ?> selected <?php endif; ?> >Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Civil Status</label>
                                        <select class="form-control select" name="civil_status">
                                            <option value="">Select Civil Status</option>
                                            <option <?php if(old('civil_status') == "New Born"): ?> selected <?php endif; ?> >New Born</option>
                                            <option <?php if(old('civil_status') == 'Child'): ?> selected <?php endif; ?> >Child</option>
                                            <option <?php if(old('civil_status') == 'Single'): ?> selected <?php endif; ?> >Single</option>
                                            <option <?php if(old('civil_status') == 'Married'): ?> selected <?php endif; ?> >Married</option>
                                            <option <?php if(old('civil_status') == 'Common Law'): ?> selected <?php endif; ?> >Common Law</option>
                                            <option <?php if(old('civil_status') == 'Widow'): ?> selected <?php endif; ?> >Widow</option>
                                            <option <?php if(old('civil_status') == 'Separated-Legal'): ?> selected <?php endif; ?> >Separated-Legal</option>
                                            <option <?php if(old('civil_status') == 'Separated-InFact'): ?> selected <?php endif; ?> >Separated-InFact</option>
                                            <option <?php if(old('civil_status') == 'Divorce'): ?> selected <?php endif; ?> >Divorce</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group <?php if($errors->has('contact_no')): ?> has-error <?php endif; ?>">
                                        <label>Contact Number</label>
                                        <input type="text" name="contact_no" class="form-control" value="<?php echo e(old('contact_no')); ?>" 
                                        placeholder="Enter Contact Number" />
                                        <?php if($errors->has('contact_no')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('contact_no')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div><!-- second row -->

                            <div class="row">
                                <div class="<?php echo e((Auth::user()->clinic != 54)? 'col-md-10' : 'col-md-12'); ?>">
                                    <div class="form-group">
                                        <label>Permanent Address</label>
                                        <input type="text" name="address" class="form-control" id="address" value="<?php echo e(old('address')); ?>" 
                                        placeholder="Please Enter Patient Address"  />
                                    </div>
                                </div>


                                <?php if(Auth::user()->clinic != 54): ?>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Referral</label>
                                        <select name="referral" class="form-control select" id="referral">
                                            <option value="no">NO</option>
                                            <option value="yes">YES</option>
                                        </select>
                                    </div>
                                </div>

                                <?php endif; ?>


                            </div>




                              <!--   <div class="camera col-md-2 bg-danger text-center">
                                    <i class="fa fa-camera"></i>
                                </div>
                                <div class="camera col-md-2 bg-info text-center">
                                    <i class="fa fa-hand-pointer-o"></i>
                                </div>
                             -->

                            <?php echo $__env->make('patients.address', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <?php echo $__env->make('patients.referrals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php echo $__env->make('patients.search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



                            <div class="form-group profileWrapper">
                                <label class="btn btn-file text"
                                       title="Click to upload patient profile">
                                    Upload Patient Profile
                                    <i class="fa fa-user-circle-o"></i>
                                    <input type="file" name="profile" style="display: none;">
                                </label>
                            </div>


                            
                            



                    </div>
                </div>
            </div>


            <?php if(Auth::user()->clinic != 54): ?>
                <?php echo $__env->make('triage.triage_support', ['clinics' => $clinics], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>

        </form>
            

            <div class="container">
                <div class="form-group text-right">
                    <!-- <button type="button" class="btn btn-success btn-md" id="search-button"> Search&nbsp; <i class="fa fa-search"></i></button> -->
                    <button type="submit" form="registerForm" class="btn btn-success">Submit&nbsp; <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>

            <br><br>
            

        
    <?php $__env->stopSection(); ?>





    <?php $__env->startSection('footer'); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('pagescript'); ?>
        
        <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php if($errors->has('barcode')): ?>
            <script>
                toastr.error("<?php echo e($errors->first('barcode')); ?>");

            </script>
        <?php elseif($errors->has('hospital_no')): ?>
            <script>
                toastr.error("<?php echo e($errors->first('hospital_no')); ?>");
            </script>
        <?php endif; ?>
        <script src="<?php echo e(asset('public/plugins/js/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/patients/register.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/patients/address.js')); ?>"></script>
        <!-- <script src="<?php echo e(asset('public/js/patients/referral.js')); ?>"></script> -->
        <script src="<?php echo e(asset('public/js/patients/search.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/doctors/ajaxRecords.js')); ?>"></script>


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
