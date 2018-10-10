function checkRadiology($scope) {
    event.preventDefault();
    $('.medsPrint').fadeOut(0);
    $("#recordsModal").modal();
    $('.loaderWrapper').fadeIn(0);
    var pid = $($scope).attr('data-pid');
    var category = $($scope).attr('data-category');
    $('#recordsHeaderTitle').text($($scope).attr('data-title'));

    request = $.ajax({
        url: baseUrl+'/ultrasoundShow',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'patient':pid,'category':category},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        console.log(response)
        $('.recordsThead').empty();
        $('.medsWatchTbody').empty();
        var thead = labsThead();
        $('.recordsThead').append(thead);
        if (response.length > 0) {
            for (var i = 0; i < response.length; i++) {
                var content = labContent(response, i);
                $('.medsWatchTbody').append(content);
            }
            $('#recordsModal').modal();
        }else{
            $('.medsWatchTbody').append(noResults());
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}



function labContent(response, $i) {
    if (response[$i].get == null){
        var status = '<span class="label label-danger">Pending</span>';
        var disable = 'disabled';
    }else{
        if (response[$i].get == 'N'){
            var status = '<span class="label label-danger">Pending</span>';
            var disable = 'disabled';
        }else{
            var status = '<span class="label label-primary">Finished</span>';
            var disable = '';
        }
    }
    var authenticate = (response[$i].users_id == auth)? '' : 'disabled';
    var content = '<tr>\n' +
        '                                <td>'+response[$i].doctorsname+'</td>\n' +
        '                                <td>'+response[$i].name+'</td>\n' +
        '                                <td>'+response[$i].sub_category+'</td>\n' +
        '                                <td>₱ '+response[$i].price+'.00</td>\n' +
        '                                <td>'+formatDate(response[$i].created_at)+'</td>\n' +
        '                                <td>\n' +
        '                                    '+status+'\n' +
        '                                </td>\n' +
        '                                <td>\n' +
        '                                    <a href="'+baseUrl+'/radiologyPrint/'+response[$i].rid+'" target="_blank"  class="btn btn-sm btn-success '+disable+'">\n' +
        '                                        <i class="fa fa-file-text-o"></i> Result\n' +
        '                                    </a>\n' +
        '                                </td>\n' +
        '                            </tr>';
    return content;
}

/*onclick="radiologyResult('+response[$i].rid+')"*/



function labsThead() {
    var thead = '<tr>\n' +
        '                            <th>REQUESTED_BY</th>\n' +
        '                            <th>CLINIC</th>\n' +
        '                            <th>DESCRIPTION</th>\n' +
        '                            <th>PRICE</th>\n' +
        '                            <th>DATE</th>\n' +
        '                            <th>STATUS</th>\n' +
        '                            <th>VIEW RESULT</th>\n' +
        '                        </tr>';
    return thead;
}

function noResults() {
    var noResult = '<tr>\n' +
        '                                    <td colspan="8" class="text-center">\n' +
        '                                        <h5><strong class="text-danger">\n' +
        '                                            No Results Found <i class="fa fa-exclamation"></i>\n' +
        '                                        </strong></h5>\n' +
        '                                    </td>\n' +
        '                                </tr>';
    return noResult;
}