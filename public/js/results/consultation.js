/*----------- ajax for consultation -------*/

function checkConsultation($scope) {

    event.preventDefault();
    $("#consultationModal").modal();
    $('.loaderWrapper').fadeIn(0);
    var pid = $($scope).attr('data-pid');

    request = $.ajax({
        url: baseUrl+'/approvalConsultationList',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'patient':pid},
        dataType: "json"
    });




    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
        $('.consultationListTbody').empty();

        if (response.length > 0) {
            for (var i=0;i<response.length;i++){
                var today = getCustomDate(response[i].created_at);
                var inf_id = (response[i].inf_id)? '' : 'disabled';

                var file_text = $('<i class="fa fa-file-text-o">');
                /*var anchor = $('<a href="'+baseUrl+'/medical/'+response[i].id+'" target="_blank" ' +
                    'title="Click to view medical records" class="btn btn-success btn-sm">').text(' View Consultation');
                $(anchor).prepend(file_text);*/
                var anchor = $('<a href="#" onclick="viewConsultation('+response[i].id+')" ' +
                'title="Click to view medical records" class="btn btn-success btn-sm">').text(' View Consultation');
                if(response[i].inf_id){
                    var anchor2 = $('<a href="'+baseUrl+'/industrialPreview/'+response[i].id+'" ' +
                    'target="_blank" title="Click to view industrial form" class="btn btn-warning btn-sm '+ inf_id + '">').text('Industrial Consultation');
                }else{
                    var anchor2 = '';
                }

                if(response[i].otc_pid != null || response[i].childhood_pid != null || response[i].kmc_pid != null){
                    var anchor3 = $('<button class="btn btn-info btn-sm" onclick="showPediaForms('+response[i].patients_id+')">').text('Pedia')
                }else{
                    var anchor3 = '';
                }

                $(anchor).prepend(file_text);
                var tr = $('<tr>');
                var td1 = $('<td>').text(response[i].name);
                var td2 = $('<td>').text(response[i].clinic);
                var td3 = $('<td>').text(response[i].doctor);
                var td4 = $('<td>').text(today);
                var td5 = $('<td>').append(anchor);
                var td6 = $('<td>').append(anchor2, anchor3);
                $('.consultationListTbody').append($(tr).append(td1,td2,td3,td4,td5,td6));
            }
        }else{
            var strong = $('<strong>').text('NO RESULTS FOUND !');
            var tr = $('<tr>');
            var td1 = $('<td colspan="5" class="text-center text-danger">').append(strong);
            $('.consultationListTbody').append($(tr).append(td1));
        }

    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}




function viewConsultation($cid) {
    event.preventDefault();
    $('.loaderWrapper').fadeIn(0);
    request = $.ajax({
        url: baseUrl+'/consultationWatch',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'cid':$cid},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        $('.consultationContent').empty();
        $('.consultationContent').append(response.consultation);
        $('.consultationFormPrint').attr('href',baseUrl+'/print/'+response.id);
        if (auth == response.users_id){
            $('.consultationFormEdit').attr('href',baseUrl+'/consultation/'+response.id+'/edit').removeClass('disabled');
            $('.consultationFormDelete').attr('href',baseUrl+'/consultationdelete/'+response.id).removeClass('disabled');
        }else{
            $('.consultationFormEdit').addClass('disabled');
            $('.consultationFormDelete').addClass('disabled');
        }
        $('#consultationDetailsModal').modal();
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}