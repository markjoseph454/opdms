setTimeout(function () {
    request = $.ajax({
        url: baseUrl+'/auth_expired',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        if (!response){
            $('.auth_expired_section').slideDown('slow');
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
    });
}, 900000); // check if auth expired every 15 minutes