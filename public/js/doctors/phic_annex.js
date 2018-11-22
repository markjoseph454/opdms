
$(document).ready(function () {
   $('.phic_btn').on('click', function () {
        event.preventDefault();

       $('#phicAnnexModal').modal();

       var check = $('#phicAnnexModal #phicTbody').has('tr').length;
       if (!check){

           $('#phicAnnexModal .loaderWrapper').fadeIn(0);

           request = $.ajax({
           url: baseUrl+'/phic_annex',
           type: "post",
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           dataType: "json"
       });

       request.done(function (response, textStatus, jqXHR) {
           console.log(response);
           $.each(response, function (index) {
               var tr = $('<tr>');
               var input = $('<input type="checkbox" data-desc="'+response[index].description+'" onclick="phic_selected('+""+response[index].id+""+', '+response[index].rvs_code+', $(this))">');
               var td1 = $('<td>').append(input);
               var td2 = $('<td>').text(response[index].rvs_code);
               var td3 = $('<td>').text(response[index].description);
               $(tr).append(td1,td2,td3);
               $('#phicTbody').append(tr);
           });
       });

       request.fail(function (jqXHR, textStatus, errorThrown){
           console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
       });

       request.always(function(){
           $('#phicAnnexModal .loaderWrapper').fadeOut('fast');
       });

       }

   })
});


function phic_selected($id, $icd, $scope)
{
    var desc = $($scope).attr('data-desc');
    if ($id.toString().length == 1){
        $id = "000" + $id;
    }else if($id.toString().length == 2){
        $id = '00'+$id;
    }else if ($id.toString().length == 3){
        $id = '0'+$id;
    }
    var icd = '<strong class="mceNonEditable">RVS_'+ $id +' '+desc+' &nbsp;</strong>';
    tinymce.activeEditor.execCommand('mceInsertContent', false, icd);
}














