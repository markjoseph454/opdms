
function medicalRecords($scope) {
    $('#modal-medical-records').modal('toggle');
    request = $.ajax({
        url: baseUrl+'/approvalMedicalRecords',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'patient':$scope},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        console.log(response)
        var consultation = (response[0].consultations != null)? response[0].consultations : 0;
        var labs = (response[0].lab != null)? response[0].lab : 0;
        var requisitions = (response[0].requisitions != null)? response[0].requisitions : 0;
        var ultrasound = (response[0].ultrasound != null)? response[0].ultrasound : 0;
        var xray = (response[0].xray != null)? response[0].xray : 0;
        var refferals = (response[0].refferals != null)? response[0].refferals : 0;
        var followups = (response[0].followups != null)? response[0].followups : 0;
        var dental = (response[0].dental != null)? response[0].dental : 0;

        $('.approvalPatientName').text(response[0].name);
        $('.consultationBadge').text(consultation);
        $('.laboratoryBadge').text(labs);
        $('.requisitionBadge').text(requisitions);
        $('.ultrasoundBadge').text(ultrasound);
        $('.xrayBadge').text(xray);
        $('.refferalBadge').text(refferals);
        $('.followupBadge').text(followups);
        $('.dentalBadge').text(dental);

        $('.recordsList').attr('data-pid', $scope);

        console.log(response);
        console.log(response[0].consultations);
        console.log(response[0].requisitions);
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });

    request.always(function(){
        // $('.loaderWrapper').fadeOut(0);
    });
}