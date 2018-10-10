function openHamburger(x) {
    x.classList.toggle("change");
}

$(document).ready(function () {
	$('.hamburger').on('mouseenter', function(){
           $(this).css('background-color','transparent');
    }) ;
});


var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({container: "body"});
});



$(document).ready(function(){
    $('.dropdown-submenu a.test').on("click", function(e){
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });
});




/*--- Date Time ---*/
function timeCalculate($date){
    var d = new Date($date);
    var days = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    var hour = d.getHours();
    var min = d.getMinutes();
    if(hour < 10){
        hour = '0'+hour;
    }
    if(min < 10){
        min = '0'+min;
    }
    var today = month+' '+day+', '+year+' '+hour+':'+min;
    return today;
}


/*--- Date Time ---*/
function hourMinCalculate($date){
    var d = new Date($date);
    var hour = d.getHours();
    var min = d.getMinutes();
    if(hour < 10){
        hour = '0'+hour;
    }
    if(min < 10){
        min = '0'+min;
    }
    var hourMin = hour+':'+min;
    return hourMin;
}

function dateCalculate($date){
    var d = new Date($date);
    var days = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    var today = month+' '+day+', '+year;
    return today;
}
