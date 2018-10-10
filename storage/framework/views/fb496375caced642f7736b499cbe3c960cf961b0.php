<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | OTPC Front Edit
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/css/nurse/pedia/otpc_front.css')); ?>" rel="stylesheet" />
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




        <form action="<?php echo e(url('otpc_save')); ?>" method="post" id="otpc_submit">

            <input type="hidden" name="updateOTPC" value="<?php echo e($data->id); ?>" />

            <?php echo e(csrf_field()); ?>


            <div class="table-responsive" id="otpc_front_table_div">

                <h5 class="text-center"><strong>OTC Chart</strong></h5>
                <h5 class="text-center"><strong>ADMISSION DETAILS: OUT PATIENT THERAPEUTIC CARE (FRONT)</strong></h5>

                <span class="text-info">Instructions:</span>
                <small>
                    <em class="text-info">
                        Please fill up needed details and encircle appropriate text or values based on history taking and physical examination
                    </em>
                </small>
                <br>
                <table class="table table-bordered table-condensed">
                    <tbody>
                    <tr>
                        <td><label>Name</label></td>
                        <td colspan="3">
                            <input type="text" class="smallInput" style="width: 100%"
                                   value="<?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name); ?>"
                                   required readonly>
                        </td>
                        <td><label>Reg. No</label></td>
                        <td colspan="3">
                            <input type="text" class="smallInput" style="width: 100%"
                                   value="<?php echo e($patient->hospital_no); ?>" required readonly>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Municipality</label></td>
                        <td colspan="3">
                            <input type="text" class="smallInput" style="width: 100%"
                                   value="<?php echo e($patient->citymunDesc); ?>" required readonly>
                        </td>
                        <td><label>Barangay</label></td>
                        <td colspan="3">
                            <input type="text" class="smallInput" style="width: 100%"
                                   value="<?php echo e($patient->brgyDesc); ?>" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Age (months)</label>
                            <input type="text" class="smallInput" value="<?php echo e($data->age_months); ?>" style="width: 60%" name="age_months">
                        </td>
                        <td colspan="2">
                            <label>Sex</label>
                            &nbsp; &nbsp; &nbsp;
                            <label class="normalLabel"><input type="radio" disabled <?php if($patient->sex == 'M'): ?> checked <?php endif; ?>> M</label>
                            <label class="normalLabel"><input type="radio" disabled <?php if($patient->sex == 'F'): ?> checked <?php endif; ?>> F</label>
                        </td>
                        <td colspan="4">
                            <label>Date of Admission </label>
                            <input type="date" name="date_of_admission" value="<?php echo e($data->date_of_admission); ?>" class="smallInput" style="width: 60%">
                        </td>
                    </tr>
                    <tr>
                        <td><label>Admission Status</label></td>
                        <td colspan="7" class="admissionStatus">
                            <em>Screened by Nurse/MD</em>
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                            <label class="normalLabel"><input type="radio" name="admission_status" value="Walk-in"
                                                              <?php if($data->admission_status == 'Walk-in'): ?> checked <?php endif; ?>> Walk-in</label>
                            <label class="normalLabel"><input type="radio" name="admission_status" value="From IC"
                                                              <?php if($data->admission_status == 'From IC'): ?> checked <?php endif; ?>> From IC</label>
                            <label class="normalLabel"><input type="radio" name="admission_status" value="From SFP"
                                                              <?php if($data->admission_status == 'From SFP'): ?> checked <?php endif; ?>> From SFP</label>
                            <label class="normalLabel"><input type="radio" name="admission_status" value="From other OC"
                                                              <?php if($data->admission_status == 'From other OC'): ?> checked <?php endif; ?>> From other OC</label>
                            <label class="normalLabel"><input type="radio" name="admission_status" value="Readmission (Relapse)"
                                                              <?php if($data->admission_status == 'Readmission (Relapse)'): ?> checked <?php endif; ?>> Readmission (Relapse)</label>
                            <label class="normalLabel"><input type="radio" name="admission_status" value="ITC Refusal"
                                                              <?php if($data->admission_status == 'ITC Refusal'): ?> checked <?php endif; ?>> ITC Refusal</label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Total Number in Household</label></td>
                        <td>
                            #Adults
                            <input type="number" class="smallInput" name="adults" value="<?php echo e($data->adults); ?>">
                        </td>
                        <td>
                            #Children
                            <input type="number" class="smallInput" name="children" value="<?php echo e($data->children); ?>">
                        </td>
                        <td><label>Twin</label></td>
                        <td>
                            <label class="normalLabel"><input type="radio" name="twin" value="1"
                                                              <?php if($data->twin == 1): ?> checked <?php endif; ?>> Yes</label>
                            &nbsp; &nbsp;
                            <label class="normalLabel"><input type="radio" name="twin" value="0"
                                                              <?php if($data->twin == '0'): ?> checked <?php endif; ?>> No</label>
                        </td>
                        <td>
                            <label>Distance to home (hrs)</label>
                            <input type="text" name="distance_to_home" class="smallInput" value="<?php echo e($data->distance_to_home); ?>" style="width: 150px">
                        </td>
                        <td><label>4Ps Beneficiary?</label></td>
                        <td>
                            <label class="normappetite_test_dayalLabel">
                                <input type="radio" name="four_ps" <?php if($data->four_ps == 1): ?> checked <?php endif; ?> value="1"> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="four_ps" <?php if($data->four_ps == '0'): ?> checked <?php endif; ?> value="0"> No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="8" class="text-center bg-primary">Admission Anthropometry</th>
                    </tr>
                    <tr>
                        <td>
                            <label>MUAC(cm): </label>
                            <input type="text" class="smallInput" name="muac_front" value="<?php echo e($data->muac_front); ?>">
                        </td>
                        <td colspan="2">
                            <input type="text" class="smallInput" value="<?php echo e($data->weight); ?>" name="weight">
                            Weight (kg)
                        </td>
                        <td colspan="2">
                            <input type="text" class="smallInput" value="<?php echo e($data->height); ?>" name="height">
                            Height (cm)
                        </td>
                        <td colspan="3">
                            <input type="text" name="whz_score" value="<?php echo e($data->whz_score); ?>" class="smallInput">
                            WHZ score
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Admission Criteria (encircle all apllicable)</label>
                        </td>
                        <td>
                            <label class="normalLabel">Edema</label>
                            <input type="text" class="smallInput" name="edemaAdmission" value="<?php echo e($data->edemaAdmission); ?>" style="width: 100%">
                        </td>
                        <td>
                            <label class="normalLabel">
                                <input type="radio" name="admission_criteria" class="opposeOthers" value="MUAC < 11.5 cm"
                                       <?php if($data->admission_criteria == 'MUAC < 11.5 cm'): ?> checked <?php endif; ?>> MUAC < 11.5 cm
                            </label>
                        </td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="admission_criteria" class="opposeOthers" value="WHZ <- 3<"
                                       <?php if($data->admission_criteria == 'WHZ <- 3<'): ?> checked <?php endif; ?>> WHZ <- 3
                            </label>
                        </td>
                        <td>
                            <label class="normalLabel">
                                <input type="radio" name="admission_criteria" class="thisOther" value="other"
                                       <?php if($data->admission_criteria == 'other'): ?> checked <?php endif; ?>> Other (specify)
                            </label>
                        </td>
                        <td colspan="2">
                            <input type="text" name="other_description" class="smallInput enableOtherField"
                                   <?php if($data->admission_criteria != 'other'): ?> disabled <?php endif; ?>
                                   style="width: 100%"
                                   value="<?php echo e($data->other_description); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th colspan="8" class="text-center bg-primary">History</th>
                    </tr>
                    <tr>
                        <td>
                            <label>IMCI Danger Signs</label>
                        </td>
                        <td>
                            <label>Able to drink or breastfeed?</label> &nbsp; &nbsp; &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="breastfeed_or_drink" value="1"
                                       <?php if($data->breastfeed_or_drink == 1): ?> checked <?php endif; ?>> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="breastfeed_or_drink" value="0"
                                       <?php if($data->breastfeed_or_drink == '0'): ?> checked <?php endif; ?>> No
                            </label>
                        </td>
                        <td colspan="2">
                            <label>Does the Child Vomit Everything?</label>
                            &nbsp; &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="vomit" value="1"
                                       <?php if($data->vomit == 1): ?> checked <?php endif; ?>> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="vomit" value="0"
                                       <?php if($data->vomit == '0'): ?> checked <?php endif; ?>> No
                            </label>
                        </td>
                        <td colspan="2">
                            <label>Has the child convulsion?</label>
                            &nbsp; &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="convulsion" value="1"
                                       <?php if($data->convulsion == 1): ?> checked <?php endif; ?>> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="convulsion" value="0"
                                       <?php if($data->convulsion == '0'): ?> checked <?php endif; ?>> No
                            </label>
                        </td>
                        <td colspan="2">
                            <label>Is child lethargic / unconscious</label>
                            &nbsp; &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="lethargic_unconscious" value="1"
                                       <?php if($data->lethargic_unconscious == 1): ?> checked <?php endif; ?>> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="lethargic_unconscious" value="0"
                                       <?php if($data->lethargic_unconscious == '0'): ?> checked <?php endif; ?>> No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Diarrhea</label></td>
                        <td>
                            <label class="normalLabel">
                                <input type="radio" name="diarrhea" value="1"
                                       <?php if($data->diarrhea == 1): ?> checked <?php endif; ?>> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="diarrhea" value="0"
                                       <?php if($data->diarrhea == '0'): ?> checked <?php endif; ?>> No
                            </label>
                        </td>
                        <td><label>Stools / Day</label></td>
                        <td colspan="5">
                            <label class="normalLabel">
                                <input type="radio" name="stools_day" value="1-3"
                                       <?php if($data->stools_day == "1-3"): ?> checked <?php endif; ?>> 1-3
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="stools_day" value="4-5"
                                       <?php if($data->stools_day == "4-5"): ?> checked <?php endif; ?>> 4-5
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="stools_day" value=">5"
                                       <?php if($data->stools_day == ">5"): ?> checked <?php endif; ?>> >5
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Vomiting</label></td>
                        <td>
                            <label class="normalLabel">
                                <input type="radio" name="vomiting" value="1"
                                       <?php if($data->vomiting == 1): ?> checked <?php endif; ?>> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="vomiting" value="0"
                                       <?php if($data->vomiting == '0'): ?> checked <?php endif; ?>> No
                            </label>
                        </td>
                        <td rowspan="2">
                            <label>Frequency</label>
                            <input type="text" name="frequency" value="<?php echo e($data->frequency); ?>" class="smallInput" style="width: 100%">
                        </td>
                        <td colspan="3"><label>Passing Urine</label></td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="passing_urine" value="1"
                                       <?php if($data->passing_urine == 1): ?> checked <?php endif; ?>> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="passing_urine" value="0"
                                       <?php if($data->passing_urine == '0'): ?> checked <?php endif; ?>> No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Cough</label></td>
                        <td>
                            <label class="normalLabel">
                                <input type="radio" name="cough" value="1"
                                       <?php if($data->cough == 1): ?> checked <?php endif; ?>> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="cough" value="0"
                                       <?php if($data->cough == '0'): ?> checked <?php endif; ?>> No
                            </label>
                        </td>
                        <td colspan="3">
                            <label>If edema, how long swollen?</label>
                        </td>
                        <td colspan="2">
                            <input type="text" name="how_long_swollen" value="<?php echo e($data->how_long_swollen); ?>" class="smallInput" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Appetite at home?</label>
                        </td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="appetite_at_home" value="good"
                                       <?php if($data->appetite_at_home == 'good'): ?> checked <?php endif; ?>> Good
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="appetite_at_home" value="poor"
                                       <?php if($data->appetite_at_home == 'poor'): ?> checked <?php endif; ?>> Poor
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="appetite_at_home" value="none"
                                       <?php if($data->appetite_at_home == 'none'): ?> checked <?php endif; ?>> None
                            </label>
                        </td>
                        <td colspan="3"><label>Breastfeeding</label></td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="breastfeeding" value="1"
                                       <?php if($data->breastfeeding == 1): ?> checked <?php endif; ?>> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="breastfeeding" value="0"
                                       <?php if($data->breastfeeding == '0'): ?> checked <?php endif; ?>> No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Reported Problems</label></td>
                        <td>
                            <input type="text" name="reported_problems" value="<?php echo e($data->reported_problems); ?>"
                                   class="smallInput" style="width: 100%">
                        </td>
                        <td>
                            <label>Other Medical Problems</label>
                        </td>
                        <td colspan="5">
                            <label class="normalLabel">
                                <input type="radio" name="other_med_problems" class="opposeOthers" value="Tuberculosis"
                                       <?php if($data->other_med_problems == 'Tuberculosis'): ?> checked <?php endif; ?>> Tuberculosis
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="other_med_problems" class="opposeOthers" value="Malaria"
                                       <?php if($data->other_med_problems == "Malaria"): ?> checked <?php endif; ?>> Malaria
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="other_med_problems" class="opposeOthers" value="Congenital anomalies"
                                       <?php if($data->other_med_problems == "Congenital anomalies"): ?> checked <?php endif; ?>> Congenital anomalies
                            </label>
                            &nbsp; &nbsp; <br>
                            <label class="normalLabel">
                                <input type="radio" name="other_med_problems" class="thisOther" value="Others"
                                       <?php if($data->other_med_problems == "Others"): ?> checked <?php endif; ?>> Others
                            </label>
                            <input type="text" name="other_medical_problems" value="<?php echo e($data->other_medical_problems); ?>"
                                   class="smallInput enableOtherField" style="width: 60%"
                                   <?php if($data->other_med_problems != "Others"): ?> disabled <?php endif; ?>/>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center bg-primary" colspan="8">Physical Examination</th>
                    </tr>
                    <tr>
                        <td>
                            <label>Respiration Rate (#min)</label>
                        </td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="respiration_rate" value="<30"
                                       <?php if($data->respiration_rate == "<30"): ?> checked <?php endif; ?>> <30
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="respiration_rate" value="30-39"
                                       <?php if($data->respiration_rate == "30-39"): ?> checked <?php endif; ?>> 30-39
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="respiration_rate" value="40-49"
                                       <?php if($data->respiration_rate == "40-49"): ?> checked <?php endif; ?>> 40-49
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="respiration_rate" value="50+"
                                       <?php if($data->respiration_rate == "50+"): ?> checked <?php endif; ?>> 50+
                            </label>
                        </td>
                        <td>
                            <label>Edema</label>
                        </td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="edema" value="+"
                                       <?php if($data->edema == "+"): ?> checked <?php endif; ?>>+
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="edema" value="++"
                                       <?php if($data->edema == "++"): ?> checked <?php endif; ?>> ++
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="edema" value="+++"
                                       <?php if($data->edema == "+++"): ?> checked <?php endif; ?>> +++
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Temperature (C)</label>
                        </td>
                        <td colspan="3">
                            <input type="text" name="temperature" value="<?php echo e($data->temperature); ?>"
                                   class="smallInput" style="width: 100%" />
                        </td>
                        <td colspan="2">
                            <label>Chest Retractions</label>
                        </td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="chest_retractions" value="1"
                                       <?php if($data->chest_retractions == 1): ?> checked <?php endif; ?>> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="chest_retractions" value="0"
                                       <?php if($data->chest_retractions == '0'): ?> checked <?php endif; ?>> No
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Eyes</label></td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="eyes" value="Normal"
                                       <?php if($data->eyes == "Normal"): ?> checked <?php endif; ?>>Normal
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="eyes" value="Sunken"
                                       <?php if($data->eyes == "Sunken"): ?> checked <?php endif; ?>> Sunken
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="eyes" value="Discharge"
                                       <?php if($data->eyes == "Discharge"): ?> checked <?php endif; ?>> Discharge
                            </label>
                        </td>
                        <td>
                            <label>Dehydration</label>
                        </td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="dehydration" value="None"
                                       <?php if($data->dehydration == "None"): ?> checked <?php endif; ?>> None
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="dehydration" value="Moderate"
                                       <?php if($data->dehydration == "Moderate"): ?> checked <?php endif; ?>> Moderate
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="dehydration" value="Severe"
                                       <?php if($data->dehydration == "Severe"): ?> checked <?php endif; ?>> Severe
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Conjuctiva</label></td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="conjuctiva" value="Normal"
                                       <?php if($data->conjuctiva == "Normal"): ?> checked <?php endif; ?>> Normal
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="conjuctiva" value="Pale"
                                       <?php if($data->conjuctiva == "Pale"): ?> checked <?php endif; ?>> Pale
                            </label>
                        </td>
                        <td><label>Mouth</label></td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="mouth" value="Normal"
                                       <?php if($data->mouth == "Normal"): ?> checked <?php endif; ?>> Normal
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="mouth" value="Sores"
                                       <?php if($data->mouth == "Sores"): ?> checked <?php endif; ?>> Sores
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="mouth" value="Candida"
                                       <?php if($data->mouth == "Candida"): ?> checked <?php endif; ?>> Candida
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Ears</label></td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="ears" value="Normal"
                                       <?php if($data->ears == "Normal"): ?> checked <?php endif; ?>> Normal
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="ears" value="Discharge"
                                       <?php if($data->ears == "Discharge"): ?> checked <?php endif; ?>> Discharge
                            </label>
                        </td>
                        <td>
                            <label>Disability</label>
                        </td>
                        <td colspan="3">
                            <label class="normalLabel">
                                <input type="radio" name="disability" value="1"
                                       <?php if($data->disability == 1): ?> checked <?php endif; ?>> Yes
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="disability" value="0"
                                       <?php if($data->disability == '0'): ?> checked <?php endif; ?>> No
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <td><label>Skin Changes</label></td>
                        <td colspan="4">
                            <label class="normalLabel">
                                <input type="radio" name="skin_changes" value="None"
                                       <?php if($data->skin_changes == "None"): ?> checked <?php endif; ?>> None
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="skin_changes" value="Scabies"
                                       <?php if($data->skin_changes == "Scabies"): ?> checked <?php endif; ?>> Scabies
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="skin_changes" value="Peeling"
                                       <?php if($data->skin_changes == "Peeling"): ?> checked <?php endif; ?>> Peeling
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="skin_changes" value="Ulcer/Abscesses"
                                       <?php if($data->skin_changes == "Ulcer/Abscesses"): ?> checked <?php endif; ?>> Ulcer/Abscesses
                            </label>
                        </td>
                        <td>
                            <label>Extremities</label>
                        </td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="extremities" value="Normal"
                                       <?php if($data->extremities == "Normal"): ?> checked <?php endif; ?>> Normal
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="extremities" value="Cold"
                                       <?php if($data->extremities == "Cold"): ?> checked <?php endif; ?>> Cold
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Appetite Test</label></td>
                        <td colspan="2">
                            <label class="normalLabel">
                                <input type="radio" name="appetite_test" value="Pass"
                                       <?php if($data->appetite_test == "Pass"): ?> checked <?php endif; ?>> Pass
                            </label>
                            &nbsp; &nbsp;
                            <label class="normalLabel">
                                <input type="radio" name="appetite_test" value="Fail"
                                       <?php if($data->appetite_test == "Fail"): ?> checked <?php endif; ?>> Fail
                            </label>
                        </td>
                        <td colspan="5">
                            NOTE: <em>If child failed appetite test, refer IMMEDIATELY TO ITC</em>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center bg-primary" colspan="8">Routine Admission Medication</th>
                    </tr>
                    <tr>
                        <td rowspan="5"><label>Admission</label>:</td>
                        <td colspan="2"><label>Drug</label></td>
                        <td colspan="2"><label>Date</label></td>
                        <td colspan="3"><label>Dosage</label></td>
                    </tr>
                    <tr>
                        <?php
                            $drugsFront = explode('^', $data->drugsFront);
                            $dateFront = explode('^', $data->dateFront);
                            $dosageFront = explode('^', $data->dosageFront);
                        ?>
                        <td colspan="2">
                            <input type="text" name="drug1" class="smallInput" style="width: 100%"
                            value="<?php echo e($drugsFront[0]); ?>" />
                        </td>
                        <td colspan="2">
                            <input type="date" value="<?php echo e($dateFront[0]); ?>" name="dateAdmission1" class="smallInput" style="width: 100%" />
                        </td>
                        <td colspan="3">
                            <input type="text" name="dosage1" value="<?php echo e($dosageFront[0]); ?>" class="smallInput" style="width: 100%" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" name="drug2" class="smallInput" style="width: 100%"
                                   value="<?php echo e($drugsFront[1]); ?>"/>
                        </td>
                        <td colspan="2">
                            <input type="date" value="<?php echo e($dateFront[1]); ?>" name="dateAdmission2" class="smallInput" style="width: 100%" />
                        </td>
                        <td colspan="3">
                            <input type="text" name="dosage2" value="<?php echo e($dosageFront[1]); ?>" class="smallInput" style="width: 100%" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" name="drug3" class="smallInput" style="width: 100%"
                                   value="<?php echo e($drugsFront[2]); ?>"/>
                        </td>
                        <td colspan="2">
                            <input type="date" value="<?php echo e($dateFront[2]); ?>" name="dateAdmission3" class="smallInput" style="width: 100%" />
                        </td>
                        <td colspan="3">
                            <input type="text" name="dosage3" value="<?php echo e($dosageFront[2]); ?>" class="smallInput" style="width: 100%" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" name="drug4" class="smallInput" style="width: 100%"
                                   value="<?php echo e($drugsFront[3]); ?>"/>
                        </td>
                        <td colspan="2">
                            <input type="date" value="<?php echo e($dateFront[3]); ?>" name="dateAdmission4" class="smallInput" style="width: 100%" />
                        </td>
                        <td colspan="3">
                            <input type="text" name="dosage4" value="<?php echo e($dosageFront[3]); ?>" class="smallInput" style="width: 100%" />
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>


            <hr>


            <div class="table-responsive" id="otpc_back_table_div">
                <h5 class="text-center"><strong>FOLLOW UP: OUTPATIENT THERAPEUTIC CARE (BACK)</strong></h5>
                <table class="table table-bordered">
                    <tr>
                        <td colspan="9">
                            <label>Name:</label>
                            <input type="text" class="smallInput" style="width: 90%"
                                   value="<?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name); ?>"
                                   readonly/>
                        </td>
                        <td colspan="9">
                            <label>Registration Number:</label>
                            <input type="text" name="registrationNumber" class="smallInput"
                                   value="<?php echo e($patient->hospital_no); ?>" style="width: 70%"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Week</label>
                        </td>
                        <td>ADM</td>
                        <?php for($i=2;$i<18;$i++): ?>
                            <td><?php echo e($i); ?></td>
                        <?php endfor; ?>
                    </tr>

                    
                    <?php
                        $date = array_map('removeAsterisk', explode('^', $data->date));
                        $weightKG = array_map('removeAsterisk', explode('^', $data->weightKG));
                        $weightLoss = array_map('removeAsterisk', explode('^', $data->weightLoss));
                        $muac = array_map('removeAsterisk', explode('^', $data->muac));
                        $edemaBack = array_map('removeAsterisk', explode('^', $data->edemaBack));
                        $length_height = array_map('removeAsterisk', explode('^', $data->length_height));
                        $whz = array_map('removeAsterisk', explode('^', $data->whz));
                        $diarrheaDays = array_map('removeAsterisk', explode('^', $data->diarrheaDays));
                        $vomiting_days = array_map('removeAsterisk', explode('^', $data->vomiting_days));
                        $fever_days = array_map('removeAsterisk', explode('^', $data->fever_days));
                        $cough_days = array_map('removeAsterisk', explode('^', $data->cough_days));
                        $temperatureDays = array_map('removeAsterisk', explode('^', $data->temperatureDays));
                        $respirationRate = array_map('removeAsterisk', explode('^', $data->respirationRate));
                        $dehydrated = array_map('removeAsterisk', explode('^', $data->dehydrated));
                        $anemia = array_map('removeAsterisk', explode('^', $data->anemia));
                        $skin_infection = array_map('removeAsterisk', explode('^', $data->skin_infection));
                        $appetite_test_day = array_map('removeAsterisk', explode('^', $data->appetite_test_day));
                        $action_needed = array_map('removeAsterisk', explode('^', $data->action_needed));
                        $appetite_test_pass_fail = array_map('removeAsterisk', explode('^', $data->appetite_test_pass_fail));
                        $other_medication = array_map('removeAsterisk', explode('^', $data->other_medication));
                        $rutf = array_map('removeAsterisk', explode('^', $data->rutf));
                        $examiner = array_map('removeAsterisk', explode('^', $data->examiner));
                        $outcome = array_map('removeAsterisk', explode('^', $data->outcome));

                        function removeAsterisk($value){
                            if ($value == '*'){
                                return '';
                            }else{
                                return $value;
                            }
                        }
                    ?>


                    <tr>
                        <td><label>Date</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="date" name="date<?php echo e($i); ?>" value="<?php echo e($date[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <th colspan="18">Anthropometry</th>
                    </tr>
                    <tr>
                        <td><label>Weight (kg)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="weightKG<?php echo e($i); ?>" value="<?php echo e($weightKG[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Weight loss * (Y/N)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="weightLoss<?php echo e($i); ?>" value="<?php echo e($weightLoss[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>MUAC (cm)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="muac<?php echo e($i); ?>" value="<?php echo e($muac[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Edema (+ ++ +++)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="edemaBack<?php echo e($i); ?>" value="<?php echo e($edemaBack[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Length/Height</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="length_height<?php echo e($i); ?>" value="<?php echo e($length_height[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>WHZ</label></td>
                        <?php for($i=0;$i<10;$i++): ?>
                            <td>
                                <input type="text" name="whz<?php echo e($i); ?>" value="<?php echo e($whz[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td colspan="18">
                            * WEIGHT CHANGES MARASMICS: If below weight on week 3 refer for home visit. If no weight gain by week 5 refer to ITC.
                        </td>
                    </tr>
                    <tr>
                        <th colspan="18">History</th>
                    </tr>
                    <tr>
                        <td><label>Diarrhea (#days)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="diarrheaDays<?php echo e($i); ?>" value="<?php echo e($diarrheaDays[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Vomiting (#days)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="vomiting_days<?php echo e($i); ?>" value="<?php echo e($vomiting_days[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Fever (#days)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="fever_days<?php echo e($i); ?>" value="<?php echo e($fever_days[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Cough (#days)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="cough_days<?php echo e($i); ?>" value="<?php echo e($cough_days[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <th colspan="18">Physical Examination</th>
                    </tr>
                    <tr>
                        <td><label>Temperature (C)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="temperatureDays<?php echo e($i); ?>" value="<?php echo e($temperatureDays[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Respiration Rate (# / min)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="respirationRate<?php echo e($i); ?>" value="<?php echo e($respirationRate[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Dehydrated (Y/ N)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="dehydrated<?php echo e($i); ?>" value="<?php echo e($dehydrated[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Anemia (Y/N)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="anemia<?php echo e($i); ?>" value="<?php echo e($anemia[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Skin Infection (Y/N)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="skin_infection<?php echo e($i); ?>" value="<?php echo e($skin_infection[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Appetite Test (Pass/Fail)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="appetite_test_day<?php echo e($i); ?>" value="<?php echo e($appetite_test_day[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Action Needed (Y/N)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="action_needed<?php echo e($i); ?>" value="<?php echo e($action_needed[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Appetite Test (Pass/Fail) (note below)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="appetite_test_pass_fail<?php echo e($i); ?>" value="<?php echo e($appetite_test_pass_fail[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Other Medication (see front of card)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="other_medication<?php echo e($i); ?>" value="<?php echo e($other_medication[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>RUTF (#sachets)</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="rutf<?php echo e($i); ?>" value="<?php echo e($rutf[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>Name of Examiner</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="examiner<?php echo e($i); ?>" value="<?php echo e($examiner[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td><label>OUTCOME ***</label></td>
                        <?php for($i=0;$i<17;$i++): ?>
                            <td>
                                <input type="text" name="outcome<?php echo e($i); ?>" value="<?php echo e($outcome[$i]); ?>" class="smallInput" style="width: 100%">
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td colspan="18">
                            *** A = absent &nbsp; &nbsp; &nbsp;
                            D = defaulter (3 consecutive absences) &nbsp; &nbsp; &nbsp;
                            T = transfer to Inpatient &nbsp; &nbsp; &nbsp;
                            X = died &nbsp; &nbsp; &nbsp;
                            C = discharged cured &nbsp; &nbsp; &nbsp;
                            RT = refused transfer &nbsp; &nbsp; &nbsp;
                            HV = home visit &nbsp; &nbsp; &nbsp;
                            NC = discharged non-cured &nbsp; &nbsp; &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="18" class="text-center">**Action taken (include data)</td>
                    </tr>
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


            <br>
            <br>
            <br>
            <br>

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

    <?php echo $__env->make('receptions.message.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
