<div id="home" class="tab-pane fade in active">


    <div class="col-md-6">


        <br>
        <br>

        <div class="table-responsive">
            <table class="table">
                <tbody>
                <tr>
                    <th>Name :</th>
                    <td><?php echo e($patient->last_name.', '.$patient->first_name); ?></td>
                </tr>
                <tr>
                    <th>Hospital No. :</th>
                    <td><?php echo e($patient->hospital_no); ?></td>
                </tr>
                <tr>
                    <th>QRCODE :</th>
                    <td><?php echo e($patient->barcode); ?></td>
                </tr>
                <tr>
                    <th>Birthday :</th>
                    <td><?php echo e(Carbon::parse($patient->birthday)->toFormattedDateString()); ?></td>
                </tr>
                <tr>
                    <th>Age :</th>
                    <td><?php echo e(App\Patient::age($patient->birthday)); ?></td>
                </tr>
                <tr>
                    <th>Address :</th>
                    <td><?php echo e($patient->address); ?></td>
                </tr>
                <tr>
                    <th>Civil Status :</th>
                    <td><?php echo e($patient->civil_status); ?></td>
                </tr>
                <tr>
                    <th>Sex :</th>
                    <td><?php echo e($patient->sex); ?></td>
                </tr>
                <tr>
                    <th>Contact No. :</th>
                    <td><?php echo e($patient->contact_no); ?></td>
                </tr>
                <tr>
                    <th>Date Registered :</th>
                    <td><?php echo e(Carbon::parse($patient->created_at)->toFormattedDateString()); ?></td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>