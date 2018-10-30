$(document).on('click', 'table tbody tr', function(){
	foractionandtr($(this));
	
})
function foractionandtr(scope) {
	var table_id = $(scope).closest('table').attr('id');
		var id = $(scope).attr('data-id');
		$(scope).addClass("selected").siblings().removeClass("selected");

		if (table_id == 'patient-table') {
			action_button(id);
		}else{
			$('#modal-check-result #select-active-record').attr('data-id', id);
		}
		// console.log(scope.attr('status'));
		if (scope.attr('status') == "remove") {
			// alert(1);
			$('#remove-button').html('<span class="fa fa-reply"></span> Cancel').attr('status', 'cancel');
			$('.trial-click #remove-button').html('<span class="fa fa-reply"></span> Cancel').attr('status', 'cancel');
		}else{
			// alert(2);
			$('#remove-button').html('<span class="fa fa-trash"></span> Remove').attr('status', '');
			$('.trial-click #remove-button').html('<span class="fa fa-trash"></span> Remove').attr('status', '');
		}
}

function action_button(id) {
	$("#edit-button").attr('data-id', id);
	$("#remove-button").attr('data-id', id);
	$("#print-button").attr('data-id', id);
	$('#patient-information').attr('data-id', id);
	$('#medical-record').attr('data-id', id);
}

function result_tbody(response){
	$('.result-tbody').empty();
	for (var i = 0; i < response.length; i++) {
		$('.result-count').text(response.length);
		var tr = $('<tr>').attr('data-id', response[i].id);
		var td0 = $('<td>').html('<span class="fa fa-caret-right"></span>')
		var td1 = $('<td>').attr('align', 'center').text(response[i].hospital_no);
		var td2 = $('<td>').text(response[i].last_name);
		var td3 = $('<td>').text(response[i].first_name);
		if (response[i].middle_name) {
		var td4 = $('<td>').text(response[i].middle_name);
		}else{
		var td4 = $('<td>').text('N/A');
		}
		if (response[i].birthday == "0000-00-00") {
		var td5 = $('<td>').attr('align', 'center').text("N/A");
		}else{
		var td5 = $('<td>').attr('align', 'center').text(dateCalculate(response[i].birthday));
		}
		if (response[i].sex == "M") {
		var td6 = $('<td>').attr('align', 'center').text('Male');
		}else{
		var td6 = $('<td>').attr('align', 'center').text('Female');
		}
		$(tr).append(td0,td1,td2,td3,td4,td5,td6);
		$('.result-tbody').append(tr);
	}
}


function updateRowContent_patient(patient_id, response){
	console.log(response);
	$('#patient-table tbody tr').each(function(){
	    var id = $(this).attr('data-id');
	    if (patient_id == id) {
	        $(this).find('td.last_name').text(response.last_name);
	        $(this).find('td.first_name').text(response.first_name);
	        $(this).find('td.middle_name').text(response.middle_name);
	        if (response.suffix) {
	        $(this).find('td.suffix').text(response.suffix);
	        }else{
	        $(this).find('td.suffix').text('');
	        }
	        if (response.sex == 'F') {
	        $(this).find('td.sex').text('Female');
	        }else{
	        $(this).find('td.sex').text('Male');
	        }
	        $(this).find('td.birthday').text(dateCalculate(response.birthday));
	        if (city_municipality != '') {
	        	$(this).find('td.address').text(brgy+' '+city_municipality+', '+province);
	        }
	    }
	});
}


function refreshpatienttableContentController(response) {
	$('#patient-table tbody').empty();
	$('#main-page .box-footer .text-muted').hide();
	for (var i = 0; i < response.length; i++) {
		var tr = $('<tr>').attr('data-id', response[i].id);
		var td1 = $('<td>').html('<span class="fa fa-caret-right"></span>');
		var td2 = $('<td>').html('<span class="fa fa-user-o"></span>');
		var td3 = $('<td>').text(response[i].hospital_no);
		var td4 = $('<td>').addClass('last_name').text(response[i].last_name);
		var td5 = $('<td>').addClass('first_name').text(response[i].first_name);
		var td6 = $('<td>').addClass('middle_name').text(response[i].middle_name);
		if (response[i].suffix) {
			var td7 = $('<td>').addClass('suffix').text(response[i].suffix);
		}else{
			var td7 = $('<td>').addClass('suffix').text('');
		}
		if (response[i].sex == 'M') {
		var td8 = $('<td>').addClass('sex').text('Male');
		}else{
		var td8 = $('<td>').addClass('sex').text('Female');
		}
		var td9 = $('<td>').text(dateCalculate(response[i].birthday));
		if (response[i].brgyDesc) {
		var td10 = $('<td>').text(response[i].brgyDesc+' '+response[i].citymunDesc+', '+response[i].provDesc);
		}else{
		var td10 = $('<td>').text(response[i].citymunDesc+', '+response[i].provDesc);
		}
		var td11 = $('<td>').text(dateCalculate(response[i].regdate));
		$(tr).append(td1, td2, td3, td4, td5, td6, td7, td8, td9, td10, td11);
		$('#patient-table tbody').append(tr);
	}
	// body...
}
function updateprinttbodycontent(response) {
	$('.print-tbody').empty();
	for (var i = 0; i < response.length; i++) {
    	$('.print-count').text(response.length);
    	var tr = $('<tr>').attr('data-id', response[i].id);
    	var check = 'checked';
    	if($.inArray(""+response[i].id+"", value_id) == -1){
    		check = '';
    	}
    	var td0 = $('<td>').attr('align', 'center').html('<input type="checkbox" value="'+response[i].id+'" class="check" '+check+'>');
    	var td1 = $('<td>').attr('align', 'center').text(response[i].hospital_no);
    	var td2 = $('<td>').text(response[i].last_name);
    	var td3 = $('<td>').text(response[i].first_name);
    	if (response[i].middle_name) {
    	var td4 = $('<td>').text(response[i].middle_name);
    	}else{
    	var td4 = $('<td>').text('N/A');
    	}
    	if (response[i].birthday == "0000-00-00") {
    	var td5 = $('<td>').attr('align', 'center').text("N/A");
    	}else{
    	var td5 = $('<td>').attr('align', 'center').text(dateCalculate(response[i].birthday));
    	}
    	if (response[i].sex == "M") {
    	var td6 = $('<td>').attr('align', 'center').text('Male');
    	}else{
    	var td6 = $('<td>').attr('align', 'center').text('Female');
    	}
    	if (response[i].printed == "Y") {
    	var td7 = $('<td>').attr('align', 'center').html('<small class="label bg-green">Yes</small>');
    	}else{
    	var td7 = $('<td>').attr('align', 'center').html('<small class="label bg-red">No</small>');
    	}
    	$(tr).append(td0,td1,td2,td3,td4,td5,td6,td7);
    	$('.print-tbody').append(tr);
    }
}

// function isInArray(value, array) {
//   return array.indexOf(value) > -1;
// }
