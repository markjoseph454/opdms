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
	$("#edit-button").attr('data-id', id).removeClass('disabled');
	$("#remove-button").attr('data-id', id).removeClass('disabled');
	$("#print-button").attr('data-id', id).removeAttr('disabled');
	$('#patient-information').attr('data-id', id).closest('li').removeAttr('class');
	$('#medical-record').attr('data-id', id).closest('li').removeAttr('class');
	$('#patient-transaction').attr('data-id', id).closest('li').removeAttr('class');
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
	        if (response.civil_status) {
	        $(this).find('td.civil_status').text(response.civil_status);
	        }else{
	        $(this).find('td.civil_status').text('');
	        }
	        $(this).find('td.birthday').text(dateCalculate(response.birthday));
	        $(this).find('td.age').text(getAge(response.birthday));
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
		if (response[i].civil_status) {
			var td7 = $('<td>').addClass('civil_status').attr('align', 'center').text(response[i].civil_status);
		}else{
			var td7 = $('<td>').addClass('civil_status').attr('align', 'center').text('');
		}
		if (response[i].sex == 'M') {
		var td8 = $('<td>').addClass('sex').attr('align', 'center').text('Male');
		}else{
		var td8 = $('<td>').addClass('sex').attr('align', 'center').text('Female');
		}
		var td9 = $('<td>').addClass('birthday').text(dateCalculate(response[i].birthday));
		if (getAge(response[i].birthday) > 60) {
			var td13 = $('<td>').addClass('age').attr('class', 'text-red text-bold').attr('align', 'center').text(getAge(response[i].birthday));	
		}else{
			var td13 = $('<td>').addClass('age').attr('align', 'center').text(getAge(response[i].birthday));
		}
		
		if (response[i].brgyDesc) {
		var td10 = $('<td>').text(response[i].brgyDesc+' '+response[i].citymunDesc+', '+response[i].provDesc);
		}else{
		var td10 = $('<td>').text(response[i].citymunDesc+', '+response[i].provDesc);
		}
		var td11 = $('<td>').text(dateCalculate(response[i].regdate));
		if (response[i].printed == 'Y') {
		var td12 = $('<td>').attr('align', 'center').attr('class', 'print_status').html(' <small class="label bg-green">Printed</small>');
		}else{
		var td12 = $('<td>').attr('align', 'center').attr('class', 'print_status').html(' <small class="label bg-red">No</small>');
		}
		$(tr).append(td1, td2, td3, td4, td5, td6, td7, td8, td9, td13, td10, td11, td12);
		$('#patient-table tbody').append(tr);
	}
	// body...
}
function updateprinttbodycontent(response) {
	console.log(response);
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
    	var td7 = $('<td>').attr('align', 'center').html('<small class="label bg-green">Printed</small>');
    	}else{
    	var td7 = $('<td>').attr('align', 'center').html('<small class="label bg-red">No</small>');
    	}
    	$(tr).append(td0,td1,td2,td3,td4,td5,td6,td7);
    	$('.print-tbody').append(tr);
    }
}

function transactiontabletbody(paid)
{
	$('#paid-id-table tbody').empty();
	if (paid.length > 0) {
		for (var i = 0; i < paid.length; i++) {
			var tr = $('<tr>');
			var td = $('<td hidden>');
			var td1 = $('<td>').attr('align', 'right').text(paid[i].price.toFixed(2));
			var td2 = $('<td>').attr('align', 'center').text(paid[i].or_no);
			if (paid[i].middle_name) {
			var td3 = $('<td>').attr('class', 'text-capitalize').text(paid[i].last_name+', '+paid[i].first_name+', '+paid[i].middle_name);
			}else{
			var td3 = $('<td>').attr('class', 'text-capitalize').text(paid[i].last_name+', '+paid[i].first_name);
			}
			var td4 = $('<td>').attr('align', 'center').text(dateCalculate(paid[i].created_at));
			$(tr).append(td, td1, td2, td3, td4);
			$('#paid-id-table tbody').append(tr);
		}
	}else{
		var tr = $('<tr>');
		var td = $('<td hidden>');
		var td1 = $('<td>').attr('colspan', '5').attr('align', 'center').html('<span class="fa fa-warning"></span> Empty Data').css('font-weight', 'bold');
		$(tr).append(td, td1);
		$('#paid-id-table tbody').append(tr);

	}

}
function printedtabletbody(printed){
	$('#printed-id-table tbody').empty();
	if (printed.length > 0) {
		for (var i = 0; i < printed.length; i++) {
			var tr = $('<tr>');
			var td = $('<td hidden>');
			if (printed[i].middle_name) {
			var td3 = $('<td>').attr('class', 'text-capitalize').text(printed[i].last_name+', '+printed[i].first_name+', '+printed[i].middle_name);
			}else{
			var td3 = $('<td>').attr('class', 'text-capitalize').text(printed[i].last_name+', '+printed[i].first_name);
			}
			var td4 = $('<td>').attr('align', 'center').text(dateCalculate(printed[i].created_at));
			$(tr).append(td, td3, td4);
			$('#printed-id-table tbody').append(tr);
		}
	}else{
		var tr = $('<tr>');
		var td = $('<td hidden>');
		var td1 = $('<td>').attr('colspan', '3').attr('align', 'center').html('<span class="fa fa-warning"></span> Empty Data').css('font-weight', 'bold');
		$(tr).append(td, td1);
		$('#printed-id-table tbody').append(tr);

	}

}

// function isInArray(value, array) {
//   return array.indexOf(value) > -1;
// }
