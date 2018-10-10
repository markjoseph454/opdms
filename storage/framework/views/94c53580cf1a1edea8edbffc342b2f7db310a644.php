<div id="menu1" class="tab-pane fade">



    <div class="col-md-6 col-md-offset-6">


        <br>
        <br>

        <div class="table-responsive">
            <table class="table">
                <tbody>
                <tr>
                    <th>Blood Pressure :</th>
                    <td><?php echo e(($vital)? $vital->blood_pressure : 'None'); ?></td>
                </tr>
                <tr>
                    <th>Pulse Rate :</th>
                    <td><?php echo e(($vital)? $vital->pulse_rate : 'None'); ?></td>
                </tr>
                <tr>
                    <th>Respiration Rate :</th>
                    <td><?php echo e(($vital)? $vital->respiration_rate : 'None'); ?></td>
                </tr>
                <tr>
                    <th>Body Temperature :</th>
                    <td><?php echo e(($vital)? $vital->body_temperature : 'None'); ?></td>
                </tr>
                <tr>
                    <th>Weight :</th>
                    <td><?php echo e(($vital)? $vital->weight : 'None'); ?></td>
                </tr>
                <tr>
                    <th>Height :</th>
                    <td><?php echo e(($vital)? $vital->height : 'None'); ?></td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>



</div>