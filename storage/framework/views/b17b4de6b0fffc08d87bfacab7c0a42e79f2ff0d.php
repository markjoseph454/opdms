<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Childhood Care
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/nurse/pedia/children_care.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('nurse.pedia.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>


    <div class="loaderRefresh" style="position: fixed">
        <div class="loaderWaiting">
            <i class="fa fa-spinner fa-spin"></i>
            <span> Please Wait...</span>
        </div>
    </div>

    <div class="container" id="children_care">

        <form action="<?php echo e(url('save_early_childhood_care')); ?>" method="post" id="children_careForm">

            <?php echo e(csrf_field()); ?>



            <input type="hidden" name="patient_id" value="<?php echo e($patient->pid); ?>" />

            <div class="col-md-6 col-md-offset-3">


                <div class="row">
                    <div class="col-md-3">
                        <img src="<?php echo e(asset('public/images/doh-logo2.png')); ?>" class="img-responsive center-block" alt="">
                    </div>
                    <div class="col-md-6">
                        <h4 class="text-center">
                            <strong>EARLY CHILDHOOD CARE AND DEVELOPMENT FORM</strong>
                        </h4>
                    </div>
                    <div class="col-md-3">
                        <img src="<?php echo e(asset('public/images/sentrong_sigla.png')); ?>" class="img-responsive center-block img-circle" alt="">
                    </div>
                </div>

                <br>


                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td colspan="2">
                                Clinic:
                                <input type="text" name="clinic_name" value="Pedia" class="smallInput" />
                            </td>
                            <td colspan="3">
                                Childs No.:
                                <input type="text" name="child_no" value="<?php echo e($patient->hospital_no); ?>" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Barangay:
                                <input type="text" name="brgy"
                                       value="<?php echo e($patient->provDesc.' '.$patient->citymunDesc.' '.$patient->brgyDesc); ?>"
                                       class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Family No.:
                                <input type="text" name="family" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Childs Name
                                <input type="text" name="childs_name"
                                       value="<?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name); ?>"
                                       class="smallInput" />
                            </td>
                            <td>
                                Sex: &nbsp; &nbsp; &nbsp;
                                <label class="normalLabel">
                                    <input type="radio" name="sex" value="M"
                                           <?php if($patient->sex == 'M'): ?> checked <?php endif; ?>> M
                                </label>
                                &nbsp; &nbsp;
                                <label class="normalLabel">
                                    <input type="radio" name="sex" value="F"
                                           <?php if($patient->sex == 'F'): ?> checked <?php endif; ?>> F
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Mothers Name:
                                <input type="text" name="mother" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Educational Level:
                                <input type="text" name="education" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Occupation:
                                <input type="text" name="occupation" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Date First Seen:
                                <input type="date" name="date_first_seen" class="smallInput" />
                            </td>
                            <td>
                                Birth Date:
                                <input type="date" name="birth_date" value="<?php echo e($patient->birthday); ?>" class="smallInput" />
                            </td>
                            <td>
                                Birth Weight:
                                <input type="text" name="birth_weight" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Place of delivery:
                                <input type="text" name="place_of_delivery" class="smallInput" />
                            </td>
                            <td colspan="2">
                                Birth registered at local civil registry (date):
                                <input type="text" name="birth_registered" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Complete address of family (House No., Street, City/Province):
                                <input type="text" name="complete_address" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-center">BROTHERS AND SISTERS</th>
                        </tr>
                        <tr>
                            <td>Name:</td>
                            <td>Sex:</td>
                            <td>Date of Birth:</td>
                        </tr>
                        <?php for($i=0;$i<12;$i++): ?>
                            <tr>
                                <td>
                                    <input type="text" name="bro_sis<?php echo e($i); ?>" class="smallInput" />
                                </td>
                                <td class="text-center">
                                    <label class="normalLabel"><input type="radio" name="gender<?php echo e($i); ?>" value="M"> M</label>
                                    &nbsp; &nbsp; &nbsp; &nbsp;
                                    <label class="normalLabel"><input type="radio" name="gender<?php echo e($i); ?>" value="F"> F</label>
                                </td>
                                <td>
                                    <input type="date" name="date_birth<?php echo e($i); ?>" class="smallInput" />
                                </td>
                            </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>

                </div>



            </div>

            <div class="col-md-12">

                <div class="table-responsive">
                    <table class="table table-bordered" id="essentialHealthTable">
                        <tr>
                            <th colspan="7" class="text-center bg-info">ESSENTIAL HEALTH AND NUTRITION SERVICES</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="6" class="text-center">DATE OF VISITS</td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>1st</td>
                            <td>2nd</td>
                            <td>3rd</td>
                            <td>4th</td>
                            <td>5th</td>
                            <td>6th</td>
                        </tr>
                        <tr>
                            <th>NEWBORN_SCREENING</th>
                            <?php for($i=0;$i<6;$i++): ?>
                                <td <?php if($i>0): ?> class="stripedLine" <?php endif; ?>>
                                    <?php if($i<1): ?>
                                        <input type="date" name="newborn_screening" class="smallInput" />
                                    <?php endif; ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <th>BCG (at birth)</th>
                            <?php for($i=0;$i<6;$i++): ?>
                                <td <?php if($i>0): ?> class="stripedLine" <?php endif; ?>>
                                    <?php if($i<1): ?>
                                        <input type="date" name="bcg" class="smallInput" />
                                    <?php endif; ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <th>PV (6 wks, 10 wks, 14 wks old)</th>
                            <?php for($i=0;$i<6;$i++): ?>
                                <td <?php if($i>2): ?> class="stripedLine" <?php endif; ?>>
                                    <?php if($i<3): ?>
                                        <input type="date" name="pv<?php echo e($i); ?>" class="smallInput" />
                                    <?php endif; ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <th>OPV (6 wks, 10 wks, 14 wks old)</th>
                            <?php for($i=0;$i<6;$i++): ?>
                                <td <?php if($i>2): ?> class="stripedLine" <?php endif; ?>>
                                    <?php if($i<3): ?>
                                        <input type="date" name="opv<?php echo e($i); ?>" class="smallInput" />
                                    <?php endif; ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <th>HEPATITIS B (6 wks, 10 wks, 14 wks old)</th>
                            <?php for($i=0;$i<6;$i++): ?>
                                <td <?php if($i>0): ?> class="stripedLine" <?php endif; ?>>
                                    <?php if($i<1): ?>
                                        <input type="date" name="hepatitis" class="smallInput" />
                                    <?php endif; ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <th>MMR1</th>
                            <?php for($i=0;$i<6;$i++): ?>
                                <td <?php if($i>0): ?> class="stripedLine" <?php endif; ?>>
                                    <?php if($i<1): ?>
                                        <input type="date" name="mmr_one" class="smallInput" />
                                    <?php endif; ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <th>MMR2</th>
                            <?php for($i=0;$i<6;$i++): ?>
                                <td>
                                    <input type="date" name="mmr_two<?php echo e($i); ?>" class="smallInput" />
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <th>IPV</th>
                            <?php for($i=0;$i<6;$i++): ?>
                                <td>
                                    <input type="date" name="ipv<?php echo e($i); ?>" class="smallInput" />
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <th>
                                PCV
                            </th>
                            <?php for($i=0;$i<6;$i++): ?>
                                <td>
                                    <input type="date" name="pcv<?php echo e($i); ?>" class="smallInput" />
                                </td>
                            <?php endfor; ?>
                        </tr>

                    </table>

                </div>


                <div class="buttonWrapper">
                    <a href="#0" class="cd-top js-cd-top">Top</a>
                    <button type="submit" class="btn btn-success btnSaveEssential" title="Click to save">
                        <i class="fa fa-save"></i>
                    </button>
                </div>


            </div>


        </form>

    </div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>

    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/nurse/pedia/otpc.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/nurse/pedia/childhood_care.js')); ?>"></script>

    <?php echo $__env->make('receptions.message.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
