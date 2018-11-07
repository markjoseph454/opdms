$(document).ready(function () {

    /*-- Generate Password --*/
    $('#generatePassword').on('click', function (e) {
        e.preventDefault();

        $(document).ready(function () {
            request = $.ajax({
                url: baseUrl+'/generatePassword',
                type: "get",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: "json"
            });
            request.done(function (response, textStatus, jqXHR) {
                console.log(response);
                $('.password').val(response);
            });
        });

    });




    $('#showPassword').on('click', function () {
        event.preventDefault();
        var toggle = $(this).attr('toggle');
        if (toggle == 'on'){
            var eye = $('<i class="fa fa-eye-slash">');
            $(this).text('Hide ').append(eye);
            $('.password').attr('type','text');
            $(this).attr('toggle', 'off')
        }else{
            var eye = $('<i class="fa fa-eye">');
            $(this).text('Show ').append(eye);
            $('.password').attr('type','password');
            $(this).attr('toggle', 'on')
        }
    });


});



/*--- Decrypt Password ---*/
function decryptPassword($scope) {
    event.preventDefault();
    $uid = $($scope).attr('data-uid');
    request = $.ajax({
        url: baseUrl+'/decryptPassword',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'user':$uid},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        var div = $($scope).closest('div.userlistBtnWrapper').
        siblings('div.userDetailsList').find('li.listPassword');
        $(div).slideDown('slow');
        $(div).find('span.password').text(response);
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
        toastr.error('Oops! something went wrong.');
    });
    request.always(function (){
        console.log("To God Be The Glory...");
        $($scope).addClass('disabled');
    });
}




