// template for table
var table = template_table();

function nurse_notes_editor() { // empty form on saving the consultation initially
    tinymce.init({
        path_absolute : baseUrl+"/",
        selector: "textarea#nurse_notes_editor",
        plugins: [
            "save advlist lists charmap preview hr tabfocus",
            "searchreplace wordcount fullscreen",
            "insertdatetime nonbreaking directionality",
            "emoticons template paste textcolor colorpicker textpattern noneditable preventdelete"
        ],
        toolbar: "save | insertfile | styleselect fontsizeselect forecolor backcolor |" +
            " bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | " +
            "outdent indent | link media",

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
        // init_instance_callback: "insert_contents",
        setup : function(ed) {
            ed.on('BeforeAddUndo', function(e) {
                return false;
            });
        },
        save_onsavecallback: function(){
            save_nurse_notes();
        }
    });
}


// callback from save consultation nurse notes only
function save_nurse_notes(){
    $('#nurse_notes_modal .loaderRefresh').fadeIn(0);
    var data = $('#nurse_notes_form').serialize();
    request = $.ajax({
        url: baseUrl+"/nurse_notes_save",
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: data,
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        console.log(response)
        if (response['consultation']){
            queue_vue.nurse_notes_id = response['consultation'].id; // assign consultation id for updating
            toast('info', 'Nurse notes successfully saved.');
        } else{ // you cannot save nurse if patient is not pending or unassigned
            toast('error', 'Unable to save nurse notes, patient is already being served.');
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('#nurse_notes_modal .loaderRefresh').fadeOut('fast');
    });
}





// prompt if modal is about to be closed
$('#nurse_notes_modal').on('hidden.bs.modal', function () {
    var ans = confirm('Warning! any changes that was not been saved will be lost.');
    if (ans){
        $('#nurse_notes_modal').modal('hide');
        queue_vue.nurse_notes_id = '';


        if(queue_vue.nurse_notes_consultation_single_open == 'single_open'){
            if (queue_vue.opened_consultation){
                queue_vue.show_consultation(queue_vue.opened_consultation);
            }
        }

        // reload show all consultation modal
        if(queue_vue.nurse_notes_consultation_single_open == 'multiple_open'){
            queue_vue.consultation_show_all();
        }


    } else{
        $('#nurse_notes_modal').modal('show');
    }

});


// delete the opened consultation id
$('#consultation_show_modal').on('hidden.bs.modal', function () {
    queue_vue.opened_consultation = '';
});

// highlight consultation btn on medical records
$('#medical_records_modal').on('show.bs.modal', function () {
    $('#medical_records_div_menu_container').find('a.highlight_consultation_menu').addClass('bg-light-blue');
});

// remove color on all consultation btn on medical records
$('#medical_records_modal').on('hidden.bs.modal', function () {
    $('#medical_records_div_menu_container a').each(function (index) {
        $(this).removeClass('bg-light-blue');
    });
});



/*
function insert_contents(){
    tinymce.get('nurse_notes_editor').setContent(table);
}*/


// call function when updating nurse notes
// function update_nurse_notes() {
//     alert('old forms');
//     tinymce.init({
//         path_absolute : baseUrl+"/",
//         selector: "textarea#nurse_notes_editor",
//         plugins: [
//             "save insertdatetime advlist lists charmap preview hr tabfocus",
//             "searchreplace wordcount fullscreen",
//             "insertdatetime nonbreaking directionality",
//             "emoticons template paste textcolor colorpicker textpattern noneditable preventdelete"
//         ],
//         toolbar: "save | insertdatetime | insertfile | styleselect fontsizeselect forecolor backcolor |" +
//             " bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | " +
//             "outdent indent | link media emoticons",
//
//         fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
//         templates: [
//             {title: 'Doctors Consultation', description: 'Doctors Consultation Form', content: table}
//         ],
//         tabfocus_elements: "button",
//         insertdatetime_formats: ["%b %d, %Y %H:%M %p", "%b %d, %Y", "%I:%M:%S %p", "%D"],
//         table_toolbar: false,
//         relative_urls: false,
//         branding:false,
//         removed_menuitems: 'newdocument',
//         setup : function(ed) {
//             ed.on('BeforeAddUndo', function(e) {
//                 return false;
//             });
//         },
//         save_onsavecallback: function(){
//             nurse_notes_update();
//         }
//     });
// }












// callback from update consultation nurse notes only
// function nurse_notes_update(){
//     alert('up')
//     $('#nurse_notes_modal .loaderRefresh').fadeIn(0);
//     var data = $('#nurse_notes_form').serialize();
//     request = $.ajax({
//         url: baseUrl+"/nurse_notes_update",
//         type: "post",
//         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//         data: data,
//         dataType: "json"
//     });
//     request.done(function (response, textStatus, jqXHR) {
//         queue_vue.nurse_notes_id = response['consultation'].id; // assign consultation id for updating
//         toast('info', 'Nurse notes successfully updated.');
//     });
//     request.fail(function (jqXHR, textStatus, errorThrown){
//         console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
//     });
//     request.always(function(){
//         $('#nurse_notes_modal .loaderRefresh').fadeOut('fast');
//     });
// }


