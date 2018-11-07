$(document).on('click', '#check-patient-toggle', function(){
	modalCheckpatient();
})
$(document).on('click', '#edit-button', function(){
	var id = $(this).attr('data-id');
	if (id == "#") {
		toastr.error('Kindly Select Patient Record First');
	}else{
		edit_patient(id);
	}
})

$(document).on('click', '#print-button', function(){
	var id = $(this).attr('data-id');
	if (id == "#") {
		toastr.error('Kindly Select Patient Record First');
	}else{
		$(this).attr('href', baseUrl+'/patients/'+id);
		$(this).attr("target", "_blank")
	}
})

$(document).on('click', '#remove-button', function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('status');
	if (id == '#') {
		toastr.error('Kindly Select Patient Record First');
	}else{
		if (status == "cancel") {
			cancelRemoveRequest(id);
		}else{
			removePatientInfo(id);
		}
	}
});

var something = $('.trial-click');
$('#patient-table tbody tr').mousedown(function(event) {
	
    switch (event.which) {
        
        case 3:
        	var id = $(this).attr('data-id');
        	foractionandtr($(this));
        	something.slideDown('fast');
        	something.css({
        		// display: "block",
        		left: event.pageX-235,
        		top: event.pageY-100
        	});
        	$('.trial-click button, .trial-click a').attr('data-id', id);
        	return false;
            // alert('Right mouse button is pressed');
        break;
    }
});
$('html').click(function() {
        something.slideUp('fast');
});