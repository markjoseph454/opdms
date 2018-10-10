$( function() {
    $( "#datepicker" ).datepicker({
		dateFormat: 'yy-mm-dd',
        changeMonth: true,
		changeYear: true,
		yearRange: "-110:+0",
    });
});

$( function() {
    $( "#endingDate" ).datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        yearRange: "-110:+0",
    });
});


$( function() {
    $( "#referaldate" ).datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        yearRange: "-110:+0",
    });
});


$(document).ready(function () {
	$('.birthday').on('change', function(){
		var birthday = $(this).val();
			if (birthday != "") {
				var today = new Date();
				var birthDate = new Date(birthday);
				var age = today.getFullYear() - birthDate.getFullYear();
				var m = today.getMonth() - birthDate.getMonth();
				if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
				  age--;
				}
				$('#age').val(age)
			}else{
				return;
			}
	});
});

