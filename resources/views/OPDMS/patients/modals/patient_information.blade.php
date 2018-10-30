<div class="modal" id="patient_information_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
                Patient Information
            </div>
            <div class="modal-body">
                @include('OPDMS.partials.loader') {{-- loader icon --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tbody>
                                <tr>
                                    <td>Full Name:</td>
                                    <td colspan="3"><strong class="patient_full_name"></strong></td>
                                </tr>
                                <tr>
                                    <td>Hospital No:</td>
                                    <td colspan="3" class="hospital_no"></td>
                                </tr>
                                <tr>
                                    <td>QR-Code:</td>
                                    <td colspan="3" class="patient_qrcode"></td>
                                </tr>
                                <tr>
                                    <td><b>Birthda</b></td>
                                    <td class="patient_birthday"></td>
                                    <td><b>Age</b></td>
                                    <td class="patient_age"></td>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td colspan="3" class="patient_address" class="text-uppercase"></td>
                                </tr>
                                <tr>
                                    <td>Sex:</td>
                                    <td colspan="3" class="patient_sex"></td>
                                </tr>
                                <tr>
                                    <td>Civil Status:</td>
                                    <td colspan="3" class="patient_civil_status"></td>
                                </tr>
                                <tr>
                                    <td>MSS Classification:</td>
                                    <td colspan="3" class="patient_mss"></td>
                                </tr>
                                <tr>
                                    <td>Date Registered:</td>
                                    <td colspan="3" class="patient_date_reg"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm pull-left" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>