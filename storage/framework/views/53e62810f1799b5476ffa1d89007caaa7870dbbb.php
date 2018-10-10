<style>
    table{
        font-size: 10px;
    }
    .titleHead{
        text-align: center;
        background-color: #ccc;
    }
</style>

<div class="table-responsive" id="otpc_front_table_div">

    <span class="text-info">Instructions:</span>
    <small>
        <em class="text-info">
            Please fill up needed details and encircle appropriate text or values based on history taking and physical examination
        </em>
    </small>
    <br>
    <table border="1">
        <tbody>
        <tr>
            <td><label class="label">Name</label></td>
            <td colspan="3">
                <?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name); ?>

            </td>
            <td><label>Reg. No</label></td>
            <td colspan="3">
                <?php echo e($patient->hospital_no); ?>

            </td>
        </tr>

        <tr>
            <td><label>Municipality</label></td>
            <td colspan="3">
                <?php echo e($patient->citymunDesc); ?>

            </td>
            <td><label>Barangay</label></td>
            <td colspan="3">
                <?php echo e($patient->brgyDesc); ?>

            </td>
        </tr>

        <tr>
            <td colspan="2"><label>Age (months): </label>
                <?php echo e($data->age_months); ?>

            </td>
            <td colspan="2">
                <label>Sex: </label>
                &nbsp; &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="sex" value="M" <?php if($patient->sex == 'M'): ?> checked="checked" <?php endif; ?>> M
                </label>
                <label class="normalLabel">
                    <input type="radio" name="sex" value="F" <?php if($patient->sex == 'F'): ?> checked="checked" <?php endif; ?>> F
                </label>
            </td>
            <td colspan="4"><label>Date of Admission: </label>
                <?php echo e($data->date_of_admission); ?>

            </td>
        </tr>

        <tr>
            <td><label>Admission Status</label></td>
            <td colspan="7" class="admissionStatus">
                <em>Screened by Nurse/MD</em>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <label class="normalLabel"><input type="radio" name="admission_status" value="Walk-in"
                                                  <?php if($data->admission_status == 'Walk-in'): ?> checked="checked" <?php endif; ?>> Walk-in</label>
                <label class="normalLabel"><input type="radio" name="admission_status" value="From IC"
                                                  <?php if($data->admission_status == 'From IC'): ?> checked="checked" <?php endif; ?>> From IC</label>
                <label class="normalLabel"><input type="radio" name="admission_status" value="From SFP"
                                                  <?php if($data->admission_status == 'From SFP'): ?> checked="checked" <?php endif; ?>> From SFP</label>
                <label class="normalLabel"><input type="radio" name="admission_status" value="From other OC"
                                                  <?php if($data->admission_status == 'From other OC'): ?> checked="checked" <?php endif; ?>> From other OC</label>
                <label class="normalLabel"><input type="radio" name="admission_status" value="Readmission (Relapse)"
                                                  <?php if($data->admission_status == 'Readmission (Relapse)'): ?> checked="checked" <?php endif; ?>> Readmission (Relapse)</label>
                <label class="normalLabel"><input type="radio" name="admission_status" value="ITC Refusal"
                                                  <?php if($data->admission_status == 'ITC Refusal'): ?> checked="checked" <?php endif; ?>> ITC Refusal</label>
            </td>
        </tr>


        <tr>
            <td><label>Total Number in Household</label></td>
            <td>#Adults:
                <?php echo e($data->adults); ?>

            </td>
            <td>#Children:
                <?php echo e($data->children); ?>

            </td>
            <td><label>Twin: </label>
                <label class="normalLabel"><input type="radio" name="twin" value="1"
                                                  <?php if($data->twin == 1): ?> checked="checked" <?php endif; ?>> Yes</label>
                &nbsp; &nbsp;
                <label class="normalLabel"><input type="radio" name="twin" value="0"
                                                  <?php if($data->twin == '0'): ?> checked="checked" <?php endif; ?>> No</label>
            </td>
            <td colspan="2"><label>Distance to home (hrs): </label>
                <?php echo e($data->distance_to_home); ?>

            </td>
            <td><label>4Ps Beneficiary?: </label></td>
            <td><label class="normappetite_test_dayalLabel">
                    <input type="radio" name="four_ps" <?php if($data->four_ps == 1): ?> checked="checked" <?php endif; ?> value="1"> Yes
                </label>
                <label class="normalLabel">
                    <input type="radio" name="four_ps" <?php if($data->four_ps == '0'): ?> checked="checked" <?php endif; ?> value="0"> No
                </label>
            </td>
        </tr>

        <tr>
            <th colspan="8" class="titleHead">Admission Anthropometry</th>
        </tr>

        <tr>
            <td><label>MUAC(cm): </label>
                <?php echo e($data->muac_front); ?>

            </td>
            <td colspan="2">Weight (kg): <?php echo e($data->weight); ?>

            </td>
            <td colspan="2">Height (cm): <?php echo e($data->height); ?>

            </td>
            <td colspan="3">WHZ score: <?php echo e($data->whz_score); ?>

            </td>
        </tr>


        <tr>
            <td><label>Admission Criteria (encircle all apllicable)</label>
            </td>
            <td><label class="normalLabel">Edema: </label>
                <?php echo e($data->edemaAdmission); ?>

            </td>
            <td><input type="radio" name="admission_criteria" class="opposeOthers" value="MUAC < 11.5 cm"
                       <?php if($data->admission_criteria == 'MUAC < 11.5 cm'): ?> checked="checked" <?php endif; ?>> MUAC < 11.5 cm
            </td>
            <td colspan="2"><input type="radio" name="admission_criteria" value="WHZ <- 3<" <?php if($data->admission_criteria == 'WHZ <- 3<'): ?> checked="checked" <?php endif; ?> />
                WHZ -3
            </td>
            <td><input type="radio" name="admission_criteria" class="thisOther" value="other"
                       <?php if($data->admission_criteria == 'other'): ?> checked="checked" <?php endif; ?>> Other (specify)
            </td>
            <td colspan="2"><?php echo e($data->other_description); ?>

            </td>
        </tr>

        <tr>
            <th colspan="8" class="titleHead">History</th>
        </tr>

        <tr>
            <td><label>IMCI Danger Signs</label>
            </td>
            <td><label>Able to drink or breastfeed?</label> &nbsp; &nbsp; &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="breastfeed_or_drink" value="1"
                           <?php if($data->breastfeed_or_drink == 1): ?> checked="checked" <?php endif; ?>> Yes
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="breastfeed_or_drink" value="0"
                           <?php if($data->breastfeed_or_drink == '0'): ?> checked="checked" <?php endif; ?>> No
                </label>
            </td>
            <td colspan="2"><label>Does the Child Vomit Everything?</label>
                <label class="normalLabel">
                    <input type="radio" name="vomit" value="1"
                           <?php if($data->vomit == 1): ?> checked="checked" <?php endif; ?>> Yes
                </label><label class="normalLabel">
                    <input type="radio" name="vomit" value="0"
                           <?php if($data->vomit == '0'): ?> checked="checked" <?php endif; ?>> No
                </label>
            </td>
            <td colspan="2"><label>Has the child convulsion?</label>
                &nbsp; &nbsp; &nbsp;<br>
                <label class="normalLabel">
                    <input type="radio" name="convulsion" value="1"
                           <?php if($data->convulsion == 1): ?> checked="checked" <?php endif; ?>> Yes
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="convulsion" value="0"
                           <?php if($data->convulsion == '0'): ?> checked="checked" <?php endif; ?>> No
                </label>
            </td>
            <td colspan="2"><label>Is child lethargic / unconscious</label>
                &nbsp; &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="lethargic_unconscious" value="1"
                           <?php if($data->lethargic_unconscious == 1): ?> checked="checked" <?php endif; ?>> Yes
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="lethargic_unconscious" value="0"
                           <?php if($data->lethargic_unconscious == '0'): ?> checked="checked" <?php endif; ?>> No
                </label>
            </td>
        </tr>

        <tr>
            <td><label>Diarrhea: </label></td>
            <td colspan="2">
                <label class="normalLabel">
                    <input type="radio" name="diarrhea" value="1"
                           <?php if($data->diarrhea == 1): ?> checked="checked" <?php endif; ?>> Yes
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="diarrhea" value="0"
                           <?php if($data->diarrhea == '0'): ?> checked="checked" <?php endif; ?>> No
                </label>
            </td>
            <td><label>Stools / Day</label></td>
            <td colspan="4">
                <label class="normalLabel">
                    <input type="radio" name="stools_day" value="1-3"
                           <?php if($data->stools_day == "1-3"): ?> checked="checked" <?php endif; ?>> 1-3
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="stools_day" value="4-5"
                           <?php if($data->stools_day == "4-5"): ?> checked="checked" <?php endif; ?>> 4-5
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="stools_day" value=">5"
                           <?php if($data->stools_day == ">5"): ?> checked="checked" <?php endif; ?>> >5
                </label>
            </td>
        </tr>

        <tr>
            <td><label>Vomiting: </label></td>
            <td colspan="2">
                <label class="normalLabel">
                    <input type="radio" name="vomiting" value="1"
                           <?php if($data->vomiting == 1): ?> checked="checked" <?php endif; ?>> Yes
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="vomiting" value="0"
                           <?php if($data->vomiting == '0'): ?> checked="checked" <?php endif; ?>> No
                </label>
            </td>
            <td rowspan="2" colspan="2">
                <label>Frequency: </label> <br>
                <?php echo e($data->frequency); ?>

            </td>
            <td><label>Passing Urine:</label></td>
            <td colspan="2">
                <label class="normalLabel">
                    <input type="radio" name="passing_urine" value="1"
                           <?php if($data->passing_urine == 1): ?> checked="checked" <?php endif; ?>> Yes
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="passing_urine" value="0"
                           <?php if($data->passing_urine == '0'): ?> checked="checked" <?php endif; ?>> No
                </label>
            </td>
        </tr>

        <tr>
            <td><label>Cough: </label></td>
            <td colspan="2">
                <label class="normalLabel">
                    <input type="radio" name="cough" value="1"
                           <?php if($data->cough == 1): ?> checked="checked" <?php endif; ?>> Yes
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="cough" value="0"
                           <?php if($data->cough == '0'): ?> checked="checked" <?php endif; ?>> No
                </label>
            </td>
            <td colspan="2"><label>If edema, how long swollen?</label>
            </td>
            <td colspan="3">
                <?php echo e($data->how_long_swollen); ?>

            </td>
        </tr>


        <tr>
            <td><label>Appetite at home?</label>
            </td>
            <td colspan="3">
                <label class="normalLabel">
                    <input type="radio" name="appetite_at_home" value="good"
                           <?php if($data->appetite_at_home == 'good'): ?> checked="checked" <?php endif; ?>> Good
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="appetite_at_home" value="poor"
                           <?php if($data->appetite_at_home == 'poor'): ?> checked="checked" <?php endif; ?>> Poor
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="appetite_at_home" value="none"
                           <?php if($data->appetite_at_home == 'none'): ?> checked="checked" <?php endif; ?>> None
                </label>
            </td>
            <td colspan="2"><label>Breastfeeding</label></td>
            <td colspan="2">
                <label class="normalLabel">
                    <input type="radio" name="breastfeeding" value="1"
                           <?php if($data->breastfeeding == 1): ?> checked="checked" <?php endif; ?>> Yes
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="breastfeeding" value="0"
                           <?php if($data->breastfeeding == '0'): ?> checked="checked" <?php endif; ?>> No
                </label>
            </td>
        </tr>


        <tr>
            <td><label>Reported Problems: </label></td>
            <td><?php echo e($data->reported_problems); ?>

            </td>
            <td><label>Other Medical Problems: </label>
            </td>
            <td colspan="5">
                <label class="normalLabel">
                    <input type="radio" name="other_med_problems" class="opposeOthers" value="Tuberculosis"
                           <?php if($data->other_med_problems == 'Tuberculosis'): ?> checked="checked" <?php endif; ?>> Tuberculosis
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="other_med_problems" class="opposeOthers" value="Malaria"
                           <?php if($data->other_med_problems == "Malaria"): ?> checked="checked" <?php endif; ?>> Malaria
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="other_med_problems" class="opposeOthers" value="Congenital anomalies"
                           <?php if($data->other_med_problems == "Congenital anomalies"): ?> checked="checked" <?php endif; ?>> Congenital anomalies
                </label>
                &nbsp; &nbsp; <br>
                <label class="normalLabel">
                    <input type="radio" name="other_med_problems" class="thisOther" value="Others"
                           <?php if($data->other_med_problems == "Others"): ?> checked="checked" <?php endif; ?>> Others:
                </label>
                <?php echo e($data->other_medical_problems); ?>

            </td>
        </tr>

        <tr>
            <th class="titleHead" colspan="8">Physical Examination</th>
        </tr>

        <tr>
            <td><label>Respiration Rate (#min)</label>
            </td>
            <td colspan="3"><label class="normalLabel">
                    <input type="radio" name="respiration_rate" value="<30"
                           <?php if($data->respiration_rate == "<30"): ?> checked="checked" <?php endif; ?>> less 30
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="respiration_rate" value="30-39"
                           <?php if($data->respiration_rate == "30-39"): ?> checked="checked" <?php endif; ?>> 30-39
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="respiration_rate" value="40-49"
                           <?php if($data->respiration_rate == "40-49"): ?> checked="checked" <?php endif; ?>> 40-49
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="respiration_rate" value="50+"
                           <?php if($data->respiration_rate == "50+"): ?> checked="checked" <?php endif; ?>> 50+
                </label>
            </td>
            <td><label>Edema</label>
            </td>
            <td colspan="3">
                <label class="normalLabel">
                    <input type="radio" name="edema" value="+"
                           <?php if($data->edema == "+"): ?> checked="checked" <?php endif; ?>>+
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="edema" value="++"
                           <?php if($data->edema == "++"): ?> checked="checked" <?php endif; ?>> ++
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="edema" value="+++"
                           <?php if($data->edema == "+++"): ?> checked="checked" <?php endif; ?>> +++
                </label>
            </td>
        </tr>

        <tr>
            <td colspan="2"> <label>Temperature (C): </label>
            </td>
            <td colspan="2">
                <?php echo e($data->temperature); ?>

            </td>
            <td colspan="2"><label>Chest Retractions: </label>
            </td>
            <td colspan="2">
                <label class="normalLabel">
                    <input type="radio" name="chest_retractions" value="1"
                           <?php if($data->chest_retractions == 1): ?> checked="checked" <?php endif; ?>> Yes
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="chest_retractions" value="0"
                           <?php if($data->chest_retractions == '0'): ?> checked="checked" <?php endif; ?>> No
                </label>
            </td>
        </tr>


        <tr>
            <td><label>Eyes: </label></td>
            <td colspan="3">
                <label class="normalLabel">
                    <input type="radio" name="eyes" value="Normal"
                           <?php if($data->eyes == "Normal"): ?> checked="checked" <?php endif; ?>>Normal
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="eyes" value="Sunken"
                           <?php if($data->eyes == "Sunken"): ?> checked="checked" <?php endif; ?>> Sunken
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="eyes" value="Discharge"
                           <?php if($data->eyes == "Discharge"): ?> checked="checked" <?php endif; ?>> Discharge
                </label>
            </td>
            <td>
                <label>Dehydration: </label>
            </td>
            <td colspan="3">
                <label class="normalLabel">
                    <input type="radio" name="dehydration" value="None"
                           <?php if($data->dehydration == "None"): ?> checked="checked" <?php endif; ?>> None
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="dehydration" value="Moderate"
                           <?php if($data->dehydration == "Moderate"): ?> checked="checked" <?php endif; ?>> Moderate
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="dehydration" value="Severe"
                           <?php if($data->dehydration == "Severe"): ?> checked="checked" <?php endif; ?>> Severe
                </label>
            </td>
        </tr>

        <tr>
            <td><label>Conjuctiva: </label></td>
            <td colspan="3">
                <label class="normalLabel">
                    <input type="radio" name="conjuctiva" value="Normal"
                           <?php if($data->conjuctiva == "Normal"): ?> checked="checked" <?php endif; ?>> Normal
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="conjuctiva" value="Pale"
                           <?php if($data->conjuctiva == "Pale"): ?> checked="checked" <?php endif; ?>> Pale
                </label>
            </td>
            <td><label>Mouth: </label></td>
            <td colspan="3">
                <label class="normalLabel">
                    <input type="radio" name="mouth" value="Normal"
                           <?php if($data->mouth == "Normal"): ?> checked="checked" <?php endif; ?>> Normal
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="mouth" value="Sores"
                           <?php if($data->mouth == "Sores"): ?> checked="checked" <?php endif; ?>> Sores
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="mouth" value="Candida"
                           <?php if($data->mouth == "Candida"): ?> checked="checked" <?php endif; ?>> Candida
                </label>
            </td>
        </tr>

        <tr>
            <td><label>Ears: </label></td>
            <td colspan="3">
                <label class="normalLabel">
                    <input type="radio" name="ears" value="Normal"
                           <?php if($data->ears == "Normal"): ?> checked="checked" <?php endif; ?>> Normal
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="ears" value="Discharge"
                           <?php if($data->ears == "Discharge"): ?> checked="checked" <?php endif; ?>> Discharge
                </label>
            </td>
            <td><label>Disability</label>
            </td>
            <td colspan="3">
                <label class="normalLabel">
                    <input type="radio" name="disability" value="1"
                           <?php if($data->disability == 1): ?> checked="checked" <?php endif; ?>> Yes
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="disability" value="0"
                           <?php if($data->disability == '0'): ?> checked="checked" <?php endif; ?>> No
                </label>
            </td>
        </tr>

        <tr>
            <td><label>Skin Changes: </label></td>
            <td colspan="4">
                <label class="normalLabel">
                    <input type="radio" name="skin_changes" value="None"
                           <?php if($data->skin_changes == "None"): ?> checked="checked" <?php endif; ?>> None
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="skin_changes" value="Scabies"
                           <?php if($data->skin_changes == "Scabies"): ?> checked="checked" <?php endif; ?>> Scabies
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="skin_changes" value="Peeling"
                           <?php if($data->skin_changes == "Peeling"): ?> checked="checked" <?php endif; ?>> Peeling
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="skin_changes" value="Ulcer/Abscesses"
                           <?php if($data->skin_changes == "Ulcer/Abscesses"): ?> checked="checked" <?php endif; ?>> Ulcer/Abscesses
                </label>
            </td>
            <td><label>Extremities: </label>
            </td>
            <td colspan="2">
                <label class="normalLabel">
                    <input type="radio" name="extremities" value="Normal"
                           <?php if($data->extremities == "Normal"): ?> checked="checked" <?php endif; ?>> Normal
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="extremities" value="Cold"
                           <?php if($data->extremities == "Cold"): ?> checked="checked" <?php endif; ?>> Cold
                </label>
            </td>
        </tr>

        <tr>
            <td><label>Appetite Test: </label></td>
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
            <td colspan="5">NOTE: <em>If child failed appetite test, refer IMMEDIATELY TO ITC</em>
            </td>
        </tr>

        <tr>
            <th class="titleHead" colspan="8">Routine Admission Medication</th>
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
            <td colspan="2"><?php echo e($drugsFront[0]); ?>

            </td>
            <td colspan="2"><?php echo e($dateFront[0]); ?>

            </td>
            <td colspan="3"><?php echo e($dosageFront[0]); ?>

            </td>
        </tr>

        <tr>
            <td colspan="2"><?php echo e($drugsFront[1]); ?>

            </td>
            <td colspan="2"><?php echo e($dateFront[1]); ?>

            </td>
            <td colspan="3"><?php echo e($dosageFront[1]); ?>

            </td>
        </tr>

        <tr>
            <td colspan="2"><?php echo e($drugsFront[2]); ?>

            </td>
            <td colspan="2"><?php echo e($dateFront[2]); ?>

            </td>
            <td colspan="3"><?php echo e($dosageFront[2]); ?>

            </td>
        </tr>

        <tr>
            <td colspan="2"><?php echo e($drugsFront[3]); ?>

            </td>
            <td colspan="2"><?php echo e($dateFront[3]); ?>

            </td>
            <td colspan="3"><?php echo e($dosageFront[3]); ?>

            </td>
        </tr>

        </tbody>
    </table>
</div>