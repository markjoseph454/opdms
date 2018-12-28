$('#passwordaddon').on('click', function () {
    var input = $('input[name="password"]');
    var type = $(input).attr('type');
    if (type == 'text'){
        $(input).attr('type','password');
        $('#passwordaddon i').removeClass('fa-lock');
        $('#passwordaddon i').addClass('fa-unlock-alt');
    }else{
        $(input).attr('type','text');
        $('#passwordaddon i').removeClass('fa-unlock-alt');
        $('#passwordaddon i').addClass('fa-lock');
    }
});


/*$('input[name="password"]').on("keyup", function(event) {
    // If "caps lock" is pressed, display the warning text
    if (event.getModifierState("CapsLock")) {
        $('.capslockon').fadeIn('slow');
    } else {
        $('.capslockon').fadeOut('slow');
    }
});*/


var input = document.getElementById("pass_input");
// When the user presses any key on the keyboard, run the function
input.addEventListener("keyup", function(event) {
    // If "caps lock" is pressed, display the warning text
    if (event.getModifierState("CapsLock")) {
        $('.capslockon').fadeIn('slow');
    } else {
        $('.capslockon').fadeOut('slow');
    }
});
