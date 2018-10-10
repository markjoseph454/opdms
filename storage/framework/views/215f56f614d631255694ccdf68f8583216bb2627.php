<style>
    table{
        font-size: 9px;
    }
    .titleHead{
        text-align: center;
        background-color: #ccc;
    }
</style>
<div>
    <table border="1">
        <tbody>

        <tr>
            <td colspan="9"><label>Name:</label>
                <?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name); ?>

            </td>
            <td colspan="9"><label>Registration Number:</label>
                <?php echo e($patient->hospital_no); ?>

            </td>
        </tr>
        <tr>
            <td width="70px"><label>Week</label>
            </td>
            <td width="30px">ADM</td>
            <?php for($i=2;$i<18;$i++): ?>
                <td width="27px"><?php echo e($i); ?></td>
            <?php endfor; ?>
        </tr>


        <?php

        $date = explode('^', $data->date);
        $weightKG = explode('^', $data->weightKG);
        $weightLoss = explode('^', $data->weightLoss);
        $muac = explode('^', $data->muac);
        $edemaBack = explode('^', $data->edemaBack);
        $length_height = explode('^', $data->length_height);
        $whz = explode('^', $data->whz);
        $diarrheaDays = explode('^', $data->diarrheaDays);
        $vomiting_days = explode('^', $data->vomiting_days);
        $fever_days = explode('^', $data->fever_days);
        $cough_days = explode('^', $data->cough_days);
        $temperatureDays = explode('^', $data->temperatureDays);
        $respirationRate = explode('^', $data->respirationRate);
        $dehydrated = explode('^', $data->dehydrated);
        $anemia = explode('^', $data->anemia);
        $skin_infection = explode('^', $data->skin_infection);
        $appetite_test_day = explode('^', $data->appetite_test_day);
        $action_needed = explode('^', $data->action_needed);
        $appetite_test_pass_fail = explode('^', $data->appetite_test_pass_fail);
        $other_medication = explode('^', $data->other_medication);
        $rutf = explode('^', $data->rutf);
        $examiner = explode('^', $data->examiner);
        $outcome = explode('^', $data->outcome);

        ?>

        <tr>
            <td><label>Date</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($date[$i] != '*'): ?>  <?php echo e($date[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <th colspan="18" class="titleHead">Anthropometry</th>
        </tr>
        <tr>
            <td><label>Weight (kg)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($weightKG[$i] != '*'): ?>  <?php echo e($weightKG[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Weight loss * (Y/N)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($weightLoss[$i] != '*'): ?>  <?php echo e($weightLoss[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>MUAC (cm)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($muac[$i] != '*'): ?>  <?php echo e($muac[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Edema (+ ++ +++)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($edemaBack[$i] != '*'): ?>  <?php echo e($edemaBack[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Length/Height</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($length_height[$i] != '*'): ?>  <?php echo e($length_height[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>WHZ</label></td>
            <?php for($i=0;$i<10;$i++): ?>
                <td>
                    <?php if($whz[$i] != '*'): ?>  <?php echo e($whz[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td colspan="18" class="titleHead">
                * WEIGHT CHANGES MARASMICS: If below weight on week 3 refer for home visit. If no weight gain by week 5 refer to ITC.
            </td>
        </tr>
        <tr>
            <th colspan="18" class="titleHead">History</th>
        </tr>
        <tr>
            <td><label>Diarrhea (#days)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($diarrheaDays[$i] != '*'): ?>  <?php echo e($diarrheaDays[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Vomiting (#days)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($vomiting_days[$i] != '*'): ?>  <?php echo e($vomiting_days[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Fever (#days)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($fever_days[$i] != '*'): ?>  <?php echo e($fever_days[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Cough (#days)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($cough_days[$i] != '*'): ?>  <?php echo e($cough_days[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <th colspan="18" class="titleHead">Physical Examination</th>
        </tr>
        <tr>
            <td><label>Temperature (C)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($temperatureDays[$i] != '*'): ?>  <?php echo e($temperatureDays[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Respiration Rate (# / min)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($respirationRate[$i] != '*'): ?>  <?php echo e($respirationRate[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Dehydrated (Y/ N)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($dehydrated[$i] != '*'): ?>  <?php echo e($dehydrated[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Anemia (Y/N)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($anemia[$i] != '*'): ?>  <?php echo e($anemia[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Skin Infection (Y/N)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($skin_infection[$i] != '*'): ?>  <?php echo e($skin_infection[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Appetite Test (Pass/Fail)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($appetite_test_day[$i] != '*'): ?>  <?php echo e($appetite_test_day[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Action Needed (Y/N)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($action_needed[$i] != '*'): ?>  <?php echo e($action_needed[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Appetite Test (Pass/Fail) (note below)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($appetite_test_pass_fail[$i] != '*'): ?>  <?php echo e($appetite_test_pass_fail[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Other Medication (see front of card)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($other_medication[$i] != '*'): ?>  <?php echo e($other_medication[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>RUTF (#sachets)</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($rutf[$i] != '*'): ?>  <?php echo e($rutf[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>Name of Examiner</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($examiner[$i] != '*'): ?>  <?php echo e($examiner[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td><label>OUTCOME ***</label></td>
            <?php for($i=0;$i<17;$i++): ?>
                <td>
                    <?php if($outcome[$i] != '*'): ?>  <?php echo e($outcome[$i]); ?> <?php endif; ?>
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
            <td colspan="18" class="titleHead">**Action taken (include data)</td>
        </tr>

        </tbody>
    </table>
</div>