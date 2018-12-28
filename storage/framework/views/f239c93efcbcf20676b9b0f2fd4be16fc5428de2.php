
<table border="1">
        
        
        <tr>
            <td>
                <b>Name:</b>
                <?php echo e($radiology->patient); ?>

            </td>
            <td>
                <b>Hospital Number:</b>
                098908
            </td>
            <td>
                <b>Date:</b>
                <?php echo e(Carbon::parse($radiology->created_at)->toFormattedDateString()); ?>

            </td>
            
        </tr>
        <tr>
            <td>
                <b>Birthdate:</b>
                <?php echo e(\Carbon\Carbon::parse($radiology->birthday)->toFormattedDateString()); ?>

            </td>
            <td>
                <b>Case Number:</b>
                <br>
                EVRMC-RADIO-UTZ &nbsp; <strong><?php echo e($radiology->imageID); ?></strong> &nbsp; S.2018
            </td>
            <td>
                <b>Time</b>
                <?php echo e(\Carbon\Carbon::parse($radiology->created_at)->format('h:i a')); ?>

            </td>
        </tr>
        <tr>
            <td>
                <b>Address:</b> <?php echo e($radiology->address); ?>

            </td>
            <td>
                <b>Age:</b>
                <?php echo e(\App\Patient::age($radiology->birthday)); ?>

                &nbsp;
                <b>Sex:</b>
                <?php echo e($radiology->sex); ?>

            </td>
            <td>
                <b>Ward:</b> OPD
            </td>
        </tr>
        <tr>
            <td>
                <b>Clinical Data:</b>
                <br>
                <?php echo e($radiology->clinicalData); ?>

            </td>
            <td>
                <b>Attending Physician</b>
                <br>
                <?php echo e($radiology->physician); ?>

            </td>
            <td>
                <b>OR NO.:</b>
            </td>
        </tr>
        
</table>


