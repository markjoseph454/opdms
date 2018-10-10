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

                var file_text = $('<i class="fa fa-file-text-o">');
                var anchor = $('<a href="'+baseUrl+'/rcptn_consultationDetails/'+response[i].id+'" target="_blank" ' +
                    'title="Click to view medical records" class="btn btn-success btn-sm">').text(' View Consultation');
                $(anchor).prepend(file_text);
                var tr = $('<tr>');
                var td1 = $('<td>').text(response[i].name);
                var td2 = $('<td>').text(response[i].clinic);
                var td3 = $('<td>').text(response[i].doctor);
                var td4 = $('<td>').text(today);
                var td5 = $('<td>').append(anchor);
                $('.consultationListTbody').append($(tr).append(td1,td2,td3,td4,td5));
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