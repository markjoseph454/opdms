<?php $__env->startComponent('partials/header'); ?>

<?php $__env->slot('title'); ?>
OPD | KMC
<?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/nurse/pedia/kmc.css')); ?>" rel="stylesheet" />
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

    <div class="container">




        <div class="col-md-10 col-md-offset-1">



            <form action="<?php echo e(url('kmc_store')); ?>" method="post" id="kmc_form">

                <?php echo e(csrf_field()); ?>



                <input type="hidden" name="updatedKMC" value="<?php echo e($data->id); ?>" />

                <input type="hidden" name="patient_id" value="<?php echo e($data->patient_id); ?>" />

                <div class="table-responsive">

                    <h5 class="text-center"><strong>KMC (Kangaroo Mother Care Program)</strong></h5>

                    <table class="table table-bordered" id="kmc_table">
                        <tbody>
                        <tr>
                            <td>Baby's Name:
                                <input type="text" class="smallInput"
                                       value="<?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name); ?>" readonly style="width: 80%"/>
                            </td>
                            <td>KMC #:
                                <input type="text" name="kmc_no" value="<?php echo e($data->kmc_no); ?>" class="smallInput" style="width: 50%"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Mother's Name:
                                <input type="text" name="mother" value="<?php echo e($data->mother); ?>" class="smallInput" style="width: 80%"/>
                            </td>
                            <td>AOG:
                                <input type="text" name="aog" value="<?php echo e($data->aog); ?>" class="smallInput" style="width: 50%"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Address:
                                <input type="text" class="smallInput"
                                       value="<?php echo e($patient->provDesc.' '.$patient->citymunDesc.' '.$patient->brgyDesc); ?>"
                                       style="width: 80%" readonly/>
                            </td>
                            <td>Birth Weight:
                                <input type="text" class="smallInput" name="birth_weight" value="<?php echo e($data->birth_weight); ?>" style="width: 20%"/>
                                Discharge Weight:
                                <input type="text" class="smallInput" name="discharge_weight" value="<?php echo e($data->discharge_weight); ?>" style="width: 20%"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Birthday:
                                <input type="text" class="smallInput"
                                       value="<?php echo e(Carbon::parse($patient->birthday)->toFormattedDateString()); ?>" readonly style="width: 30%"/>
                            </td>
                            <td>Contact #:
                                <input type="text" name="contact_no" value="<?php echo e($data->contact_no); ?>" class="smallInput" style="width: 60%"/>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center titleHead" colspan="2">Follow-up</th>
                        </tr>
                        <tr>
                            <td>Date: <input type="date" class="smallInput" name="date_ff" value="<?php echo e($data->date_ff); ?>" style="width: 50%"/></td>
                            <td>Head Circumference: <input type="text" name="head_circumference" value="<?php echo e($data->head_circumference); ?>" class="smallInput" style="width: 20%"/> &nbsp;
                                Temperature: <input type="text" name="temperature" value="<?php echo e($data->temperature); ?>" class="smallInput" style="width: 20%"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Age: &nbsp;
                                <input type="text" name="month" class="smallInput" value="<?php echo e($data->month); ?>" placeholder="Month" style="width: 20%"/> Month.
                                <input type="text" name="week" class="smallInput" value="<?php echo e($data->week); ?>" placeholder="Week" style="width: 20%"/> Week.
                                <input type="text" name="days" class="smallInput" value="<?php echo e($data->days); ?>" placeholder="Days" style="width: 20%"/> Days.
                            </td>
                            <td>Corrected Age:
                                <input type="text" name="corrected_age" value="<?php echo e($data->corrected_age); ?>" class="smallInput" style="width: 50%"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Weight: <input type="text" name="weight" value="<?php echo e($data->weight); ?>" class="smallInput" style="width: 30%"/></td>
                            <td>Body Length/Height: <input type="text" name="body_length_height" value="<?php echo e($data->weight); ?>" class="smallInput" style="width: 30%"/></td>
                        </tr>
                        <tr>

                            <?php

                            $feed = ($data->feeding)? unserialize($data->feeding) : false;
                            $wayofadministration = ($data->way_of_administration)? unserialize($data->way_of_administration) : false;

                            ?>
                            <td>Feeding: <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="feed[]" value="Human Milk"
                                           <?php if($feed): ?> <?php if(in_array('Human Milk', $feed)): ?> checked="checked" <?php endif; ?> <?php endif; ?>>Human Milk
                                </label>
                                <label class="checkbox-inline"><input type="checkbox" name="feed[]" value="Mixed"
                                    <?php if($feed): ?> <?php if(in_array('Mixed', $feed)): ?> checked="checked" <?php endif; ?> <?php endif; ?>>Mixed
                                </label>
                                <label class="checkbox-inline"><input type="checkbox" name="feed[]" value="Formula Milk"
                                    <?php if($feed): ?> <?php if(in_array('Formula Milk', $feed)): ?> checked="checked" <?php endif; ?> <?php endif; ?>>Formula Milk
                                </label>
                            </td>
                            <td>Way of administration: <br/>
                                <label class="checkbox-inline"><input type="checkbox" name="wayofadministration[]" value="Breast"
                                    <?php if($wayofadministration): ?> <?php if(in_array('Breast', $wayofadministration)): ?> checked="checked" <?php endif; ?> <?php endif; ?>>Breast</label>
                                <label class="checkbox-inline"><input type="checkbox" name="wayofadministration[]" value="Bottle"
                                    <?php if($wayofadministration): ?> <?php if(in_array('Bottle', $wayofadministration)): ?> checked="checked" <?php endif; ?> <?php endif; ?>>Bottle</label>
                                <label class="checkbox-inline"><input type="checkbox" name="wayofadministration[]" value="Tube"
                                    <?php if($wayofadministration): ?> <?php if(in_array('Tube', $wayofadministration)): ?> checked="checked" <?php endif; ?> <?php endif; ?>>Tube</label>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center titleHead" colspan="2">Clinical DX</th>
                        </tr>
                        <tr>
                            <?php



                                if($data->condition_of_baby){
                                    $conditionOfBaby = ($data->condition_of_baby == 'Not Well')? true : false;
                                }else{
                                    $conditionOfBaby = false;
                                }
                                $not_well = ($data->not_well)? unserialize($data->not_well) : false;


                            ?>
                            <td><label><input type="radio" name="condition_of_baby" value="Well Baby"
                                    <?php if($data->condition_of_baby == 'Well Baby'): ?> checked="checked" <?php endif; ?>/> Well Baby</label>
                                </td>
                            <td class="notwell">
                                <label><input type="radio" name="condition_of_baby" value="Not Well"
                                    <?php if($conditionOfBaby): ?> checked="checked" <?php endif; ?>/> Not Well</label>
                                <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox"
                                           <?php if($conditionOfBaby): ?>
                                                 <?php if($not_well): ?>
                                                       <?php if(in_array('Infectious Diseases', $not_well)): ?> checked="checked" <?php endif; ?>
                                                 <?php endif; ?>
                                           <?php else: ?>
                                                 disabled
                                           <?php endif; ?>
                                           name="notwell[]" value="Infectious Diseases">Infectious Diseases</label>
                                <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox"
                                            <?php if($conditionOfBaby): ?>
                                                <?php if($not_well): ?>
                                                    <?php if(in_array('Aspiration Pneumonia', $not_well)): ?> checked="checked" <?php endif; ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                disabled
                                            <?php endif; ?> name="notwell[]" value="Aspiration Pneumonia">
                                    Aspiration Pneumonia
                                </label>
                                <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox"
                                    <?php if($conditionOfBaby): ?>
                                        <?php if($not_well): ?>
                                            <?php if(in_array('Anemia', $not_well)): ?> checked="checked" <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        disabled
                                    <?php endif; ?> name="notwell[]" value="Anemia">
                                    Anemia
                                </label>
                                <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox"
                                    <?php if($conditionOfBaby): ?>
                                        <?php if($not_well): ?>
                                            <?php if(in_array('Hypoglycemia', $not_well)): ?> checked="checked" <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        disabled
                                    <?php endif; ?> name="notwell[]" value="Hypoglycemia">Hypoglycemia
                                </label>
                                <br/>
                                <label class="checkbox-inline"><input type="checkbox"
                                    <?php if($conditionOfBaby): ?>
                                        <?php if($not_well): ?>
                                            <?php if(in_array('Failure to thrive', $not_well)): ?> checked="checked" <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        disabled
                                    <?php endif; ?> name="notwell[]" value="Failure to thrive">Failure to thrive</label>
                                <br/>
                                <label class="checkbox-inline"><input type="checkbox"
                                    <?php if($conditionOfBaby): ?>
                                        <?php if($not_well): ?>
                                            <?php if(in_array('Hemorrhagic illness', $not_well)): ?> checked="checked" <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        disabled
                                    <?php endif; ?> name="notwell[]" value="Hemorrhagic illness">Hemorrhagic illness</label>
                                <br/>
                                <label class="checkbox-inline"><input type="checkbox"
                                    <?php if($conditionOfBaby): ?>
                                        <?php if($not_well): ?>
                                            <?php if(in_array('Others', $not_well)): ?> checked="checked" <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        disabled
                                    <?php endif; ?> name="notwell[]" value="Others">Others:</label>
                                <input type="text" class="smallInput"
                                <?php if($conditionOfBaby): ?>
                                    <?php if($not_well): ?>
                                        <?php if(in_array('Others', $not_well)): ?>
                                            value="<?php echo e($data->not_well_others); ?>"
                                        <?php else: ?>
                                            disabled
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    disabled
                                <?php endif; ?>
                                 name="not_well_others" style="width: 50%"/>
                            </td>
                        </tr>
                        <tr>
                            <?php



                                $neurological = ($data->neuro)? unserialize($data->neuro) : false;
                                $chronic = ($data->chronic_pathology)? unserialize($data->chronic_pathology) : false;


                            ?>
                            <td class="notwell"><strong>Neurological Status:</strong> <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="neurological[]"
                                        <?php if($neurological): ?> <?php if(in_array('Hypertania', $neurological)): ?> checked="checked" <?php endif; ?> <?php endif; ?>
                                           value="Hypertania">Hypertania
                                </label> <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="neurological[]"
                                        <?php if($neurological): ?> <?php if(in_array('Hypotania', $neurological)): ?> checked="checked" <?php endif; ?> <?php endif; ?>
                                           value="Hypotania">Hypotania
                                </label> <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="neurological[]"
                                        <?php if($neurological): ?> <?php if(in_array('Dystonia', $neurological)): ?> checked="checked" <?php endif; ?> <?php endif; ?>
                                           value="Dystonia">Dystonia
                                </label> <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="neurological[]"
                                        <?php if($neurological): ?> <?php if(in_array('Normal', $neurological)): ?> checked="checked" <?php endif; ?> <?php endif; ?>
                                           value="Normal">Normal
                                    </label> <br/>
                            </td>
                            <td class="notwell"><strong>Ongoing Chronic Pathology:</strong> <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="chronicpathology[]"
                                        <?php if($chronic): ?> <?php if(in_array('Respiratory', $chronic)): ?> checked="checked" <?php endif; ?> <?php endif; ?>
                                           value="Respiratory">Respiratory
                                </label> <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="chronicpathology[]"
                                        <?php if($chronic): ?> <?php if(in_array('Neurological', $chronic)): ?> checked="checked" <?php endif; ?> <?php endif; ?>
                                           value="Neurological">Neurological
                                </label> <br/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Prescription:
                                <textarea id="" cols="30" rows="5" style="font-size: 12px" name="prescription"
                                          placeholder="Type your prescription here..." class="form-control"><?php echo e($data->prescription); ?></textarea>
                            </td>
                        </tr>
                        </tbody>
                    </table>


                    <div class="buttonWrapper">
                        <a href="#0" class="cd-top js-cd-top">Top</a>
                        <?php if(Auth::user()->clinic == 26): ?>
                            <button type="submit" class="btn btn-success btnSave" title="Click to save">
                                <i class="fa fa-save"></i>
                            </button>
                        <?php endif; ?>
                    </div>

                </div>

            </form>

        </div>

    </div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>

    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/nurse/pedia/kmc.js')); ?>"></script>

    <?php echo $__env->make('receptions.message.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
