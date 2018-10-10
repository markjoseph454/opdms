<div class="table-responsive tableMainWrapper">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="4" class="text-center bg-success">
                <?php echo e((Auth::user()->clinic == 22)? 'Radiographic' : 'Ultrasound'); ?>

                RESULT
            </th>
        </tr>
        </thead>
        <tbody class="bg-warning">
        <tr>
            <td colspan="1" style="width: 560px">
                EVRMC-RADIOLOGY <input type="text" value="<?php echo e($radiology->imageID); ?>" name="imageID"/> S.2018
            </td>
            <td colspan="3">
                Effectivity: Aug. 18, 2017 Rev.1
            </td>
        </tr>
        <tr>
            <td>
                Family Name, Given Name, M.I <br>
                <?php echo e($radiology->patient); ?>

            </td>
            <td>
                AGE <br>
                <?php echo e(App\Patient::age($radiology->birthday).' / '.$radiology->sex); ?>

            </td>
            <td>
                WARD <br>
                OPD
            </td>
            <td>
                DATE/TIME <br>
                <?php echo e(Carbon::parse($radiology->created_at)->toFormattedDateString()); ?>

            </td>
        </tr>
        <tr>
            <td colspan="1">
                Clinic Data <br>
                <input type="text" name="clinicalData" value="<?php echo e($radiology->clinicalData); ?>"/>
            </td>
            <td colspan="3">
                Attending Physician <br>
                <input type="text" name="physician" value="<?php echo e($radiology->physician); ?>"/>
            </td>
        </tr>
        </tbody>
    </table>
</div>