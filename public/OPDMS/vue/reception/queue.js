var queue_vue = new Vue({

            el: '#vue-queue',
            data: {
                pid: '',
                p_name: '',
                patient_selected: false,
                assignations: false,
                re_assign: false,
                nawc: false,
                spinner_action_btn:false,

                /* for patient notifications*/
                ls_main_div: false, // notifications last consultation div,
                lc_date: '', // patient notification
                lc_doctor: '', // patient notification
                ff_main_div: false, // patient notification follow-up main div
                ff_doctor: '', // patient notification
                rr_main_div: false, // patient notification referral main div
                refferal_notifications: [],
                ls_notification_show: false, // show or hide green circle along notifications
                ff_notification_show: false, // show or hide blue circle along notifications
                rr_notification_show: false, // show or hide yellow circle along notifications


                /* medical records */

                // consultations records
                medical_records_thead: [],
                consultation_clinic_name: '', // when a consultation is clicked the update clinic name
                consultation_consulted_by: '', // when a consultation is clicked the update doctor name
                consultation_date: '', // when a consultation is clicked the update consultation date
                edit_consultation: false, //  check if user is allowed to edit toggle edit consultation btn on consultation show modal
                create_nurse_notes: false, // toggle nurse notes btn on consultation show modal
                create_nurse_notes_link: '', // show btn to create nurse notes on consultation modal
                edit_consultation_link: '', // show btn to edit the consultation

                nurse_notes_id: '', // update this when a nurse notes or chief complaint is saved
                show_nurse_notes_print: false, // show or hide nurse notes print btn
                show_nurse_notes_print_link: '', // create nurse notes consultation print

                opened_consultation: '', // if a consultation has been opened update this cid
                consultation_print_btn: '', //print btn on show consultation


                // for displaying the total of badge of medical records
                consultations_count: '', // total number of consultations
                ecg_count: '', // total number of ecg
                followup_count: '', // total number of followup
                laboratory_count: '', // total number of laboratory
                referrals_count: '', // total number of referrals
                ultrasound_count: '', // total number of ultrasound
                xray_count: '', // total number of xray
                pedia_total: '', // total number of pedia forms
                industrial_count: '', // total number of industrial forms


                // show number of request of this patient
                service_request: '', // service request total
                paid_request: '', // paid request total
                charging_allowed: false, // show charging button if clinic is allowed to charge


                new_blank_nurse_form: false, // create a new blank consultation form on nurse notes


                is_active_li: true, // disable parent li on action btn on sidebar
                is_active_link: true, // disable action btn on sidebar
                action_btn_loader: false, // hide btn loader on action menus
                action_btn_header: false, // hide btn header on action menus


                todays_referred_patients: [], // show all todays referred patients


                patient_consultations: [], // patient consultation notifications to show on modal
                patient_followup: [], // patient followup notifications to show on modal
                patient_referrals: [], // patient referrals notifications to show on modal


                consultations_all: [], // store all consultations
                consultation_count: 0, // coutn all consultation of this patient
                featured_cid: '', // selected consultation on show all consultation modal
                featured_consultation: '', // show the selected consultations
                featured_clinic: '', // selected clinic on consultation show all modal
                featured_doctor: '', // selected doctor name on consultation show all modal
                featured_ext: '', // selected doctor ext on consultation show all modal
                featured_date: '', // selected consultation date on consultation show all modal
                featured_nurse_notes: false, // show / hide nurse notes btn on show all consultations
                featured_edit_consultation: false, // show / hide edit consultation btn on show all consultations

                search_filter: '', // filter on consultation all modal

                nurse_notes_consultation_single_open: '', // condition to open nurse open single or multiple

            },
            methods: {



                /* assign the pid of selected patient */
                patient_check: function (event, pid)
                {
                    if (this.pid != pid){ // check if patient was clicked twice

                        var route_url = getUrl.pathname.split('/')[2]; // get the second route parameter
                        var not_allowed_url = [
                            'queued_history',
                            'search_patient',
                            'outgoing_referrals',
                            'incoming_referrals',
                            'charged_patients',
                            'followup_notifications',
                        ]; // urls that is not allowed to access certain methods
                        var url_status = $.inArray(route_url, not_allowed_url);

                        this.pid = pid;
                        this.patient_selected = true; // show all dashboard buttons
                        this.patient_name(); // get patient name
                        if (url_status < 0){
                            this.queued_action_buttons; // ajax for dashboard buttons
                        }
                        this.selected_row(event);
                        this.check_icon(event);
                        this.unselected_row(event);
                        this.notifications_popup(); // check if patient has notifications
                        // this.patient_has_notifications(); // check if patient has notifications
                        this.charging_records(); // check the total number of service request and paid requests
                        this.disable_action_btn(); // disable action buttons
                    }
                },


                enable_action_btn: function()
                {
                    this.action_btn_header = true; // show btn loader on action menus
                    this.action_btn_loader = false; // hide btn loader on action menus
                    this.is_active_li = false; // enable parent li on action btn on sidebar
                    this.is_active_link = false; // enable action btn on sidebar
                },


                disable_action_btn: function()
                {
                    this.action_btn_loader = true; // show btn header on action menus
                    this.action_btn_header = false; // hide btn header on action menus
                    this.is_active_li = true; // enable parent li on action btn on sidebar
                    this.is_active_link = true; // enable action btn on sidebar
                },



                /* get patient name for displaying on modal header*/
                patient_name: function()
                {
                    var root_element = this; // root vue this
                    request = $.ajax({
                        url: baseUrl+'/patient_name/'+root_element.pid,
                        type: "get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        root_element.replace_null(response); // replace null values with ""
                        var full_patient_name = response.last_name+', '+response.first_name+' '+response.suffix+' '+response.middle_name; // full name
                        root_element.p_name = full_patient_name; // assign p_name to full name
                    });
                    return;
                },



                /* modify the selected row */
                selected_row: function (event)
                {
                    //create a background color for the row selected
                    $(event.target).closest('tr').addClass('selected_row');
                    return;
                },



                /* modify unselected <tr> */
                unselected_row: function (event)
                {
                    //select all siblings tr which is not clicked
                    $(event.target).closest('tr').siblings().each(function (index) {
                        $(this).removeClass('selected_row'); // remove the background color of the <tr>
                        var circle_icon = $(this).find('td.selected_icon').find('i.fa') // find the circle icon
                        $(circle_icon).removeClass('fa-check text-green'); // remove check circle icon
                        $(circle_icon).addClass('fa-circle-o text-muted'); // replace with circle text-muted
                        return;
                    });
                },




                /* create check icon */
                check_icon: function (event)
                {
                    var checked_icon = $(event.target).closest('tr').find('td.selected_icon').find('i.fa');
                    $(checked_icon).removeClass('fa-circle-o text-muted');
                    $(checked_icon).addClass('fa-check text-green');
                    return;
                },




                // patient information and vital signs
                patient_information: function()
                {
                    $('#patient_information_modal').modal();
                    $('#patient_information_modal .loaderRefresh').fadeIn(0); // show loader
                    var root_element = this; // root vue this
                    request = $.ajax({
                        url: baseUrl+'/patient_info_vs',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {

                        root_element.replace_null(response); // replace null values with ''

                        var patient_name = response.last_name+', '+response.first_name+' '+response.suffix+' '+response.middle_name; // full name

                        // check if patient is mss classified
                        if(response.mss_id == ''){
                            var mss = 'Unclassified';
                        }else{
                            var mss = response.label+' '+response.description+'%';
                        }

                        /*--------- patient information on table -----*/
                        root_element.$refs.patient_full_name.innerText = patient_name; // assign full name to the table
                        root_element.$refs.hospital_no.innerText = response.hospital_no; // assign hospital_no to the table
                        root_element.$refs.patient_qrcode.innerText = response.barcode; // assign barcode to the table
                        root_element.$refs.patient_birthday.innerText = dateCalculate(response.birthday); // assign patient_birthday to the table
                        root_element.$refs.patient_address.innerText = response.address; // assign patient_address to the table
                        root_element.$refs.patient_sex.innerText = response.sex; // assign patient_sex to the table
                        root_element.$refs.patient_civil_status.innerText = response.civil_status; // assign patient_civil_status to the table
                        root_element.$refs.patient_mss.innerText = mss; // assign patient_mss to the table
                        root_element.$refs.patient_date_reg.innerText = dateCalculate(response.date_reg); // assign patient_date_reg to the table

                        /*--------- vital signs details ---------*/
                        root_element.$refs.bp.innerText = response.blood_pressure; //blood pressure
                        root_element.$refs.pr.innerText = response.pulse_rate; // pulse_rate
                        root_element.$refs.rr.innerText = response.respiration_rate; // respiration_rate
                        root_element.$refs.bt.innerText = response.body_temperature; // body_temperature
                        root_element.$refs.weight.innerText = response.weight; // weight
                        root_element.$refs.height.innerText = response.height; // height

                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#patient_information_modal .loaderRefresh').fadeOut('fast')
                    });
                    return;
                },


                /* replace null values with '' */
                replace_null: function(response)
                {
                    Object.keys(response).forEach(function(key){
                        if(response[key] === null){
                            response[key] = '';
                        }
                    });
                },

                /* replace null values with 0 */
                replace_null_with_zero: function(response)
                {
                    Object.keys(response).forEach(function(key){
                        if(response[key] === null){
                            response[key] = 0;
                        }
                    });
                },






                /* show active doctors */
                patient_assignation: function()
                {
                    $('#patient_assignation_modal .loaderRefresh').fadeIn(0);
                    $('#patient_assignation_modal').modal(); // show assigantions modal
                    $('#assignations_tbody').empty(); // empty assignation tbody

                    var root_element = this; // the parent element

                    request = $.ajax({
                        url: baseUrl+'/assign_to_doctor',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if(response.length > 0){  // if active doctors has been found
                            $.each(response, function(index, value){
                                root_element.replace_null(response[index]); // replace null values

                                var serving = (response[index].serving)? 'bg-green' : ''; // for serving bg-color
                                var pending = (response[index].pending)? 'bg-orange' : ''; // for pending bg-color
                                var nawc = (response[index].nawc)? 'bg-red' : ''; // for nawc bg-color
                                var finished = (response[index].finished)? 'bg-blue' : ''; // for finished bg-color
                                var paused = (response[index].paused)? 'bg-brown' : ''; // for paused bg-color

                                /*-- generate tbody for assignation --*/
                                var tr = $('<tr onclick="assign_to_doctor_now('+response[index].id+')">');
                                var td1 = $('<td>').text(index + 1);
                                var online_icon = $('<i class="fa fa-circle text-green">');
                                var td2 = $('<td>').text(' Online').prepend(online_icon);
                                var td3 = $('<td class="text-uppercase text-primary">').text('DR. '+response[index].last_name+', '
                                                    +response[index].first_name+' '+response[index].middle_name); // doctors name
                                var td4 = $('<td class="'+serving+'">').text(response[index].serving); // number of serving
                                var td5 = $('<td class="'+pending+'">').text(response[index].pending); // number of pending
                                var td6 = $('<td class="'+nawc+'">').text(response[index].nawc); // number of nawc
                                var td7 = $('<td class="'+paused+'">').text(response[index].paused); // number of paused
                                var td8 = $('<td class="'+finished+'">').text(response[index].finished); // number of finished

                                $(tr).append(td1,td2,td3,td4,td5,td6,td7,td8); // append all td to tr

                                $('#assignations_tbody').append(tr); // append tr to tbody
                            })
                        }else{
                            // if no active doctors found
                            var td = $('<td colspan="8" class="bg-red text-center">').text('Sorry, no active doctors found.');
                            var tr = $('<tr>').append(td);
                            $('#assignations_tbody').append(tr); // append tr to tbody
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#patient_assignation_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },





                // queue assigning to doctor
                assign_now: function(doctors_id)
                {
                    var ans = confirm('Do you really want to assign this patient to this doctor.');
                    if(ans){
                        $('.full_window_loader').fadeIn(0);
                        request = $.ajax({
                            url: baseUrl+'/assign_now',
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {'pid':this.pid,'doctors_id':doctors_id},
                        });
                        request.done(function (response, textStatus, jqXHR) {
                            toast('info', 'Patient successfully assigned');
                            location.reload();
                        });
                        request.fail(function (jqXHR, textStatus, errorThrown){
                            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                        });
                        request.always(function(){
                            $('#patient_assignation_modal .loaderRefresh').fadeOut('fast');
                        });
                    }
                    return;
                },




                // queue re assigning to doctor
                re_assign_now: function(doctors_id)
                {
                    var ans = confirm('Do you really want to re-assign this patient to another doctor.');
                    if(ans){
                        $('.full_window_loader').fadeIn(0);
                        request = $.ajax({
                            url: baseUrl+'/re_assign_now', // send ajax to re-assign
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {'pid':this.pid,'doctors_id':doctors_id},
                        });
                        request.done(function (response, textStatus, jqXHR) {
                            if (response == 'true'){
                                toast('info', 'Patient successfully re-assigned');
                                location.reload();
                            } else{
                                toast('error', 'Re-assignation failed patient is already being served.');
                            }
                        });
                        request.fail(function (jqXHR, textStatus, errorThrown){
                            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                        });
                        request.always(function(){
                            $('#patient_assignation_modal .loaderRefresh').fadeOut('fast');
                        });
                    }
                    return;
                },



                /* remove queued patient when NAWC is clicked*/
                remove_queued_patient: function () {
                    var ans = confirm('Do you really want to remove this patient from the queue.');
                    if(ans){
                        $('.full_window_loader').fadeIn(0);
                        request = $.ajax({
                            url: baseUrl+'/remove_queued_patient',
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {'pid':this.pid},
                        });
                        request.done(function (response, textStatus, jqXHR) {
                            toast('error', 'Patient has been removed');
                            location.reload();
                        });
                        request.fail(function (jqXHR, textStatus, errorThrown){
                            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                        });
                    }
                    return;
                },


                /* patient re-assignation when re=-assign is clicked */
                patient_re_assignation: function () {

                    $('#patient_re_assignation_modal .loaderRefresh').fadeIn(0);
                    $('#patient_re_assignation_modal').modal(); // show assigantions modal
                    $('#re_assignations_tbody').empty(); // empty assignation tbody

                    var root_element = this; // the parent element

                    request = $.ajax({
                        url: baseUrl+'/re_assign_patient',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if(response.length > 0){  // if active doctors has been found
                            $.each(response, function(index, value){
                                root_element.replace_null(response[index]); // replace null values

                                var serving = (response[index].serving)? 'bg-green' : ''; // for serving bg-color
                                var pending = (response[index].pending)? 'bg-orange' : ''; // for pending bg-color
                                var nawc = (response[index].nawc)? 'bg-red' : ''; // for nawc bg-color
                                var finished = (response[index].finished)? 'bg-blue' : ''; // for finished bg-color
                                var paused = (response[index].paused)? 'bg-brown' : ''; // for paused bg-color

                                /*-- generate tbody for assignation --*/
                                var tr = $('<tr onclick="re_assign_to_doctor_now('+response[index].id+')">');
                                var td1 = $('<td>').text(index + 1);
                                var online_icon = $('<i class="fa fa-circle text-green">');
                                var td2 = $('<td>').text(' Online').prepend(online_icon);
                                var td3 = $('<td class="text-uppercase text-primary">').text('DR. '+response[index].last_name+', '
                                    +response[index].first_name+' '+response[index].middle_name); // doctors name
                                var td4 = $('<td class="'+serving+'">').text(response[index].serving); // number of serving
                                var td5 = $('<td class="'+pending+'">').text(response[index].pending); // number of pending
                                var td6 = $('<td class="'+nawc+'">').text(response[index].nawc); // number of nawc
                                var td7 = $('<td class="'+paused+'">').text(response[index].paused); // number of paused
                                var td8 = $('<td class="'+finished+'">').text(response[index].finished); // number of finished

                                $(tr).append(td1,td2,td3,td4,td5,td6,td7,td8); // append all td to tr

                                $('#re_assignations_tbody').append(tr); // append tr to tbody
                            })
                        }else{
                            // if no active doctors found
                            var td = $('<td colspan="8" class="bg-red text-center">').text('Sorry, no active doctors found.');
                            var tr = $('<tr>').append(td);
                            $('#re_assignations_tbody').append(tr); // append tr to tbody
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#patient_re_assignation_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },


                // upon clicking patient check if it has some notifications
                patient_has_notifications: function()
                {
                    var root_element = this; // the parent element
                    request = $.ajax({
                        url: baseUrl+'/patient_notifications',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        // set circle notification hidden
                        root_element.ls_notification_show = false;
                        root_element.ff_notification_show = false;
                        if (response['notifications'].length > 0) { // check if last consultation and follow-up is empty
                            if (response['notifications'][0].lc_date){
                                root_element.ls_notification_show = true; // if a last consultation has been found
                            }
                            if (response['notifications'][0].ff_last_name){
                                root_element.ff_notification_show = true; // if today`s follow up is set
                            }
                        }
                        if (response['referrals'].length > 0){ // check if referrals is empty
                            root_element.rr_notification_show = true; // if referrals from other clinic found
                        }else{
                            root_element.rr_notification_show = false;

                        }
                        if (response['notifications'].length || response['referrals'].length) {
                            root_element.patient_notification();
                        }
                    });
                    return;
                },



                patient_notification:function () {
                    $('#notifications_modal').modal();
                    $('#notifications_modal .loaderRefresh').fadeIn(0);
                    var root_element = this; // the parent element
                    request = $.ajax({
                        url: baseUrl+'/patient_notifications',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {

                        /* set all elements as empty */
                        root_element.ls_main_div = false;
                        root_element.lc_date = ''; // last consultation date
                        root_element.lc_doctor = ''; // doctor name
                        root_element.ff_main_div = false;
                        root_element.ff_doctor = ''; // doctor name

                        if (response['notifications'].length > 0) { // check if last consultation and follow-up is empty
                            if (response['notifications'][0].lc_date){
                                root_element.ls_main_div = true;
                                root_element.lc_date =
                                    dateCalculate(response['notifications'][0].lc_date); // last consultation date
                                root_element.lc_doctor =
                                    'DR. '+response['notifications'][0].lc_last_name+', '
                                    +response['notifications'][0].lc_first_name // doctor name
                            }
                            if (response['notifications'][0].ff_last_name){
                                root_element.ff_main_div = true;
                                root_element.ff_doctor = 'DR. '+response['notifications'][0].ff_last_name+', '
                                    +response['notifications'][0].ff_first_name // doctor name

                            }
                        }

                        if (response['referrals'].length > 0){ // check if referrals is empty
                            root_element.rr_main_div = true;
                            root_element.refferal_notifications = response['referrals'];
                        }else{
                            root_element.rr_main_div = false;
                            root_element.refferal_notifications =[];
                        }


                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#notifications_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },





                get_patient_notifications: function()
                {
                    $('#patient_notifications_modal').modal();
                    $('#patient_notifications_modal .loaderRefresh').fadeIn(0);
                    var root_element = this; // the parent element
                    request = $.ajax({
                        url: baseUrl+'/get_all_notifications',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {

                        if (response['consultations'].length) { // check if last consultation is not empty
                            root_element.patient_consultations = response['consultations'];
                        }else{
                            root_element.patient_consultations = [];
                        }

                        if (response['followup'].length) { // check if followup is not empty
                            root_element.patient_followup= response['followup'];
                        }else{
                            root_element.patient_followup = [];
                        }

                        if (response['referrals'].length) { // check if referrals is not empty
                            root_element.patient_referrals= response['referrals'];
                        }else{
                            root_element.patient_referrals = [];
                        }

                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#patient_notifications_modal .loaderRefresh').fadeOut('fast');
                    });
                },



                // patient notification indicator on dashboard
                notifications_popup: function()
                {
                    var root_element = this; // the parent element
                    request = $.ajax({
                        url: baseUrl+'/notifications_popup',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if (response['consultations']) { // check if last consultation not empty
                            root_element.ls_notification_show = true; // if a last consultation has been found
                        }else{
                            root_element.ls_notification_show = false; // if a last consultation has not been found
                        }
                        if (response['followup']) { // check if follow-up is not empty
                            root_element.ff_notification_show = true; // if a last follow-up has been found
                        }else{
                            root_element.ff_notification_show = false; // if a last follow-up has not been found
                        }
                        if (response['referrals']){ // check if referrals is empty
                            root_element.rr_notification_show = true; // if referrals from other clinic found
                        }else{
                            root_element.rr_notification_show = false;
                        }
                        if (/*response['consultations'] || */response['followup'] || response['referrals']) {
                            root_element.get_patient_notifications();
                        }
                    });
                },
                
                

                /* start medical records */

                // highlight menu of records that was been click
                active_link_record:function(event){
                    $(event.target).addClass('bg-light-blue');
                    $(event.target).siblings().each(function (index) {
                        $(this).removeClass('bg-light-blue');
                    });
                    /*$('#medical_records_btn').removeClass('bg-light-blue');
                    $('#medical_records_btn span').removeClass('bg-light-blue');*/
                },



                // get all medical records count display on badges
                medical_records:function(){
                    var root_element = this;
                    $('#medical_records_modal').modal(); // show modal
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    request = $.ajax({
                        url: baseUrl+'/medical_records_count',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        // root_element.replace_null_with_zero(response);
                        root_element.consultations_count = response.consultations_count; //count all consultations
                        root_element.ecg_count = response.ecg_count; //count all ecg requests
                        root_element.followup_count = response.followup_count; //count all followup
                        root_element.industrial_count = response.industrial_count; // count all industrial forms
                        root_element.laboratory_count = response.laboratory_count; // count all laboratory requests
                        root_element.pedia_total = response.pedia_total; // count all pedia forms
                        root_element.referrals_count = response.referrals_count; // count all referrals
                        root_element.ultrasound_count = response.ultrasound_count; // count all ultrasound request
                        root_element.xray_count = response.xray_count; // count all xray requests

                        root_element.consultation_records(event);
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                    });
                    return;
                },



                //get all consultation records of this patient 
                consultation_records: function (event) {
                    this.active_link_record(event); // highlight menu of records that was been click
                    var root_element = this; // the parent element
                    $('#medical_records_modal').modal(); // show modal
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    $('#medical_records_tbody').empty(); // empty tbody contents
                    // show consultation thead
                    this.medical_records_thead = ['Clinic / Department', 'Profile', 'Consulted/Assisted By', 'Last Modified', 'Action'];
                    request = $.ajax({
                        url: baseUrl+'/get_all_consultation_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {

                        if (response.length){
                            $.each(response, function (index) { // loop through consultation records
                                root_element.replace_null(response[index]); //replace null values
                                // check if a doctor or other role who saved this consultation
                                if (response[index].role == 7){
                                    var small_ext = 'DR. ';
                                } else{
                                    var small_ext = $('<small class="text-muted">').text('Others ');
                                }
                                // check if profile image exist
                                if (response[index].profile){
                                    var profile = $('<img class="user_consultation_profile image-responsive img-circle" ' +
                                        'src="'+baseUrl+'/public/users/'+response[index].profile+'">')
                                }else{
                                    var profile = $('<img class="user_consultation_profile image-responsive img-circle"' +
                                        'src="'+baseUrl+'/public/images/user.svg">')
                                }
                                //create view consultation btn
                                var show_consultation_btn = $('<a class="btn btn-flat btn-sm bg-green" ' +
                                    'onclick="show_consultation_now('+response[index].cid+')">').text('View Consultation');
                                var tr = $('<tr>');
                                var td1 = $('<td class="text-uppercase">').text(response[index].name); // clinic name

                                var td2 = $('<td>').append(profile);

                                // doctors name or the person who saved the consultation will appear here
                                var td3 = $('<td class="text-uppercase text-blue text-bold">').text(
                                    response[index].last_name+', '+response[index].first_name+' '+
                                    response[index].middle_name).prepend(small_ext);
                                // date when the consultation was saved
                                var td4 = $('<td>').text(dateCalculate(response[index].created_at));
                                var td5 = $('<td>').append(show_consultation_btn);  // append consultation btn
                                $(tr).append(td1,td2,td3,td4,td5);
                                $('#medical_records_tbody').append(tr);
                            });

                            // create open all consultations button on medical records modal
                            var consultation_btn = $('<button class="btn bg-green-inverse" onclick="open_all_consultations()">')
                                .text('Open All Consultations');
                            var td = $('<td colspan="6">').append(consultation_btn)
                            var tr2 = $('<tr class="text-right">').append(td);
                            $('#medical_records_tbody').prepend(tr2);

                        } else{
                            var td = $('<td class="bg-red text-center" colspan="5">').text('No consultations found.');
                            var tr = $('<tr>').append(td);
                            $('#medical_records_tbody').append(tr);
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#medical_records_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },


                //get all referral records of this patient
                referral_records: function (event) {
                    this.active_link_record(event); // highlight menu of records that was been click
                    var root_element = this; // the parent element
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    $('#medical_records_tbody').empty(); // empty tbody contents
                    // show consultation thead
                    this.medical_records_thead = ['From Clinic', 'Referred By', 'To Clinic', 'Referred To', 'Reason',
                        'Status', 'Date', 'Action'];
                    request = $.ajax({
                        url: baseUrl+'/get_all_referral_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if (response.length){
                            $.each(response, function (index) { // loop through referral records
                                root_element.replace_null(response[index]); //replace null values


                                // referred to doctor
                                var to_doctor = (response[index].rt_last_name)? 'DR. '+response[index].rt_last_name+', '+
                                    response[index].rt_first_name+' '+response[index].rt_middle_name : '';
                                // check referral status
                                if(response[index].status == 'F'){
                                    var text_status = 'Finished';
                                    var label_color = 'label-info';
                                    var edit_btn_status = 'disabled';
                                }else{
                                    var text_status = 'Pending';
                                    var label_color = 'label-warning';
                                    var edit_btn_status = 'disabled';
                                }
                                if (auth_role != 7){ // check if user not doctor then disable btn
                                    edit_btn_status = 'disabled';
                                }else{ //if the user who created this rr is equal to the logged in user then enable btn
                                    edit_btn_status = (authenticate == response[index].users_id) ? '' : 'disabled';
                                }
                                //create edit referral btn
                                var edit_btn = $('<a href="" class="btn btn-flat btn-sm bg-blue '+edit_btn_status+'">').text('Edit');

                                // referral status
                                var label_status = $('<span class="label '+label_color+'">').text(text_status);
                                var tr = $('<tr>');
                                var td1 = $('<td class="text-uppercase">').text(response[index].name); // clinic name
                                // doctors name or the person who saved the consultation will appear here
                                var td2 = $('<td class="text-uppercase text-blue text-bold">').text(
                                    'DR. '+response[index].last_name+', '+response[index].first_name+' '+
                                    response[index].middle_name);
                                var td3 = $('<td>').text(response[index].rt_clinic); //referred to clinic
                                // referred to doctor
                                var td4 = $('<td class="text-uppercase text-blue text-bold">').text(to_doctor);
                                var td5 = $('<td>').text(response[index].reason); // reason of referral
                                var td6 = $('<td>').append(label_status); // reason of referral
                                // date when the referral was saved
                                var td7 = $('<td>').text(dateCalculate(response[index].created_at));
                                var td8 = $('<td>').append(edit_btn);  // append consultation btn
                                $(tr).append(td1,td2,td3,td4,td5,td6,td7,td8);
                                $('#medical_records_tbody').append(tr);
                            });
                        } else{
                            var td = $('<td class="bg-red text-center" colspan="8">').text('No referrals found.');
                            var tr = $('<tr>').append(td);
                            $('#medical_records_tbody').append(tr);
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#medical_records_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },




                //get all followup records of this patient
                followup_records: function (event) {
                    this.active_link_record(event); // highlight menu of records that was been click
                    var root_element = this; // the parent element
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    $('#medical_records_tbody').empty(); // empty tbody contents
                    // show consultation thead
                    this.medical_records_thead = ['Clinic', 'Consulted By', 'Follow-up To', 'Reason', 'Status',
                                                'FF Date', 'Action'];
                    request = $.ajax({
                        url: baseUrl+'/get_all_followup_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if (response.length){
                            $.each(response, function (index) { // loop through referral records
                                root_element.replace_null(response[index]); //replace null values

                                // referred to doctor
                                var to_doctor = (response[index].ft_last_name)? 'DR. '+response[index].ft_last_name+', '+
                                    response[index].ft_first_name+' '+response[index].ft_middle_name : '';
                                // check referral status
                                if(response[index].status == 'F'){
                                    var text_status = 'Finished';
                                    var label_color = 'label-info';
                                    var edit_btn_status = 'disabled';
                                }else{
                                    var text_status = 'Pending';
                                    var label_color = 'label-warning';
                                    var edit_btn_status = '';
                                }
                                if (auth_role != 7){ // check if user login is not doctor
                                    edit_btn_status = 'disabled';
                                }else{ // if the user who created this ff is equal to the logged in user then enable btn
                                    edit_btn_status = (authenticate == response[index].users_id) ? '' : 'disabled';
                                }
                                //create edit referral btn
                                var edit_btn = $('<a class="btn btn-flat btn-sm bg-blue '+edit_btn_status+'">').text('Edit');
                                // referral status
                                var label_status = $('<span class="label '+label_color+'">').text(text_status);
                                var tr = $('<tr>');
                                var td1 = $('<td class="text-uppercase">').text(response[index].name); // clinic name
                                // doctors name or the person who saved the consultation will appear here
                                var td2 = $('<td class="text-uppercase text-blue text-bold">').text(
                                    'DR. '+response[index].last_name+', '+response[index].first_name+' '+
                                    response[index].middle_name);
                                // referred to doctor
                                var td3 = $('<td class="text-uppercase text-blue text-bold">').text(to_doctor);
                                var td4 = $('<td>').text(response[index].reason); // reason of referral
                                var td5 = $('<td>').append(label_status); // reason of referral
                                // date when the referral was saved
                                var td6 = $('<td>').text(dateCalculate(response[index].followupdate));
                                var td7 = $('<td>').append(edit_btn);  // append consultation btn
                                $(tr).append(td1,td2,td3,td4,td5,td6,td7);
                                $('#medical_records_tbody').append(tr);
                            });
                        } else{
                            var td = $('<td class="bg-red text-center" colspan="7">').text('No follow-up found.');
                            var tr = $('<tr>').append(td);
                            $('#medical_records_tbody').append(tr);
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#medical_records_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },



                // show all ultrasound records for displaying on modal
                ultrasound_records: function(event)
                {
                    this.active_link_record(event); // highlight menu of records that was been click
                    var root_element = this; // the parent element
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    $('#medical_records_tbody').empty(); // empty tbody contents
                    // show consultation thead
                    this.medical_records_thead = ['Clinic', 'Requested by', 'Description', 'Price', 'Date',
                        'Status', 'Action'];
                    request = $.ajax({
                        url: baseUrl+'/ultrasound_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if (response.length){
                            $.each(response, function (index) { // loop through referral records
                                root_element.replace_null(response[index]); //replace null values

                                if (response[index].role == 7){ // check if the user who requested is doctor or clerk
                                    var small_ext = 'DR. ';
                                } else{
                                    var small_ext = $('<small class="text-muted">').text('Others ');
                                }
                                // requested by doctor
                                var doctor = (response[index].last_name)? response[index].last_name+', '+
                                    response[index].first_name+' '+response[index].middle_name : '';
                                // check referral status
                                if(response[index].rad_id){
                                    var text_status = 'Finished';
                                    var label_color = 'label-info';
                                    var result_btn_status = '';
                                }else{
                                    var text_status = 'Pending';
                                    var label_color = 'label-warning';
                                    var result_btn_status = 'disabled';
                                }
                                //create viewing of ultrasound btn
                                var ultrasound_btn = $('<a href="'+baseUrl+'/radiologyPrint/'+response[index].rad_id+'" ' +
                                    'target="_blank" class="btn btn-flat btn-sm bg-blue '+result_btn_status+'">').text('View Result');
                                // referral status
                                var label_status = $('<span class="label '+label_color+'">').text(text_status);
                                var tr = $('<tr>');
                                // clinic name
                                var td1 = $('<td class="text-uppercase">').text(response[index].name);
                                // requested by doctor
                                var td2 = $('<td class="text-uppercase text-blue text-bold">').text(doctor).prepend(small_ext);
                                // description of laboratory request
                                var td3 = $('<td>').text(response[index].sub_category);
                                var td4 = $('<td>').text('₱ '+response[index].price+'.00'); // price of laboratory request
                                var td5 = $('<td>').append(dateCalculate(response[index].created_at)); // requested date
                                // finished status if a result has been posted or else the other way around
                                var td6 = $('<td>').append(label_status);
                                var td7 = $('<td>').append(ultrasound_btn);  // append ultrasound view btn
                                $(tr).append(td1,td2,td3,td4,td5,td6,td7);
                                $('#medical_records_tbody').append(tr);
                            });
                        } else{
                            var td = $('<td class="bg-red text-center" colspan="7">').text('No ultrasound records found.');
                            var tr = $('<tr>').append(td);
                            $('#medical_records_tbody').append(tr);
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#medical_records_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },





                // show all xray records for displaying on modal
                xray_records: function(event)
                {
                    this.active_link_record(event); // highlight menu of records that was been click
                    var root_element = this; // the parent element
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    $('#medical_records_tbody').empty(); // empty tbody contents
                    // show consultation thead
                    this.medical_records_thead = ['Clinic', 'Requested by', 'Description', 'Price', 'Date',
                        'Status', 'Action'];
                    request = $.ajax({
                        url: baseUrl+'/xray_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if (response.length){
                            $.each(response, function (index) { // loop through referral records
                                root_element.replace_null(response[index]); //replace null values

                                if (response[index].role == 7){ // check if the user who requested is doctor or clerk
                                    var small_ext = 'DR. ';
                                } else{
                                    var small_ext = $('<small class="text-muted">').text('Others ');
                                }
                                // requested by doctor
                                var doctor = (response[index].last_name)? response[index].last_name+', '+
                                    response[index].first_name+' '+response[index].middle_name : '';
                                // check referral status
                                if(response[index].rad_id){
                                    var text_status = 'Finished';
                                    var label_color = 'label-info';
                                    var result_btn_status = '';
                                }else{
                                    var text_status = 'Pending';
                                    var label_color = 'label-warning';
                                    var result_btn_status = 'disabled';
                                }
                                //create viewing of ultrasound btn
                                var ultrasound_btn = $('<a href="'+baseUrl+'/radiologyPrint/'+response[index].rad_id+'" ' +
                                    'target="_blank" class="btn btn-flat btn-sm bg-blue '+result_btn_status+'">').text('View Result');
                                // referral status
                                var label_status = $('<span class="label '+label_color+'">').text(text_status);
                                var tr = $('<tr>');
                                // clinic name
                                var td1 = $('<td class="text-uppercase">').text(response[index].name);
                                // requested by doctor
                                var td2 = $('<td class="text-uppercase text-blue text-bold">').text(doctor).prepend(small_ext);
                                // description of laboratory request
                                var td3 = $('<td>').text(response[index].sub_category);
                                var td4 = $('<td>').text('₱ '+response[index].price+'.00'); // price of laboratory request
                                var td5 = $('<td>').append(dateCalculate(response[index].created_at)); // requested date
                                // finished status if a result has been posted or else the other way around
                                var td6 = $('<td>').append(label_status);
                                var td7 = $('<td>').append(ultrasound_btn);  // append ultrasound view btn
                                $(tr).append(td1,td2,td3,td4,td5,td6,td7);
                                $('#medical_records_tbody').append(tr);
                            });
                        } else{
                            var td = $('<td class="bg-red text-center" colspan="7">').text('No xray records found.');
                            var tr = $('<tr>').append(td);
                            $('#medical_records_tbody').append(tr);
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#medical_records_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },





                // show all ECG records for displaying on modal
                ecg_records: function(event)
                {
                    this.active_link_record(event); // highlight menu of records that was been click
                    var root_element = this; // the parent element
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    $('#medical_records_tbody').empty(); // empty tbody contents
                    // show consultation thead
                    this.medical_records_thead = ['Clinic', 'Requested by', 'Description', 'Price', 'Date',
                        'Payment'];
                    request = $.ajax({
                        url: baseUrl+'/ecg_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if (response.length){
                            $.each(response, function (index) { // loop through referral records
                                root_element.replace_null(response[index]); //replace null values

                                if (response[index].role == 7){ // check if the user who requested is doctor or clerk
                                    var small_ext = 'DR. ';
                                } else{
                                    var small_ext = $('<small class="text-muted">').text('Others ');
                                }
                                // requested by doctor
                                var doctor = (response[index].last_name)? response[index].last_name+', '+
                                    response[index].first_name+' '+response[index].middle_name : '';
                                // check referral status
                                if(response[index].cash_id){
                                    var text_status = 'Paid';
                                    var label_color = 'label-info';
                                }else{
                                    var text_status = 'Unpaid';
                                    var label_color = 'label-warning';
                                }
                                // payment status
                                var label_status = $('<span class="label '+label_color+'">').text(text_status);
                                var tr = $('<tr>');
                                // clinic name
                                var td1 = $('<td class="text-uppercase">').text(response[index].name);
                                // requested by doctor
                                var td2 = $('<td class="text-uppercase text-blue text-bold">').text(doctor).prepend(small_ext);
                                // description of laboratory request
                                var td3 = $('<td>').text(response[index].sub_category);
                                var td4 = $('<td>').text('₱ '+response[index].price+'.00'); // price of laboratory request
                                var td5 = $('<td>').append(dateCalculate(response[index].created_at)); // requested date
                                // finished status if a result has been posted or else the other way around
                                var td6 = $('<td>').append(label_status);
                                $(tr).append(td1,td2,td3,td4,td5,td6);
                                $('#medical_records_tbody').append(tr);
                            });
                        } else{
                            var td = $('<td class="bg-red text-center" colspan="7">').text('No ecg records found.');
                            var tr = $('<tr>').append(td);
                            $('#medical_records_tbody').append(tr);
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#medical_records_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },



                // show all Laboratory and Injection records for displaying on modal
                laboratory_records: function(event)
                {
                    this.active_link_record(event); // highlight menu of records that was been click
                    var root_element = this; // the parent element
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    $('#medical_records_tbody').empty(); // empty tbody contents
                    // show consultation thead
                    this.medical_records_thead = ['Clinic', 'Requested by', 'Description', 'Price', 'Date',
                        'Payment'];
                    request = $.ajax({
                        url: baseUrl+'/laboratory_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if (response.length){
                            $.each(response, function (index) { // loop through referral records
                                root_element.replace_null(response[index]); //replace null values

                                if (response[index].role == 7){ // check if the user who requested is doctor or clerk
                                    var small_ext = 'DR. ';
                                } else{
                                    var small_ext = $('<small class="text-muted">').text('Others ');
                                }
                                // requested by doctor
                                var doctor = (response[index].last_name)? response[index].last_name+', '+
                                    response[index].first_name+' '+response[index].middle_name : '';
                                // check referral status
                                if(response[index].cash_id){
                                    var text_status = 'Paid';
                                    var label_color = 'label-info';
                                }else{
                                    var text_status = 'Unpaid';
                                    var label_color = 'label-warning';
                                }
                                // payment status
                                var label_status = $('<span class="label '+label_color+'">').text(text_status);
                                var tr = $('<tr>');
                                // clinic name
                                var td1 = $('<td class="text-uppercase">').text(response[index].name);
                                // requested by doctor
                                var td2 = $('<td class="text-uppercase text-blue text-bold">').text(doctor).prepend(small_ext);
                                // description of laboratory request
                                var td3 = $('<td>').text(response[index].sub_category);
                                var td4 = $('<td>').text('₱ '+response[index].price+'.00'); // price of laboratory request
                                var td5 = $('<td>').append(dateCalculate(response[index].created_at)); // requested date
                                // finished status if a result has been posted or else the other way around
                                var td6 = $('<td>').append(label_status);
                                $(tr).append(td1,td2,td3,td4,td5,td6);
                                $('#medical_records_tbody').append(tr);
                            });
                        } else{
                            var td = $('<td class="bg-red text-center" colspan="7">').text('No laboratory records found.');
                            var tr = $('<tr>').append(td);
                            $('#medical_records_tbody').append(tr);
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#medical_records_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },





                // show all pediatric records for displaying on modal
                pediatric_records: function(event)
                {
                    // this.active_link_record(event); // highlight menu of records that was been click
                    var root_element = this; // the parent element
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    $('#medical_records_tbody').empty(); // empty tbody contents
                    // show consultation thead
                    this.medical_records_thead = ['Title', 'Consulted / Interviewed by', 'Date', 'View Consultation',
                        'View Form', 'Edit Form'];
                    request = $.ajax({
                        url: baseUrl+'/pediatric_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if (response.length){
                            $.each(response, function (index) { // loop through referral records
                                root_element.replace_null(response[index]); //replace null values

                                if (response[index].role == 7){ // check if the user who requested is doctor or clerk
                                    var small_ext = 'DR. ';
                                } else{
                                    var small_ext = $('<small class="text-muted">').text('Others ');
                                }
                                // requested by doctor
                                var doctor = (response[index].last_name)? response[index].last_name+', '+
                                    response[index].first_name+' '+response[index].middle_name : '';

                                if (response[index].cid){ // if consultation is empty then disable btn
                                    consultation_btn_status = '';
                                } else{
                                    consultation_btn_status = 'disabled';
                                }
                                //create viewing of consultation btn
                                var consultation_btn = $('<a href="" target="_blank" onclick="show_consultation_now('+response[index].cid+')" ' +
                                    'class="btn btn-flat btn-sm bg-green '
                                    +consultation_btn_status+'">').text('View Consultation');
                                if (response[index].title == 1){ // title is created in query but not seen in the table column
                                    var title = 'Childhood Care and Development Form';
                                    var edit = baseUrl+'/childhood_care_edit/'+response[index].id;
                                    var print = baseUrl+'/printChildHoodCare/'+response[index].id;
                                }else if (response[index].title == 2) {
                                    var title = 'Therapeutic Care Form';
                                    var edit = baseUrl+'/otpc_edit/'+response[index].id;
                                    var print = baseUrl+'/printOTC/'+response[index].id;
                                }else if (response[index].title == 3) {
                                    var title = 'KMC (Kangaroo Mother Care Program)';
                                    var edit = baseUrl+'/kmc_edit/'+response[index].id;
                                    var print = baseUrl+'/printKMC/'+response[index].id;
                                }
                                var check_clinic = (auth_clinic == 26)? '' : 'disabled'; //check if clinic logged in is pedia
                                // create viewing of form button
                                var edit_btn = $('<a href="'+edit+'" target="_blank" ' +
                                    'class="btn btn-flat btn-sm bg-navy '+check_clinic+'">').text('Edit Form');
                                // create print of form button
                                var print_btn = $('<a href="'+print+'" target="_blank" class="btn btn-flat btn-sm bg-aqua">').text('View Form');
                                var tr = $('<tr>');
                                var td1 = $('<td class="text-uppercase">').text(title); // pediatric title like KMC, Childhood Care
                                // consulted or interviewed by doctor
                                var td2 = $('<td class="text-uppercase text-blue text-bold">').text(doctor).prepend(small_ext);
                                // date created
                                var td3 = $('<td>').text(dateCalculate(response[index].created_at));
                                var td4 = $('<td>').append(consultation_btn); // append view consultation
                                var td5 = $('<td>').append(print_btn);  // append view form
                                var td6 = $('<td>').append(edit_btn);  // append view form
                                $(tr).append(td1,td2,td3,td4,td5,td6);
                                $('#medical_records_tbody').append(tr);
                            });
                        } else{
                            var td = $('<td class="bg-red text-center" colspan="6">').text('No pediatric form records found.');
                            var tr = $('<tr>').append(td);
                            $('#medical_records_tbody').append(tr);
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#medical_records_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },






                // show all industrial form records for displaying on modal
                industrial_records: function(event)
                {
                    // this.active_link_record(event); // highlight menu of records that was been click
                    var root_element = this; // the parent element
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    $('#medical_records_tbody').empty(); // empty tbody contents
                    // show consultation thead
                    this.medical_records_thead = ['Consulted / Interviewed by', 'Date', 'View Consultation',
                        'View Form', 'Edit Form'];
                    request = $.ajax({
                        url: baseUrl+'/industrial_form_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if (response.length){
                            $.each(response, function (index) { // loop through industrial records
                                root_element.replace_null(response[index]); //replace null values

                                if (response[index].role == 7){ // check if the user who requested is doctor or clerk
                                    var small_ext = 'DR. ';
                                } else{
                                    var small_ext = $('<small class="text-muted">').text('Others ');
                                }
                                // requested by doctor
                                var doctor = (response[index].last_name)? response[index].last_name+', '+
                                    response[index].first_name+' '+response[index].middle_name : '';

                                if (response[index].cid){ // if consultation is empty then disable btn
                                    consultation_btn_status = '';
                                } else{
                                    consultation_btn_status = 'disabled';
                                }
                                //create viewing of consultation btn
                                var consultation_btn = $('<a href="" target="_blank" onclick="show_consultation_now('+response[index].cid+')" ' +
                                    'class="btn btn-flat btn-sm bg-green '
                                    +consultation_btn_status+'">').text('View Consultation');
                                //check if user logged in is the one who created this form
                                var check_user = (authenticate == response[index].uid)? '' : 'disabled';
                                // create viewing of form button
                                var edit_btn = $('<a href="'+baseUrl+'/industrialPreview/'+response[index].id+'" ' +
                                    'target="_blank" ' +
                                    'class="btn btn-flat btn-sm bg-navy '+check_user+'">').text('Edit Form');
                                // create print of form button
                                var print_btn = $('<a href="'+baseUrl+'/industrialPrint/'+response[index].id+'" ' +
                                    'target="_blank" class="btn btn-flat btn-sm bg-aqua">').text('View Form');
                                var tr = $('<tr>');
                                // consulted or interviewed by doctor
                                var td1 = $('<td class="text-uppercase text-blue text-bold">').text(doctor).prepend(small_ext);
                                // date created
                                var td2 = $('<td>').text(dateCalculate(response[index].created_at));
                                var td3 = $('<td>').append(consultation_btn); // append view consultation
                                var td4 = $('<td>').append(print_btn);  // append view form
                                var td5 = $('<td>').append(edit_btn);  // append view form
                                $(tr).append(td1,td2,td3,td4,td5);
                                $('#medical_records_tbody').append(tr);
                            });
                        } else{
                            var td = $('<td class="bg-red text-center" colspan="6">').text('No industrial form records found.');
                            var tr = $('<tr>').append(td);
                            $('#medical_records_tbody').append(tr);
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#medical_records_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },






                //show the consultation of this patient
                show_consultation: function ($id) {

                    var root_element = this; // the parent element
                    $('#consultation_show_modal').modal();
                    $('#consultation_show_modal .loaderRefresh').fadeIn(0);

                    request = $.ajax({
                        url: baseUrl+'/show_consultation',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'id':$id},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        $('#consultation_show_wrapper').html(response.consultation);

                        root_element.opened_consultation = response.cid;

                        if(authenticate == response.users_id && auth_role == 7){ // check if user is allowed to edit (receptionist or doctor)
                            root_element.edit_consultation = true; // show edit consultation btn
                            //  create link for edit consultation
                            root_element.edit_consultation_link = baseUrl+'/edit_consultation/'+response.cid;
                        }else{
                            root_element.edit_consultation = false;  // hide edit consultation btn
                            root_element.edit_consultation_link = '#'; //  create link for edit consultation #
                        }
                        if(auth_role == 5 || auth_role == 6){ // check if user role is receptionist or nurse then show nurse notes btn
                            root_element.create_nurse_notes = true; // show nurse notes btn
                            //  create link for nurse notes
                            root_element.create_nurse_notes_link = baseUrl+'/create_nurse_notes/'+response.cid;
                        }else{
                            root_element.create_nurse_notes = false; // hide nurse notes btn
                            root_element.create_nurse_notes_link = '#'; // create link for nurse notes #
                        }
                        root_element.consultation_print_btn = baseUrl+'/printNurseNotes/'+response.cid;
                        // add (DR) if the user who created the consultation is doctor or receptionist
                        var ext = (response.role == 7)? 'DR. ' : '';
                        // when a consultation is clicked the update clinic name
                        root_element.consultation_clinic_name = response.name;
                        // when a consultation is clicked the update doctor name
                        root_element.consultation_consulted_by =
                            ext+' '+response.last_name+', '+response.first_name+' '+response.middle_name;
                        // when a consultation is clicked the update doctor name
                        root_element.consultation_date = dateCalculate(response.created_at)


                        root_element.nurse_notes_consultation_single_open = 'single_open';

                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#consultation_show_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },
                
                
                /* end medical records */


                // write nurse notes
                write_nurse_notes: function () {
                    var root_element = this; // the parent element
                    $('#nurse_notes_modal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#nurse_notes_modal .loaderRefresh').fadeIn(0);
                    request = $.ajax({
                        url: baseUrl+'/write_nurse_notes',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        nurse_notes_editor(); // call richtexteditor fresh forms of nurse notes
                        if (response['consultation'] == null){ // check if a consultation has already been saved
                            root_element.new_blank_nurse_form = false; // hide btn for fresh nurse form
                            root_element.nurse_notes_id = ''; // set consultation id as empty
                            root_element.show_nurse_notes_print = false; // hide nurse notes print btn
                            root_element.show_nurse_notes_print_link = '';// create nurse notes print link
                            var table = template_table(); // call empty template table
                            setTimeout(function () { // important delay the displaying of table
                                tinymce.get('nurse_notes_editor').setContent(table);
                            }, 500);
                        } else{
                            root_element.new_blank_nurse_form = true; // show btn for fresh nurse form
                            // update_nurse_notes(); // call richtexteditor nurse notes for update
                            root_element.nurse_notes_id = response['consultation'].id; // automatically assigned the consultation id
                            root_element.show_nurse_notes_print = true; // show nurse notes print btn
                            // create nurse notes print link
                            root_element.show_nurse_notes_print_link = baseUrl+'/printNurseNotes/'+response['consultation'].id;
                            // important because setcontent error when richtexteditor has not been booted properly
                            setTimeout(function () {
                                tinymce.get('nurse_notes_editor').setContent(response['consultation_form']);
                            }, 500);
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#nurse_notes_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },





                // write nurse notes2
                write_nurse_notes_two: function () {
                    var root_element = this; // the parent element
                    $('#nurse_notes_modal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    root_element.new_blank_nurse_form = false;
                    $('#nurse_notes_modal .loaderRefresh').fadeIn(0);
                    request = $.ajax({
                        url: baseUrl+'/write_nurse_notes_two',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'id':root_element.opened_consultation},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        nurse_notes_editor(); // call richtexteditor fresh forms of nurse notes
                        // update_nurse_notes(); // call richtexteditor nurse notes for update
                        root_element.nurse_notes_id = response['consultation'].id; // automatically assigned the consultation id
                        root_element.show_nurse_notes_print = true; // show nurse notes print btn
                        // create nurse notes print link
                        root_element.show_nurse_notes_print_link = baseUrl+'/printNurseNotes/'+response['consultation'].id;
                        // important because setcontent error when richtexteditor has not been booted properly
                        setTimeout(function () {
                            tinymce.get('nurse_notes_editor').setContent(response['consultation_form']);
                        }, 500);
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#nurse_notes_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },






                // insert vital signs on active text editor on modal
                insert_vs:function () {
                    var root_element = this; // the parent element
                    $('#nurse_notes_modal .loaderRefresh').fadeIn(0);
                    request = $.ajax({
                        url: baseUrl+'/insert_vs',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if(response){
                            root_element.replace_null(response); // replace null values with ""
                            var bp = '<p>BP: '+response.blood_pressure+'</p>';
                            var pr = '<p>BPM: '+response.pulse_rate+'</p>';
                            var rr = '<p>RR: '+response.respiration_rate+'</p>';
                            var temp = '<p>Temp: '+response.body_temperature+'</p>';
                            var wt = '<p>KG: '+response.weight+'</p>';
                            var ht = '<p>CM: '+response.height+'</p>';
                            var div = '<div>'+bp+pr+rr+temp+wt+ht+'</div>';
                            var td_content = tinymce.activeEditor.dom.select('td#doctors'); // get the td with id doctors
                            var td_current_content = $(td_content).html(); // get html content of td#doctors
                            // set the new content of td#doctors
                            tinymce.activeEditor.dom.setHTML(
                                tinymce.activeEditor.dom.select('td#doctors'), td_current_content + div);
                            toast('info', 'Today vital signs has been inserted.');
                        }else{
                            toast('error', 'Sorry! Todays vitals signs of this patient were not found.');
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#nurse_notes_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },


                // insert vs of this patient to the table
                vital_signs_insert: function (event) {
                    var root_element = this; // the parent element
                    $data = $('#vital_signs_form').serialize();
                    $('#vital_signs_modal').modal();
                    $('#vital_signs_modal .loaderRefresh').fadeIn(0);
                    request = $.ajax({
                        url: baseUrl+'/vital_signs_insert',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: $data,
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        root_element.replace_null(response); // replace null values with ""

                        $('#vital_signs_modal').find('input[type="text"]').val('');
                        /*--------- vital signs details ---------*/
                        root_element.$refs.bp.innerText = response.blood_pressure; //blood pressure
                        root_element.$refs.pr.innerText = response.pulse_rate; // pulse_rate
                        root_element.$refs.rr.innerText = response.respiration_rate; // respiration_rate
                        root_element.$refs.bt.innerText = response.body_temperature; // body_temperature
                        root_element.$refs.weight.innerText = response.weight; // weight
                        root_element.$refs.height.innerText = response.height; // height
                        toast('success', 'Vital signs successfully saved');
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#vital_signs_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },




                show_vs_modal: function(){
                     $('#vital_signs_modal').modal();
                },




                // get the charging records of this patient
                // total number of service request and total number service paid
                charging_records: function () {
                    var root_element = this; // the parent element
                    request = $.ajax({
                        url: baseUrl+'/charging_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if (response['allowed']) {
                            root_element.service_request = response['charges'].request_total;
                            root_element.paid_request = response['charges'].paid_total;
                            root_element.charging_allowed = true;
                        }else{
                            root_element.service_request = '';
                            root_element.paid_request = '';
                            root_element.charging_allowed = false;
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        root_element.enable_action_btn(); // enable action buttons
                    });
                },



                blank_nurse_form: function () {
                    var ans = confirm('Do you really want to create a new blank consultation form?');
                    if(ans){
                        this.new_blank_nurse_form = true;
                        this.nurse_notes_id = '';
                        var table = template_table(); // call empty template table
                        setTimeout(function () { // important delay the displaying of table
                            tinymce.get('nurse_notes_editor').setContent(table);
                        }, 500);
                    }
                },



                // get all todays referrals
                outgoing_referrals: function () {
                    var root_element = this; // the parent element
                    $('.todays_referral_li .loaderRefresh').fadeIn(0);
                    request = $.ajax({
                        url: baseUrl+'/outgoing_referral',
                        type: "get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        $('.list_notification').empty();
                        if (response.length){
                            var today = numeric_date();
                            $.each(response, function (index) {
                                // time the referral aws been created
                                var small = $('<small class="fa fa-clock-o text-muted">').
                                text(' '+hourMinCalculate(response[index].created_at));
                                // patient name
                                var p1 = $('<p class="referral_pname text-blue text-uppercase">').
                                text(response[index].last_name+', '+response[index].first_name);
                                // doctors name
                                var p2 = $('<p class="small referral_drname text-uppercase text-muted">').
                                text(
                                    'DR. '+response[index].ulast_name+', '+response[index].ufirst_name+' - '+
                                    response[index].name
                                );
                                var a = $('<a href="'+baseUrl+'/outgoing_referrals?start='+today+'&end='+today+'&search='+
                                    response[index].hospital_no+'">').append(small,p1,p2);
                                $('.list_notification').append(a)
                            })
                        }else{
                            var a = $('<a href="#" class="text-red text-center">').text('Outgoing referrals is currently empty.');
                            $('.list_notification').append(a)
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('.todays_referral_li .loaderRefresh').fadeOut('fast');
                    });
                },


                // show all incoming referrals
                incoming_referrals: function () {
                    var root_element = this; // the parent element
                    $('.incoming_referrals_list .loaderRefresh').fadeIn(0);
                    request = $.ajax({
                        url: baseUrl+'/incoming_referral',
                        type: "get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        $('.list_notification_incoming_referrals').empty();
                        if (response.length){
                            var today = numeric_date();
                            $.each(response, function (index) {
                                // time the referral aws been created
                                var small = $('<small class="fa fa-clock-o text-muted">').
                                text(' '+hourMinCalculate(response[index].created_at));
                                // patient name
                                var p1 = $('<p class="referral_pname text-blue text-uppercase">').
                                text(response[index].last_name+', '+response[index].first_name);
                                // doctors name
                                var p2 = $('<p class="small referral_drname text-uppercase text-muted">').
                                text(
                                    'DR. '+response[index].u_last_name+', '+response[index].u_first_name+' - '+
                                    response[index].name
                                );
                                var a = $('<a href="'+baseUrl+'/incoming_referrals?start='+today+'&end='+today+'&search='+
                                    response[index].hospital_no+'">').append(small,p1,p2);
                                $('.list_notification_incoming_referrals').append(a)
                            })
                        }else{
                            var a = $('<a href="#" class="text-red text-center">').text('Outgoing referrals is currently empty.');
                            $('.list_notification_incoming_referrals').append(a)
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('.incoming_referrals_list .loaderRefresh').fadeOut('fast');
                    });
                },



                // get all patients that has been charged today for notification
                charged_patients: function () {
                    var root_element = this; // the parent element
                    $('.charging_notification .loaderRefresh').fadeIn(0);
                    request = $.ajax({
                        url: baseUrl+'/charged_notifications',
                        type: "get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        $('.charged_menu_list').empty();
                        if (response.length){
                            var today = numeric_date();
                            $.each(response, function (index) {
                                // time the referral aws been created
                                var small = $('<small class="fa fa-clock-o text-muted">').
                                text(' '+hourMinCalculate(response[index].created_at));
                                // patient name
                                var p1 = $('<p class="referral_pname text-blue text-uppercase">').
                                text(response[index].last_name+', '+response[index].first_name);
                                // doctors name
                                var p2 = $('<p class="small referral_drname text-uppercase text-muted">').
                                text(response[index].sub_category+' - ₱ '+response[index].price+'.00');
                                var a = $('<a href="'+baseUrl+'/charged_patients?start='+today+'&end='+today+'&search='+
                                    response[index].hospital_no+'">').append(small,p1,p2);
                                $('.charged_menu_list').append(a)
                            })
                        }else{
                            var a = $('<a href="#" class="text-red text-center">').text('No patients that has been charged today.');
                            $('.charged_menu_list').append(a)
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('.charging_notification .loaderRefresh').fadeOut('fast');
                    });
                },




                // get all patients that has been charged today for notification
                followup_notifications: function () {
                    var root_element = this; // the parent element
                    $('.followup_notification .loaderRefresh').fadeIn(0);
                    request = $.ajax({
                        url: baseUrl+'/followup_notif',
                        type: "get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        $('.followup_list_notification').empty();
                        if (response.length){
                            var today = numeric_date();
                            $.each(response, function (index) {
                                // time the referral aws been created
                                var small = $('<small class="fa fa-clock-o text-muted">').
                                text(' '+hourMinCalculate(response[index].created_at));
                                // patient name
                                var p1 = $('<p class="referral_pname text-blue text-uppercase">').
                                text(response[index].last_name+', '+response[index].first_name);
                                // doctors name
                                var p2 = $('<p class="small referral_drname text-uppercase text-muted">').
                                text('DR. '+response[index].u_last_name+', '+response[index].u_first_name);
                                var a = $('<a href="'+baseUrl+'/followup_notifications?start='+today+'&end='+today+'&search='+
                                    response[index].hospital_no+'">').append(small,p1,p2);
                                $('.followup_list_notification').append(a)
                            })
                        }else{
                            var a = $('<a href="#" class="text-red text-center">').text('There is no patients scheduled today for followup.');
                            $('.followup_list_notification').append(a)
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('.followup_notification .loaderRefresh').fadeOut('fast');
                    });
                },



                // show all consultations on modal
                consultation_show_all: function () {
                    var root_element = this; // the parent element
                    $('#consultation_all_modal').modal();
                    $('#consultation_all_modal .loaderRefresh').fadeIn(0);
                    request = $.ajax({
                        url: baseUrl+'/get_all_consultation_records',
                        type: "post",
                        data: {'pid':root_element.pid},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        console.log(response)
                        if (response){
                            root_element.consultations_all = response;
                            root_element.open_consultation('first', 0) // show the first consultation
                            root_element.consultation_count = response.length;
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#consultation_all_modal .loaderRefresh').fadeOut('fast');
                        setTimeout(function(){
                            $('div.thumbnail_wrapper:first').addClass('thumbnail_wrapper_focused');
                        }, 100)
                    });
                },


                // selected consultation to be shown in consultation all modal
                open_consultation: function (event, index) {


                    this.nurse_notes_consultation_single_open = 'multiple_open'; // open all consultations

                    // bind href to print button
                    this.consultation_print_btn = baseUrl+'/printNurseNotes/'+this.search_filter_consultation[index].cid;

                    this.highlight_thumbnail(event);

                    this.opened_consultation = this.search_filter_consultation[index].cid;

                    this.featured_consultation = this.search_filter_consultation[index].consultation;
                    this.featured_clinic = this.search_filter_consultation[index].name;

                    var doctor = this.search_filter_consultation[index].last_name+', '+this.search_filter_consultation[index].first_name+' '+
                        this.search_filter_consultation[index].middle_name;
                    var ext = (this.search_filter_consultation[index].role == 7)? 'DR. ' : 'OTHERS ';

                    this.featured_doctor = doctor;
                    this.featured_ext = ext;
                    this.featured_date = this.search_filter_consultation[index].created_at;

                    this.featured_nurse_notes = (auth_role == 5 || auth_role == 6)? true : false;
                    this.featured_edit_consultation =
                        (authenticate == this.search_filter_consultation[index].users_id && auth_role == 7)? true : false;

                },


                highlight_thumbnail: function(event){
                    $('div.thumbnail_container div.thumbnail_wrapper_main').each(function(index){
                        $(this).find('div.thumbnail_wrapper').removeClass('thumbnail_wrapper_focused');
                    });
                    $(event.target).closest('div.thumbnail_wrapper').addClass('thumbnail_wrapper_focused');
                },



                
                



            }, // end of methods




            computed:{

                queued_action_buttons: function()
                {
                    var root_element = this;
                    request = $.ajax({
                        url: baseUrl+'/queued_action_buttons',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if(response.queue.status == 'F'){ //Finished consultation
                            root_element.assignations = false;
                            root_element.re_assign = true;
                            root_element.nawc = false;
                        }else if(response.queue.status == 'S'){ // Serving patient
                            root_element.assignations = false;
                            root_element.re_assign = false;
                            root_element.nawc = false;
                        }else if(response.queue.status == 'C'){ // NAWC patient
                            root_element.assignations = false;
                            root_element.re_assign = true;
                            root_element.nawc = false;
                        }else if(response.queue.status == 'H'){ // Paused patient
                            root_element.assignations = false;
                            root_element.re_assign = true;
                            root_element.nawc = false;
                        }else if(response.queue.status == 'P'){ // Pending patient
                            root_element.assignations = false;
                            root_element.re_assign = true;
                            root_element.nawc = false;
                        }else{                                  // Unassigned patient
                            root_element.assignations = true;
                            root_element.re_assign = false;
                            root_element.nawc = true;
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        root_element.spinner_action_btn = false;
                    });
                    return;
                },

                search_filter_consultation: function(){
                    return this.consultations_all.filter((consultation) => {
                        var last_name = consultation.last_name.toLowerCase();
                        var clinic = consultation.name.toLowerCase();

                        if (last_name.match(this.search_filter.toLowerCase()) ||
                            clinic.match(this.search_filter.toLowerCase())){
                            return true;
                        }else{
                            return false;
                        }
                    });
                }

            }, // end of computed properties


            filters: {
                capitalize: function (value) {
                    if (!value) return '';
                    return value.toString().toUpperCase();
                },
                uppercase: function (value) {
                    if (!value) return '';
                    return value.toString().toUpperCase();
                },
                formatted_date: function (value) {
                    if (!value) return '';
                    var d = new Date(value);
                    var days = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                    var month = days[d.getMonth()];
                    var day = (d.getDate() < 10)? '0' + d.getDate().toString() : d.getDate();
                    var year = d.getFullYear();
                    var today = month+' '+day+', '+year;
                    return today;
                }
            }





})





/*-- when <tr> is clicked for assignation */
function assign_to_doctor_now(doctors_id)
{
    queue_vue.assign_now(doctors_id); // locate vue method
}


/*-- when <tr> is clicked for re_assignation */
function re_assign_to_doctor_now(doctors_id)
{
    queue_vue.re_assign_now(doctors_id); // locate vue method
}

// $id is consultation id
function show_consultation_now($id) {
    event.preventDefault();
    queue_vue.show_consultation($id);
}

// open all consultations
function open_all_consultations() {
    event.preventDefault();
    queue_vue.consultation_show_all();
}


$('.todays_referral_li').on('show.bs.dropdown', function () {
    queue_vue.outgoing_referrals();
});

$('.incoming_referrals_list').on('show.bs.dropdown', function () {
    queue_vue.incoming_referrals();
});

$('.charging_notification').on('show.bs.dropdown', function () {
    queue_vue.charged_patients();
});
$('.followup_notification').on('show.bs.dropdown', function () {
    queue_vue.followup_notifications();
});











