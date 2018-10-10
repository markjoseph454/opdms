<style>
    table{
        font-size: 10px;
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
            <td>Baby's Name:
                <?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name); ?>

            </td>
            <td>KMC #:
                <?php echo e($data->kmc_no); ?>

            </td>
        </tr>
        <tr>
            <td>Mother's Name:
                <?php echo e($data->mother); ?>

            </td>
            <td>AOG:
                "<?php echo e($data->aog); ?>

            </td>
        </tr>
        <tr>
            <td>Address:
                <?php echo e($patient->provDesc.' '.$patient->citymunDesc.' '.$patient->brgyDesc); ?>

            </td>
            <td><span style="margin-right: 100px">Birth Weight:
                <?php echo e($data->birth_weight); ?>

                </span>
                Discharge Weight:
                <?php echo e($data->discharge_weight); ?>

            </td>
        </tr>
        <tr>
            <td>Birthday:
                <?php echo e(Carbon::parse($patient->birthday)->toFormattedDateString()); ?>

            </td>
            <td>Contact #:
                <?php echo e($data->contact_no); ?>

            </td>
        </tr>
        <tr>
            <th class="titleHead" colspan="2">Follow-up</th>
        </tr>
        <tr>
            <td>Date: <?php echo e($data->date_ff); ?></td>
            <td>Head Circumference: <?php echo e($data->head_circumference); ?> &nbsp;
                Temperature: <?php echo e($data->temperature); ?>

            </td>
        </tr>
        <tr>
            <td>Age: &nbsp;
                <?php echo e($data->month); ?> Month.
                <?php echo e($data->week); ?> Week.
                <?php echo e($data->days); ?> Days.
            </td>
            <td>Corrected Age:
                <?php echo e($data->corrected_age); ?>

            </td>
        </tr>
        <tr>
            <td>Weight: <?php echo e($data->weight); ?></td>
            <td>Body Length/Height: <?php echo e($data->weight); ?></td>
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
            <th class="titleHead" colspan="2">Clinical DX</th>
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
            <td>
                <input type="checkbox" name="condition_of_baby" value="Well Baby"
                    <?php if($data->condition_of_baby == 'Well Baby'): ?> checked="checked" <?php endif; ?>/> Well Baby
                </td>
            <td>
                <label><input type="checkbox" name="condition_of_baby" value="Not Well"
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
                <label class="checkbox-inline">
                    <input type="checkbox"
                    <?php if($conditionOfBaby): ?>
                        <?php if($not_well): ?>
                            <?php if(in_array('Failure to thrive', $not_well)): ?> checked="checked" <?php endif; ?>
                                                      <?php endif; ?>
                                                      <?php else: ?>
                                                      disabled
                                                      <?php endif; ?> name="notwell[]" value="Failure to thrive">Failure to thrive</label>
                <br/>
                <label class="checkbox-inline">
                    <input type="checkbox"
                    <?php if($conditionOfBaby): ?>
                        <?php if($not_well): ?>
                            <?php if(in_array('Hemorrhagic illness', $not_well)): ?> checked="checked" <?php endif; ?>
                                                      <?php endif; ?>
                                                      <?php else: ?>
                                                      disabled
                                                      <?php endif; ?> name="notwell[]" value="Hemorrhagic illness">Hemorrhagic illness</label>
                <br/>
                <label class="checkbox-inline">
                    <input type="checkbox"
                    <?php if($conditionOfBaby): ?>
                        <?php if($not_well): ?>
                            <?php if(in_array('Others', $not_well)): ?> checked="checked" <?php endif; ?>
                                                      <?php endif; ?>
                                                      <?php else: ?>
                                                      disabled
                                                      <?php endif; ?> name="notwell[]" value="Others">Others:</label>
                <?php if($conditionOfBaby): ?>
                    <?php if($not_well): ?>
                        <?php if(in_array('Others', $not_well)): ?>
                            <?php echo e($data->not_well_others); ?>

                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <?php



            $neurological = ($data->neuro)? unserialize($data->neuro) : false;
            $chronic = ($data->chronic_pathology)? unserialize($data->chronic_pathology) : false;


            ?>
            <td class="notwell">Neurological Status: <br/>
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
            <td class="notwell">Ongoing Chronic Pathology: <br/>
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
                                <p style="margin: 30px 30px"><?php echo e($data->prescription); ?></p>
            </td>
        </tr>
        </tbody>
    </table>
</div>