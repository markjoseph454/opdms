$(document).on('click', '#patient-information', function(){
	var id = $(this).attr('data-id');
	if (id == '#') {
		toastr.error('Kindly Select Patient Record First');
	}else{
		getpatientInformation(id);
		// $('#patient_information_modal').modal('toggle');
	}
});

$(document).on('click', '#medical-record', function(){
	var id = $(this).attr('data-id');
	// alert(id);
		// toastr.info('Feature is under Development mode\n sorry for the Inconvenience');

	if (id == '#') {
		toastr.error('Kindly Select Patient Record First');
	}else{
		medicalRecords(id)
		
	}
});

$(document).on('click', '#history-record', function(){
	var id = $(this).attr('data-id');
		toastr.info('Under Maintainance');

	// if (id == '#') {
	// 	toastr.error('Kindly Select Patient Record First');
	// }else{
	// 	// medicalRecords(id)
		
	// }
});

$(document).on('click', '#patient-transaction', function(){
	var id = $(this).attr('data-id');
	if (id == '#') {
		toastr.error('Kindly Select Patient Record First');
	}else{
		getpatienttransaction(id);
	}
})