<style>
    table{
        font-size: 10px;
    }
    .titleHead{
        text-align: center;
        background-color: #ccc;
    }
    .stripedLine{
        background-color:#333;
    }
</style>
<div>
    <table border="1">
        <tbody>
        <tr>
            <td colspan="2">
                Clinic:
                <?php echo e($data->clinic_name); ?>

            </td>
            <td>
                Childs No.:
                <?php echo e($patient->hospital_no); ?>

            </td>
        </tr>
        <tr>
            <td colspan="3">
                Barangay:
                <?php echo e($patient->provDesc.' '.$patient->citymunDesc.' '.$patient->brgyDesc); ?>

            </td>
        </tr>
        <tr>
            <td colspan="3">
                Family No.:
                <?php echo e($data->family); ?>

            </td>
        </tr>
        <tr>
            <td colspan="2">
                Childs Name:
                <?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name); ?>

            </td>
            <td>
                Sex: &nbsp; &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="sex" value="M"
                           <?php if($patient->sex == 'M'): ?> checked="checked" <?php endif; ?>> M
                </label>
                &nbsp; &nbsp;
                <label class="normalLabel">
                    <input type="radio" name="sex" value="F"
                           <?php if($patient->sex == 'F'): ?> checked="checked" <?php endif; ?>> F
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Mothers Name:
                <?php echo e($data->mother); ?>

            </td>
        </tr>
        <tr>
            <td colspan="3">
                Educational Level:
                <?php echo e($data->education); ?>

            </td>
        </tr>
        <tr>
            <td colspan="3">
                Occupation:
                <?php echo e($data->occupation); ?>

            </td>
        </tr>
        <tr>
            <td>
                Date First Seen:
                <?php echo e($data->date_first_seen); ?>

            </td>
            <td>
                Birth Date:
                <?php echo e($patient->birthday); ?>

            </td>
            <td>
                Birth Weight:
                <?php echo e($data->birth_weight); ?>

            </td>
        </tr>
        <tr>
            <td>
                Place of delivery:
                <?php echo e($data->place_of_delivery); ?>

            </td>
            <td colspan="2">
                Birth registered at local civil registry (date):
                <?php echo e($data->birth_registered); ?>

            </td>
        </tr>
        <tr>
            <td colspan="3">
                Complete address of family (House No., Street, City/Province):
                <?php echo e($data->complete_address); ?>

            </td>
        </tr>
        <tr>
            <th colspan="3" class="titleHead">BROTHERS AND SISTERS</th>
        </tr>
        <tr>
            <td>Name:</td>
            <td>Sex:</td>
            <td>Date of Birth:</td>
        </tr>

        <?php
        $bro_sis = explode('^', $data->bro_sis);
        $gender = explode('^', $data->gender);
        $date_birth = explode('^', $data->date_birth);

        ?>


        <?php for($i=0;$i<12;$i++): ?>
            <tr>
                <td>
                    <?php if($bro_sis[$i] != '*'): ?> <?php echo e($bro_sis[$i]); ?> <?php endif; ?>
                </td>
                <td class="text-center">
                    <label class="normalLabel">
                        <input type="radio" name="gender<?php echo e($i); ?>" value="M"
                               <?php if($gender[$i] == 'M'): ?> checked="checked" <?php endif; ?>> M
                    </label>
                    &nbsp; &nbsp; &nbsp; &nbsp;
                    <label class="normalLabel">
                        <input type="radio" name="gender<?php echo e($i); ?>" value="F"
                               <?php if($gender[$i] == 'F'): ?> checked="checked" <?php endif; ?>> F
                    </label>
                </td>
                <td>
                    <?php if($date_birth[$i] != '*'): ?> <?php echo e($date_birth[$i]); ?> <?php endif; ?>
                </td>
            </tr>
        <?php endfor; ?>



        </tbody>
    </table>
</div>


<div>
    <table border="1">
        <tbody>
        <tr>
            <th colspan="7" class="titleHead">ESSENTIAL HEALTH AND NUTRITION SERVICES</th>
        </tr>
        <tr>
            <td></td>
            <td colspan="6" style="text-align: center">DATE OF VISITS</td>
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

        <?php
        $pv = explode('^', $data->pv);
        $opv = explode('^', $data->opv);
        $mmr_two = explode('^', $data->mmr_two);
        $ipv = explode('^', $data->ipv);
        $pcv = explode('^', $data->pcv);
        ?>

        <tr>
            <th>NEWBORN SCREENING</th>
            <?php for($i=0;$i<6;$i++): ?>
                <td <?php if($i>0): ?> class="stripedLine" <?php endif; ?>>
                    <?php if($i<1): ?>
                        <?php echo e($data->newborn_screening); ?>

                    <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <th>BCG (at birth)</th>
            <?php for($i=0;$i<6;$i++): ?>
                <td <?php if($i>0): ?> class="stripedLine" <?php endif; ?>>
                    <?php if($i<1): ?>
                        <?php echo e($data->bcg); ?>

                    <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>

        <tr>
            <th>PV (6 wks, 10 wks, 14 wks old)</th>
            <?php for($i=0;$i<6;$i++): ?>
                <td <?php if($i>2): ?> class="stripedLine" <?php endif; ?>>
                    <?php if($i<3): ?>
                        <?php if($pv[$i] != '*'): ?> <?php echo e($pv[$i]); ?> <?php endif; ?>
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>

        <tr>
            <th>OPV (6 wks, 10 wks, 14 wks old)</th>
            <?php for($i=0;$i<6;$i++): ?>
                <td <?php if($i>2): ?> class="stripedLine" <?php endif; ?>>
                    <?php if($i<3): ?>
                        <?php if($opv[$i] != '*'): ?> <?php echo e($opv[$i]); ?> <?php endif; ?>
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>

        <tr>
            <th>HEPATITIS B (6 wks, 10 wks, 14 wks old)</th>
            <?php for($i=0;$i<6;$i++): ?>
                <td <?php if($i>0): ?> class="stripedLine" <?php endif; ?>>
                    <?php if($i<1): ?>
                        <?php echo e($data->hepatitis); ?>

                    <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>

        <tr>
            <th>MMR1</th>
            <?php for($i=0;$i<6;$i++): ?>
                <td <?php if($i>0): ?> class="stripedLine" <?php endif; ?>>
                    <?php if($i<1): ?>
                        <?php echo e($data->mmr_one); ?>

                    <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <th>MMR2</th>
            <?php for($i=0;$i<6;$i++): ?>
                <td>
                    <?php if($mmr_two[$i] != '*'): ?> <?php echo e($mmr_two[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <th>IPV</th>
            <?php for($i=0;$i<6;$i++): ?>
                <td>
                    <?php if($ipv[$i] != '*'): ?> <?php echo e($ipv[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
        <tr>
            <th>PCV</th>
            <?php for($i=0;$i<6;$i++): ?>
                <td>
                    <?php if($pcv[$i] != '*'): ?> <?php echo e($pcv[$i]); ?> <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>



        </tbody>
    </table>
</div>