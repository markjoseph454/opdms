function dateCalculate($date){
    var d = new Date($date);
    var days = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    if (day < 10) {
        day = '0'+day;
    }
    var today = month+'/'+day+'/'+year;
    return today;
}

function mysqlDateformat($date){
    var d = new Date($date);
    var days = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
     if (day < 10) {
        day = '0'+day;
    }
    var today = year+'-'+month+'/'+day;
    return today;
}
function calculateAge(birthday) {
        var d = new Date(birthday);
        var days = [1,2,3,4,5,6,7,8,9,10,11,12];
        var dobMonth = days[d.getMonth()];
        var dobDay = d.getDate();
        var dobYear = d.getFullYear();

        var bthDate, curDate, days;
        var ageYears, ageMonths, ageDays;

            bthDate = new Date(dobYear, dobMonth-1, dobDay);
            curDate = new Date(dateToday);
        
        var ageText = '';

            ageYears = curDate.getFullYear() - bthDate.getFullYear();
            ageMonths = curDate.getMonth() - bthDate.getMonth();
            ageDays = curDate.getDate() - bthDate.getDate(); 

                if (ageDays < 0) {
                    ageMonths = ageMonths - 1;
                    ageDays = ageDays + 31;
                }
                ageWeeks = ageDays;
                if (ageMonths < 0) {
                    ageYears = ageYears - 1;
                    ageMonths = ageMonths + 12;
                }
                ageText = "";
                ageText = ageText + ageYears + "Y";
                ageText = ageText + ageMonths + "M";
                ageText = ageText + ageWeeks + "D";
                return ageText;

};

$('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' });
$('[data-mask]').inputmask();

$( function() {
    $( "#datemask2" ).datepicker({
        dateFormat: 'mm/dd/yyyy',
        changeMonth: true,
        changeYear: true,
        yearRange: "-110:+0",
        maxDate: 'today',
    });
});


function getallclinics(triage){
    request = $.ajax({
        url: baseUrl+'/registerclinics',
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        $('.clinic_code').empty();
        var opt = $('<option>').attr('value', "").attr('hidden', true).text('--');
        $('.clinic_code').append(opt);
        for (var i = 0;i < response.length; i++) {

            if (triage && triage.clinic_code == response[i].code) {
            var option = $('<option>').attr('value', response[i].code).attr('selected', true).text(response[i].name);
            }else{
            var option = $('<option>').attr('value', response[i].code).text(response[i].name);
            }
            $('.clinic_code').append(option);
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
        toastr.error('Oops! something went wrong.');
    });
    request.always(function (response){
        console.log("To God Be The Glory...");
    });
}



function refreshpatienttableContent(){
    $('#main-page .loaderRefresh').fadeIn('fast');

    request = $.ajax({
        url: baseUrl+'/RegisteredToday',
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
        refreshpatienttableContentController(response);
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
        toastr.error('Oops! something went wrong.');
    });
    request.always(function (response){
        console.log("To God Be The Glory...");
        $('#main-page .loaderRefresh').fadeOut('fast');
    });
}


function clearinputs(){
    $('.modal .hospital_no').val('');
    $('.modal .last_name').val('');
    $('.modal .first_name').val('');
    $('.modal .middle_name').val('');
    $('.modal .suffix').val('');
    $('.modal .birthday').val('');
    $('.modal .sex').val('');
    $('.modal .civil_status').val('');
    $('.modal .contact_no').val('');
    $('.modal .address').val('');
    $('.modal .city_municipality_modal').val('');
    $('.modal .brgy_modal').val('');
    $('.modal .clinic_code').val('');
    $('.modal .weight').val('');
    $('.modal .height').val('');
    $('.modal .blood_pressure').val('');
    $('.modal .pulse_rate').val('');
    $('.modal .respiration_rate').val('');
    $('.modal .body_temperature').val('');
}