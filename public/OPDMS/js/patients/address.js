var region = "";
var province = "";
var city_municipality = "";
var brgy = "";
var citymunCode = "";
var brgyId = "";
var action = "";

$(document).on('focus', '.modal-body .address', function(){
	var add = $(this);
	$('#modal-address').modal('toggle');
	action = $(add).attr('action');
})

$('#modal-address').on('shown.bs.modal', function(){
    $('#modal-address select[name="province"]').focus();
});


/*---------------------------- REGION --------------------------*/


$(document).ready(function () {
	request = $.ajax({
		url: baseUrl+"/regions",
		type: "get",
		dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {

		if (response.length > 0) {
			for (var i = 0 ; i < response.length; i++) {
				var selected = "";
				if (response[i].regCode == '08') {
					selected = "selected";
					region = response[i].regDesc;
					// console.log(response[i].regDesc);
				}
				var option = $('<option '+ selected +'>').val(response[i].regCode).text(response[i].regDesc);
				$("select[name='region']").append(option);
			}
			showProvince($("select[name='region']"));
		}
	});

	request.fail(function (jqXHR, textStatus, errorThrown){
       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
   	});

});




/*----------------------- PROVINCE ------------------------*/


	function showProvince(scope){
		var regCode = $(scope).val();
		region = $("select[name='region'] option[value="+regCode+"]").text();
		$("."+action+"-address").val(region);


		request = $.ajax({
			url: baseUrl+"/province",
			type: "post",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {'regCode':regCode},
			dataType: "json"
		});

		request.done(function (response, textStatus, jqXHR) {
			$("select[name='province']").empty().prepend('<option>Select Province</option>');
			// console.log(response);
			if (response.length > 0) {
				for (var i = 0 ; i < response.length; i++) {
					var option = $('<option>').val(response[i].provCode).text(response[i].provDesc);
					$("select[name='province']").append(option);
				}
				var spin = $('<i class="fa fa-spinner fa-spin text-success">');
				$('.provinceLabel').append(spin);
				errorHide();
			}
		});

		request.fail(function (jqXHR, textStatus, errorThrown){
	       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
	   	});

	   	request.always(function(){
			$('.provinceLabel').find('i').fadeOut('slow');
	   	});

	}


/*----------------------- CITY / MUNICIPALITY ------------------------*/

	$(document).on('change', 'select[name="province"]', function () {
		var provCode = $(this).val();
		province = $("select[name='province'] option[value="+provCode+"]").text();
		$("."+action+"-address").val(region+', '+province);

		request = $.ajax({
			url: baseUrl+"/city_municipality",
			type: "post",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {'provCode':provCode},
			dataType: "json"
		});

		request.done(function (response, textStatus, jqXHR) {
			$("select[name='city_municipality']").empty().prepend('<option>Select City/Municipality</option>');
			if (response.length > 0) {
				for (var i = 0 ; i < response.length; i++) {
					var option = $('<option>').val(response[i].citymunCode).text(response[i].citymunDesc);
					$("select[name='city_municipality']").append(option);
				}
				var spin = $('<i class="fa fa-spinner fa-spin text-success">');
				$('.citymunicipalityLabel').append(spin);
			}
		});

		request.fail(function (jqXHR, textStatus, errorThrown){
	       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
	   	});

	   	request.always(function(){
			$('.citymunicipalityLabel').find('i').fadeOut('slow');
	   	});
	});

/*----------------------- BARANGAY ------------------------*/

	$(document).on('change', "select[name='city_municipality']", function(){

		citymunCode = $(this).val();
		$('.city_municipality_modal').val(citymunCode);
		city_municipality = $("select[name='city_municipality'] option[value="+citymunCode+"]").text();
		$("."+action+"-address").val(region+', '+province+', '+city_municipality);

		request = $.ajax({
			url: baseUrl+"/brgy",
			type: "post",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {'citymunCode':citymunCode},
			dataType: "json"
		});

		request.done(function (response, textStatus, jqXHR) {
			$("select[name='brgy']").empty().prepend('<option>Select Brgy</option>');;
			if (response.length > 0) {
				for (var i = 0 ; i < response.length; i++) {
					var option = $('<option>').val(response[i].id).text(response[i].brgyDesc);
					$("select[name='brgy']").append(option);
				}
				var spin = $('<i class="fa fa-spinner fa-spin text-success">');
				$('.brgyLabel').append(spin);
			}
		});

		request.fail(function (jqXHR, textStatus, errorThrown){
	       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
	   	});

	   	request.always(function(){
			$('.brgyLabel').find('i').fadeOut('slow');
	   	});
	});

	$(document).ready(function () {
		$(document).on('change', "select[name='brgy']", function () {
			brgy = $("select[name='brgy'] option[value="+$(this).val()+"]").text();
			brgyId = $("select[name='brgy']").val(); 
			$('.brgy_modal').val(brgyId);
			$("."+action+"-address").val(region+', '+province+', '+city_municipality+', '+brgy);
		});
	});

	$(document).on('click', '#clone-address', function(){
		$("."+action+"-address").val(region+', '+province+', '+city_municipality+', '+brgy);
		$('.city_municipality_modal').val(citymunCode);
		$('.brgy_modal').val(brgyId);
	});

	function errorHide() {
		$('p.text-danger').fadeOut(0);
	}



















