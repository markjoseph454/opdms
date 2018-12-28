// template for table
var table = template_table();

function create_consultation_editor() { // empty form on saving the consultation initially
    tinymce.init({
        path_absolute : baseUrl+"/",
        selector: "textarea#create_consultation_editor",
        plugins: [
            "save advlist lists charmap preview hr tabfocus",
            "searchreplace wordcount fullscreen",
            "insertdatetime nonbreaking directionality",
            "emoticons template paste textcolor colorpicker textpattern noneditable preventdelete"
        ],
        toolbar: "save | insertfile | styleselect fontsizeselect forecolor backcolor |" +
            " bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | " +
            "outdent indent | link media cut",

        fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
        templates: [
            {title: 'Doctors Consultation', description: 'Doctors Consultation Form', content: table}
        ],
        tabfocus_elements: "button",
        insertdatetime_formats: ["%b %d, %Y %H:%M %p", "%b %d, %Y", "%I:%M:%S %p", "%D"],
        table_toolbar: false,
        relative_urls: false,
        branding:false,
        removed_menuitems: 'newdocument',
        content_css: baseUrl+'/public/OPDMS/css/partials/texteditor.css',
        paste_block_drop: true, // disable drag event
        // init_instance_callback: "insert_contents",
        setup : function(ed) {
            ed.on('BeforeAddUndo', function(e) {
                return false;
            });
        },
        save_onsavecallback: function(){
            save_consultation_form();
        },





    });
}




// callback from save consultation
function save_consultation_form(){
    $('#create_consultation_modal .loaderRefresh').fadeIn(0);
    var root_element = queue_vue;
    var data = $('#create_consultation_form').serialize();
    request = $.ajax({
        url: baseUrl+"/consultation_save",
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: data,
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
        // attach consultation id for editing the form
        root_element.consultation_open_patch = response.id;
        // show nurse notes print btn
        root_element.show_nurse_notes_print = true;
        // create nurse notes print link
        root_element.show_nurse_notes_print_link = baseUrl+'/printNurseNotes/'+response.id;

        //show blank consultation form btn
        root_element.new_blank_nurse_form = true;

        toast('success', 'Consultation successfully saved.');
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('#create_consultation_modal .loaderRefresh').fadeOut('fast');
    });
}



$('.just_close').on('click', function () {
    $('.close_consultation_form').fadeOut('fast');
    $('#create_consultation_modal').modal('hide');
});

$('.just_cancel').on('click', function () {
    $('.close_consultation_form').fadeOut('fast');
});



$('.close_and_end_consultation').on('click', function () {
    var root_element = queue_vue;
    $('.close_consultation_form').find('.loaderRefresh').fadeIn(0);
    request = $.ajax({
        url: baseUrl+"/end_consultation",
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'pid':root_element.pid},
    });
    request.done(function (response, textStatus, jqXHR) {
        location.reload();
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
    });
});


// $('#create_consultation_modal').on('hide.bs.modal', function () {
// });

$('.close_create_consultation').on('click', function () {
    $('.close_consultation_form').fadeIn(0);
});




//
//
// // prompt if modal is about to be closed
// $('#nurse_notes_modal').on('hidden.bs.modal', function () {
//     var ans = confirm('Warning! any changes that was not been saved will be lost.');
//     if (ans){
//         $('#nurse_notes_modal').modal('hide');
//         queue_vue.nurse_notes_id = '';
//
//
//         if(queue_vue.nurse_notes_consultation_single_open == 'single_open'){
//             if (queue_vue.opened_consultation){
//                 queue_vue.show_consultation(queue_vue.opened_consultation);
//             }
//         }
//
//         // reload show all consultation modal
//         if(queue_vue.nurse_notes_consultation_single_open == 'multiple_open'){
//             queue_vue.consultation_show_all();
//         }
//
//
//     } else{
//         $('#nurse_notes_modal').modal('show');
//     }
//
// });
//
//
// // delete the opened consultation id
// $('#consultation_show_modal').on('hidden.bs.modal', function () {
//     queue_vue.opened_consultation = '';
// });
//
// // highlight consultation btn on medical records
// $('#medical_records_modal').on('show.bs.modal', function () {
//     $('#medical_records_div_menu_container').find('a.highlight_consultation_menu').addClass('bg-light-blue');
// });
//
// // remove color on all consultation btn on medical records
// $('#medical_records_modal').on('hidden.bs.modal', function () {
//     $('#medical_records_div_menu_container a').each(function (index) {
//         $(this).removeClass('bg-light-blue');
//     });
// });


function referral_selected_clinic($scope) {
    var id = $($scope).val();
    queue_vue.referral_to_clinic(id);
}


