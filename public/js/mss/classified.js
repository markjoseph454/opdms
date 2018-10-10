$(document).ready(function() {
    $('#classifiedTable').DataTable();
});
// $(document).ready(function() {
// 	$(window).on('load',function(){
//         $('#choosedatemodal').modal('show');
//     });
// })
$(document).ready(function(){
    $('.calendar').click(function(){
        $('#choosedatemodal').modal('toggle');
    })

});
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
$(window).load(function(){
	// $('#classifiedTable_filter').hide();
})