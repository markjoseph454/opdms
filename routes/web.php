<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*--------------------- Migrating DB ------------------*/
/*Route::get('mergeUser', 'UsersController@mergeUser');
Route::get('mergePatients', 'PatientsController@mergePatients');
Route::get('mergeConsultations', 'ConsultationController@mergeConsultations');*/
// Route::get('duplicate', 'PatientsController@duplicate');




Route::group(['middleware' => ['web']], function () {
    Route::get('/', function() {
        return view('partials.login');
    })->name('loginpage');
    Route::post('login', 'UsersController@login');
});








Route::group(['middleware' => ['auth']], function () {

    Route::post('logout', 'UsersController@logout');
    Route::get('theme/{theme}', 'UsersController@theme');
    Route::post('update_account', 'UsersController@update_account');
    Route::resource('users', 'UsersController');


    Route::get('approval/{pid?}/{did?}', 'AjaxController@approval');
    Route::get('forApprovals', 'AjaxController@forApprovals');
    Route::get('markAsApproved/{id?}', 'AjaxController@markAsApproved');
    Route::get('markAsUnApproved/{id?}', 'AjaxController@markAsUnApproved');
    Route::post('approvalMedicalRecords', 'AjaxController@approvalMedicalRecords');
    Route::post('approvalConsultationList', 'AjaxController@approvalConsultationList');

    Route::post('ajaxRequisitionList', 'AjaxController@ajaxRequisitionList');
    Route::post('ajaxRefferals', 'AjaxController@ajaxRefferals');
    Route::post('ajaxFollowup', 'AjaxController@ajaxFollowup');
    Route::post('getAuth', 'AjaxController@getAuth');
    Route::post('ultrasoundShow', 'LabController@ultrasoundShow');


    /*---- edited for lab --------*/

    Route::post('ultrasoundWatch', 'LabController@ultrasoundWatch');
    Route::resource('lab', 'LabController');


    Route::post('medsWatch', 'AjaxMedsController@medsWatch');
    Route::post('medsUpdate', 'AjaxMedsController@medsUpdate');
    Route::post('medsDelete', 'AjaxMedsController@medsDelete');
    Route::resource('meds', 'AjaxMedsController');


    /*-------- edited for lab -------*/

    Route::post('radiologyResult', 'RadiologyController@radiologyResult');
    Route::post('quickView', 'RadiologyController@quickView');

    Route::get('rcptn_consultationDetails/{id?}', 'ReceptionsController@rcptn_consultationDetails');


    Route::get('requisition_print/{id?}', 'RequisitionController@requisition_print');



    Route::get('topLeadingServices/{starting?}/{ending?}/{limit?}', 'ReportsRadController@topLeadingServices');
    Route::post('topLeadingServices', 'ReportsRadController@searchTopServices');


    Route::get('medServicesAccomplished/{starting?}/{ending?}/{category?}', 'ReportsRadController@medServicesAccomplished');
    Route::post('medServicesAccomplished', 'ReportsRadController@search');


    Route::get('radiologyPrint/{rid}', 'RadiologyController@radiologyPrint');


    Route::get('highestCases/{starting?}/{ending?}', 'ReportsRadController@highestCases');
    Route::post('highestCases', 'ReportsRadController@highestCasesSearch');
    Route::get('weeklyCensus/{date?}', 'ReportsRadController@weeklyCensus');
    Route::post('weeklyCensus', 'ReportsRadController@weeklyCensusStore');
    
    Route::get('medical_certificate/{pid?}/{id?}', 'MedicalCertificateController@store');
    Route::get('printNurseNotes/{id}', 'ConsultationController@print');

    //edited for pedia
    Route::get('patient_information/{pid?}', 'PatientInformationController@patient_information');


    Route::get('industrialPrint/{id?}', 'IndustrialController@printing');
    
    
});






Route::group(['middleware' => ['register']], function(){
    
    Route::post('registersearch', 'REGISTER\QuerysController@Search');
    Route::get('registerclinics', 'REGISTER\QuerysController@clinics');
    Route::get('RegisteredToday', 'REGISTER\QuerysController@today');
    Route::get('getAddress', 'REGISTER\QuerysController@address');
    Route::post('reserveHospitalNo', 'REGISTER\QuerysController@reserve');
    Route::get('printMultiple/{count}', 'REGISTER\QuerysController@print');
    Route::post('searchprintMultiple', 'REGISTER\QuerysController@searchprint');
    Route::get('removePatientInfo/{id}', 'REGISTER\QuerysController@patient');
    Route::get('cancelRemoveRequest/{id}', 'REGISTER\QuerysController@cancel');
    Route::get('information/{id}', 'REGISTER\QuerysController@information');
    Route::get('register_report', 'REGISTER\QuerysController@register_report');
    Route::get('getpatienttransaction/{id}', 'REGISTER\QuerysController@getpatienttransaction');
    Route::resource('patients', 'REGISTER\RegisterController');



    Route::get('regions', 'AddressController@regions');
    // Route::get('register_account', 'UsersController@registerAccount');
    // Route::get('census', 'PatientsController@census');
    // Route::post('census', 'PatientsController@getcensus');
    Route::post('province', 'AddressController@province');
    Route::post('city_municipality', 'AddressController@city_municipality');
    Route::post('brgy', 'AddressController@brgy');
    // Route::get('unprinted', 'PatientsController@unprinted');
    // Route::get('searchpatient', 'PatientsController@searchpatient');
    // Route::post('search', 'PatientsController@search');
    Route::get('hospitalcard/{id}', 'BarcodeController@hospitalcard');
    // Route::post('printed', 'PatientsController@printed');
    // Route::get('registerreport', 'PatientsController@registerreport');
    // Route::post('searchpatientmodal', 'PatientsController@searchpatientmodal');
    // Route::get('markfordelete/{id}', 'PatientsController@markfordelete');
    // Route::get('restorepatient/{id}', 'PatientsController@restorepatient');
    // Route::get('referralreport', 'PatientsController@referralreport');
    // Route::get('getuserbyclinic/{id}', 'PatientsController@getuserbyclinic');
   
    // Route::get('getpatientwatcher/{id}', 'WatchersController@getpatientwatcher');
    // Route::post('checkpatients', 'PatientsController@checkpatient');
    // Route::post('ignorepatients', 'PatientsController@ignorepatients');
    // Route::get('admitpatient/{id}', 'PatientsController@admitpatient');
    // Route::get('dischargedpatient/{id}', 'PatientsController@dischargedpatient');
    // Route::get('admitpatientbyid/{id}', 'PatientsController@admitpatientbyid');

    // Route::get('selectpatient/{id}', 'InpatientsController@selectpatient');
    // Route::get('admittedpatient', 'InpatientsController@admittedpatient');
    // Route::post('searchadmitted', 'InpatientsController@searchadmitted');
    // Route::post('checkwatcher', 'InpatientsController@checkwatcher');
    // Route::get('selectwatcher/{pid}/{wid}', 'InpatientsController@selectwatcher');
    // Route::get('deleteinpatient/{pid}', 'InpatientsController@deleteinpatient');
    // Route::get('deletewatcher/{pid}/{wid}', 'WatchersController@deletewatcher');
    // Route::resource('patients', 'PatientsController');
    // Route::resource('watcher', 'WatchersController');



    // //Route::get('searchwatch/{search?}', 'SearchWatcherController@searchwatch');
    // //Route::post('searchwatcher', 'SearchWatcherController@store');
    // Route::post('searchwatcher', 'SearchWatcherController@store');

});






Route::group(['middleware' => ['admin']], function(){
	Route::get('register', 'UsersController@register');
	Route::get('userlist', 'UsersController@userlist');
	Route::get('editUser/{id?}', 'UsersController@editUser');
	Route::get('decrypt/{id?}', 'AdminController@decrypt');
	Route::post('updateUser', 'UsersController@updateUser');
});






Route::group(['middleware' => 'triage'], function() {
    Route::get('triageAccount', 'UsersController@triageAccount');
    Route::post('triagebarcode', 'TriageController@barcode');
    Route::get('triagehomepage/{id}', 'TriageController@triagehomepage');
    Route::get('triagesearch', function() {
        return view('triage.search');
    });
    Route::post('triagesearch', 'TriageController@search');
    Route::get('triage_history/{id?}', 'TriageController@triage_history');
    Route::resource('triage', 'TriageController');
});




/*--------------- START OF DOCTORS ROUTE ---------------*/

Route::group(['middleware' => 'doctors'], function() {

    Route::get('deletefile/{file?}/{pd?}', 'FileController@deletefile');
    Route::get('removefile/{id?}', 'FileController@removefile')->middleware('patients');
    Route::get('print/{id}', 'ConsultationController@print');


    Route::post('selectDoctors', 'RefferalController@selectDoctors');
    Route::get('followup_list/{pid?}', 'FollowupController@followup_list');
    Route::get('review_followup/{pid?}', 'FollowupController@review_followup');
    Route::get('nowservingfollowup/{pid?}', 'FollowupController@followup_list')->middleware('patients');
    Route::get('delete_followup/{id?}', 'FollowupController@destroy');
    Route::resource('followup', 'FollowupController');

    Route::get('refferal_list/{pid?}', 'RefferalController@refferal_list');
    Route::get('review_refferal/{pid?}', 'RefferalController@review_refferal');
    Route::get('nowservingrefferal/{pid?}', 'RefferalController@refferal_list')->middleware('patients');
    Route::get('delete_refferal/{id?}', 'RefferalController@destroy');
    Route::resource('refferal', 'RefferalController');

    Route::post('checkMssClassification', 'RequisitionController@checkMssClassification');
    Route::post('choosedepartment', 'RequisitionController@choosedepartment')->middleware('patients');
    Route::get('requisitions_list/{id?}', 'RequisitionController@requisitions_list');
    Route::post('requisition_update', 'RequisitionController@requisition_update');
    Route::post('requisitionUpdate', 'RequisitionController@requisitionUpdate');

    Route::resource('requisition', 'RequisitionController');


    Route::get('createAnewForm', 'ConsultationController@createAnewForm');
    Route::post('deleteCICD', 'ConsultationController@destroy');
    Route::get('consultationpreview/{id?}', 'ConsultationController@consultationpreview');
    Route::get('consultationdelete/{id?}', 'ConsultationController@delete');
    Route::post('filemanager', 'FileController@store')->middleware('patients');
    Route::resource('consultation', 'ConsultationController');


    Route::get('patientlist/{status?}', 'DoctorsController@patientlist');
    Route::get('patientinfo/{id?}', 'DoctorsController@patient_info');
    Route::get('startConsultation/{id?}', 'DoctorsController@startConsultation');
    Route::get('endConsultation', 'DoctorsController@endConsultation');
    Route::get('patientinformation', 'DoctorsController@patientinformation')->middleware('patients');
    Route::get('history/{id?}', 'DoctorsController@history');
    Route::get('consultation_list/{id?}', 'DoctorsController@consultation_list');
    Route::get('nowservingconsultations/{id?}', 'DoctorsController@consultation_list')->middleware('patients');
    Route::get('review/{id?}', 'DoctorsController@review');
    Route::get('review_consultation_list/{id?}', 'DoctorsController@review_consultation_list');
    Route::get('diseases', 'DoctorsController@diseases');
    Route::get('cancelPatient/{id?}', 'DoctorsController@cancelPatient');
    Route::get('doctors_account', 'UsersController@edit_account');
    Route::get('restorePatient/{id?}', 'DoctorsController@restorePatient');


    Route::get('pausePatient/{id?}', 'DoctorsController@pausePatient');
    Route::get('reConsult/{id?}', 'DoctorsController@reConsult');
    Route::get('stopConsultation/{id?}', 'DoctorsController@stopConsultation');
    Route::get('continueServing/{id?}', 'DoctorsController@continueServing');


    Route::get('medical_imaging', 'MedicalImagingController@medical_imaging');
    Route::post('misc', 'MedicalImagingController@medical_img');


    Route::resource('doctors_order', 'DoctorsOrderController');

    Route::resource('medical', 'DoctorsController');




//Route::post('searchICD', 'DiagnosisController@searchICD');
    Route::get('searchICD', 'DiagnosisController@searchICD');
    Route::get('searchICDByCode', 'DiagnosisController@searchICDByCode');
    Route::post('deleteDICD', 'DiagnosisController@destroy');
    Route::get('diagnosisdestroy/{id?}', 'DiagnosisController@delete');
    Route::get('diagnosis_list/{id?}', 'DiagnosisController@diagnosis_list');
    Route::get('printdiagnosis/{id?}', 'DiagnosisController@printdiagnosis');
    Route::resource('diagnosis', 'DiagnosisController');



    Route::get('xray_list/{id?}', 'LaboratoryController@xray_list');
    Route::get('xrayShow/{id?}', 'LaboratoryController@xrayShow');
    Route::get('xrayEdit/{id?}', 'LaboratoryController@xrayEdit');
    Route::resource('laboratory', 'LaboratoryController');



    Route::get('consultationLogs/{starting?}/{ending?}/{status?}', 'ConsultationLogsController@consultationLogs')->name('logsConsultation');
    Route::post('consultationLogs', 'ConsultationLogsController@searchConsultationLogs');


    Route::get('consultation_tag/{cid?}/{clinic}', 'TagsController@store');


    Route::post('consultationWatch', 'RecordsController@consultationWatch');



    Route::post('industrialStore', 'IndustrialController@store');
    Route::get('industrialPreview/{id?}', 'IndustrialController@preview');

    Route::resource('industrial', 'IndustrialController');



    /*-- smoke --*/
    Route::get('storeSmoke/{pid}', 'SmokeController@storeSmoke');
    Route::get('deleteSmoke/{pid}', 'SmokeController@deleteSmoke');
    Route::get('smoke_cessation/{start?}/{end?}', 'SmokeController@smoke_cessation');
    Route::post('smoke_store', 'SmokeController@smoke_store');


    Route::get('doctors_census/{starting?}/{ending?}/{limit?}', 'DoctorsCensus@doctors_census');
    Route::post('doctorsStoreCensus', 'DoctorsCensus@doctorsStoreCensus');

    // PHIC Annex 2
    Route::post('phic_annex', 'PHICController@show');



});
/*--------------- END OF DOCTORS ROUTE ---------------*/







Route::group(['middleware' => 'radiology'], function (){
    Route::post('radiologyWatch', 'RadiologyController@radiologyWatch');
    Route::get('addResult/{id}', 'RadiologyController@addResult');
    Route::get('radiologySearch', 'RadiologyController@radiologySearch');
    Route::post('radiologySearch', 'RadiologyController@search');
    Route::get('radiologyhistory/{starting?}/{ending?}', 'RadiologyController@history');
    Route::get('markedDone/{qid?}/{status?}', 'ReceptionsController@queueStatus');
    Route::post('radiologyhistory', 'RadiologyController@radiologyhistory');
    Route::get('radiologyHome/{status?}', 'RadiologyController@radiologyHome');
    Route::get('addTemplate', 'RadiologyController@addTemplate');
    Route::get('editTemplate/{id?}', 'RadiologyController@editTemplate');
    Route::post('editTemplate', 'RadiologyController@storeEditTemplate');
    Route::post('templates', 'RadiologyController@storeTemplates');
    Route::post('showTemplate', 'RadiologyController@showTemplate');
    Route::resource('radiology', 'RadiologyController');
});


/*Route::post('radiologyScan', 'RadiologyRcptnController@scan');
Route::resource('radiologyRcptn', 'RadiologyRcptnController');*/








Route::group(['middleware' => 'receptions'], function (){
    Route::get('receptionsAccount', 'UsersController@receptionsAccount');
    Route::get('vs_scanbarcode', 'ReceptionsController@vs_scanbarcode');
    Route::post('vs_scanbarcode', 'ReceptionsController@vs_verifybarcode');
    Route::get('vitalSigns/{id?}', 'ReceptionsController@vitalSigns');
    Route::post('storeVitalSigns', 'ReceptionsController@storeVitalSigns');
    Route::get('doctorsStatus', 'ReceptionsController@doctorsStatus');
    Route::get('patientsStatus', 'ReceptionsController@patientsStatus');
    Route::get('patientsearch', 'ReceptionsController@patientsearch');
    Route::post('patientsearch', 'ReceptionsController@searchpatient');
    Route::get('status/{did?}/{status?}', 'ReceptionsController@status');
    Route::post('receptionsbarcode', 'ReceptionsController@receptionsbarcode');
    Route::get('overview/{status?}', 'ReceptionsController@overview');
    Route::get('patient_info/{id?}', 'ReceptionsController@patient_info');
    Route::get('assign/{pid?}/{did?}', 'AssignationsController@assign');
    Route::get('reassign/{did?}/{id?}', 'AssignationsController@reassign');
    Route::get('cancelAssignation/{id?}', 'AssignationsController@cancelAssignation');
    Route::get('cancelUnassigned/{id?}', 'AssignationsController@cancelUnassigned');
    Route::get('receptions_records/{id?}', 'ReceptionsController@receptions_records');
    Route::get('receptions_reqList/{id?}', 'ReceptionsController@receptions_reqList');
    Route::get('receptions_reqShow/{id?}', 'ReceptionsController@receptions_reqShow');
    Route::get('rcptn_consultation_list/{id?}', 'ReceptionsController@rcptn_consultation_list');

    Route::get('rcptn_diagnosisList/{id?}', 'ReceptionsController@rcptn_diagnosisList');
    Route::get('rcptn_diagnosisShow/{id?}', 'ReceptionsController@rcptn_diagnosisShow');
    Route::get('rcptn_refferalList/{id?}', 'ReceptionsController@rcptn_refferalList');
    Route::get('rcptn_followupList/{id?}', 'ReceptionsController@rcptn_followupList');
    Route::get('famedcensus/{starting?}/{ending?}/{limit?}', 'CensusController@famedcensus');
    Route::post('receptionCensus', 'CensusController@receptionCensus');

    Route::get('queueStatus/{qid?}/{status?}', 'ReceptionsController@queueStatus');
    Route::get('done/{id?}/{status?}', 'ReceptionsController@done');

    Route::resource('receptions', 'ReceptionsController');
    Route::get('rcptnLogs/{starting?}/{ending?}/{doctor?}', 'NurseNotesController@rcptnLogs')->name('rcptnLogs');
    Route::post('rcptnLogs', 'NurseNotesController@rcptnLogsShow');
    Route::get('demographic/{start?}/{ending?}/{category?}', 'CensusController@demographic')->name('demographic');
    Route::post('demographic', 'CensusController@demographicRequest');
    Route::get('demographicSummary/{start?}/{ending?}', 'CensusController@demographicSummary')->name('demographicSummary');
    Route::post('demographicSummary', 'CensusController@demographicSummaryPost');
    Route::resource('nurseNotes', 'NurseNotesController');


    Route::get('censusWatch/{category?}/{starting?}', 'MonitoringController@censusWatch');
    Route::get('censusMonthly/{starting?}/{ending?}/{category?}', 'MonitoringController@censusMonthly');
    Route::resource('monitoring', 'MonitoringController');

    Route::get('refferalsReport/{start?}/{end?}', 'ReferralsReportController@refferalsReport');
    Route::post('refferalsReport', 'ReferralsReportController@store');


    /* nurse notes */
    Route::get('chief_complaint/{pid?}', 'ChiefComplaintController@chief_complaint');
    Route::post('saveChiefComplaint', 'ChiefComplaintController@saveChiefComplaint');

});





Route::group(['middleware' => 'mss'], function() {
    Route::post('classification', 'MssController@classification');
    Route::post('classifiedbyday', 'MssController@classifiedbyday');
    Route::get('classified', 'MssController@classified');
    Route::get('view/{id}', 'MssController@view');
    Route::post('searchrecord', 'MssController@search');
    Route::get('msssearch', function() {
            return view('mss.searchpatient');
        });
    Route::get('report', 'MssController@report');
    Route::post('genaratedreport', 'MssController@genaratedreport');
    Route::get('mssform/{id}', 'ClassificationController@mssform');
    Route::get('malasakit/{id}', 'MalasakitController@malasakit');
    Route::post('malasakitsave', 'MalasakitController@malasakitsave');
    Route::get('malasakitprint/{id}', 'MalasakitController@malasakitprint');
    Route::get('migrate', 'MssController@migrate');
    Route::resource('mss', 'MssController');

});







//Nurse Pediasearchpatient

Route::get('otpc_homepage/{patient?}', 'OTPCController@otpc_homepage');
Route::post('otpc_save', 'OTPCController@otpc_save');
Route::get('pediaQueing', 'OTPCController@pediaQueing');
Route::get('pediaSearch', 'OTPCController@pediaSearch');
Route::get('pediaSearchPatient', 'OTPCController@pediaSearchPatient');
Route::get('otpc_edit/{id?}', 'OTPCController@edit');
Route::post('therapeuticCareList', 'OTPCController@therapeuticCareList');
Route::post('childHoodCareList', 'ChildHoodCareController@childHoodCareList');
Route::get('printOTC/{id?}', 'OTPCController@printOTC');
Route::get('printChildHoodCare/{id?}', 'ChildHoodCareController@printChildHoodCare');
Route::get('childhood_care/{patient?}', 'ChildHoodCareController@create');
Route::get('childhood_care_edit/{id?}', 'ChildHoodCareController@edit');
Route::post('save_early_childhood_care', 'ChildHoodCareController@store');
Route::get('kmc/{patient?}', 'KMCController@create');
Route::get('kmc_edit/{id?}', 'KMCController@edit');
Route::post('kmcList', 'KMCController@kmcList');
Route::post('kmc_store', 'KMCController@store');
Route::get('printKMC/{id?}', 'KMCController@printKMC');








Route::group(['middleware' => 'pharmacist'], function() {
    Route::get('phartransaction', 'PharmacyController@phartransaction');
    Route::post('viewpatientmedtransaction', 'PharmacyController@viewpatientmedtransaction');
    Route::post('managerequisition', 'PharmacyController@managerequisition');
    Route::post('updatemanagerequisition', 'PharmacyController@updatemanagerequisition');
    Route::post('deleterequistion', 'PharmacyController@deleterequistion');
    Route::post('updatetransactionissuance', 'PharmacyController@updatetransactionissuance');
    Route::post('saverequistion', 'PharmacyController@saverequistion');
    Route::get('transactionlist', 'PharmacyController@transactionlist');
    Route::get("postcharge/{display}", 'PharmacyController@postcharge');
    Route::post('edititem', 'PharmacyController@edititem');
    Route::get('updateditem/{id}', 'PharmacyController@update');
    Route::get('deleteitem/{id}', 'PharmacyController@destroy');
    Route::get('logs', 'PharmacyController@logs');
    Route::post('getItemstatus', 'PharmacyController@getItemstatus');
    Route::post('cancelmanagerequisition', 'PharmacyController@cancelmanagerequisition');
    Route::get('reports', 'ConsolidationController@reports');
    Route::post('restoremeds', 'PharmacyController@restoremeds');
    Route::get('exportmedicineotpdf', 'ConsolidationController@exportmedicineotpdf');
    Route::get('pharmacycencus', 'ConsolidationController@pharmacycencus');
    Route::post('getallpendingrequesition', 'PharmacyController@getallpendingrequesition');
    Route::get('deletecheckpendingrequesition/{id}', 'PharmacyController@deletecheckpendingrequesition');
    Route::post('getallpendingmanaged', 'PharmacyController@getallpendingmanaged');
    Route::get('deletecheckpendingmanaged/{id}', 'PharmacyController@deletecheckpendingmanaged');
    Route::post('getallundonetransactions', 'PharmacyController@getallundonetransactions');
    Route::get('donepaidrequisition/{id}', 'PharmacyController@donepaidrequisition');
    // Route::get('patientrequest', 'PharmacyController@patientrequist');
    // Route::post('scan', 'PharmacyController@scan');
    // Route::get('managerequest', 'PharmacyController@managerequest');
    // Route::post('scancontrol', 'PharmacyController@scancontrol');
    // Route::post('saverequest', 'PharmacyController@saverequest');
    // Route::post('markasdone', 'PharmacyController@markasdone');
    // Route::get('donetransaction', 'PharmacyController@transaction');
    // Route::get('inventory', 'PharmacyController@inventory');
    // Route::post('getusertransaction', 'PharmacyController@getusertransaction');
    // Route::get('managedtransaction', 'PharmacyController@managedtransaction');
    // Route::get('editmanagereqeust/{modifier?}', 'PharmacyController@editmanagereqeust');
    // Route::get('cancelmanagerequest/{modifier?}', 'PharmacyController@cancelmanagerequest');
    // Route::post('updatemanageqty', 'PharmacyController@updatemanageqty');
    // Route::post('deletemanageqty', 'PharmacyController@deletemanageqty');
    // Route::post('scancontrolbygroup', 'PharmacyController@scancontrolbygroup');
    // Route::get('manualinput', 'PharmacyController@manualinput');
    // Route::post('setmedicine', 'PharmacyController@setmedicine');
    // Route::post('checkclassification', 'PharmacyController@checkMssClassification');
    // Route::post('pharmacystore', 'PharmacyController@pharmacystore');
    // Route::get('issuance_DOH', 'ConsolidationController@issuance_DOH');
    // Route::post('viewpendingrequisition', 'PharmacyController@viewpendingrequisition');
    // Route::post('viewmanagedrequisition', 'PharmacyController@viewmanagedrequisition');
    // Route::get('managerequistion/{modifier}/{patient_id}', 'PharmacyController@managerequistion');
    // Route::post('removemanagerequistion', 'PharmacyController@removemanagerequistion');
    // Route::get('editmanagerequistion/{modifier}/{patient_id}/{mgmtmod}', 'PharmacyController@editmanagerequistion');
    // Route::post('viewpaidrequisition', 'PharmacyController@viewpaidrequisition');
    // Route::post('updatemanagerequest', 'PharmacyController@updatemanagerequest');
    // Route::get('editpaidrequistion/{modifier}/{mss}/{id}', 'PharmacyController@editpaidrequistion');
    // Route::post('updatepaidrequisition', 'PharmacyController@updatepaidrequisition');
    Route::resource('pharmacy', 'PharmacyController');
});




Route::group(['middleware' => 'cashier'], function() {
    Route::post('getpatientbymonth', 'CashierController@getpatientbymonth');
    Route::post('getpatientbyid', 'CashierController@getpatientbyid');
    Route::post('setrecieptnumber', 'CashierController@setrecieptnumber');
    Route::post('submittransaction', 'CashierController@submittransaction');
    Route::post('scanbarcode', 'CashierController@scanbarcode');
    Route::post('getpatientbybarcode', 'CashierController@getpatientbybarcode');
    Route::get('printreciept', 'CashierprintController@printreciept');
    Route::get('transaction', 'CashierController@transaction');
    Route::post('getallTransactionsbyday', 'CashierController@getallTransactionsbyday');
    Route::post('reprintbymonth', 'CashierController@reprintbymonth');
    Route::get('monthlya', 'CashierController@monthlya');
    Route::post('reprintgetpatientbymonth', 'CashierController@reprintgetpatientbymonth');
    Route::post('checkcredintials', 'CashierController@checkcredintials');
    Route::post('gettransactionbymonth', 'CashierController@gettransactionbymonth');
    Route::post('gettransactionbyorno', 'CashierController@gettransactionbyorno');
    Route::post('voidtransaction', 'CashierController@voidtransaction');
    Route::post('unvoidtransaction', 'CashierController@unvoidtransaction');
    Route::post('getsubcaegorybycaetogoryid', 'CashierController@getsubcaegorybycaetogoryid');
    Route::post('getortransaction', 'CashierController@getortransaction');
    Route::post('searchpatient', 'CashierController@searchpatient');
    Route::post('searchreprintid', 'CashierController@searchreprintid');
    Route::get('dailyreport', 'CashierreportController@dailyreport');
    Route::get('reprint/{or}/{type}', 'CashierController@reprint');
    Route::post('updaterecieptnumber', 'CashierController@updaterecieptnumber');
    Route::get('getcategory', 'CashierController@getcategory');
    Route::post('getsubcategorybycatid', 'CashierController@getsubcategorybycatid');
    Route::get('searchospitalno/{no}', 'CashierController@searchospitalno');
    Route::post('storeincomeor', 'CashierController@storeincomeor');
    Route::post('changetransactionpatient/{id}', 'CashierController@changetransactionpatient');
    Route::get('exporttransactiontoexcell', 'CashierExcelReportController@export')->name('exporttransactiontoexcell');
    Route::resource('cashier', 'CashierController');
});

Route::group(['middleware' => 'referral'], function() {
    Route::resource('referral', 'ReferralController');
});


Route::group(['middleware' => 'medicalrecord'], function() {
    Route::get('getpatientinfoandmssbyid/{id}', 'MedicalrecordsController@getpatientinfoandmssbyid');
    Route::get('getpatientconsultationbyid/{id}', 'MedicalrecordsController@getpatientconsultationbyid');
    Route::get('viewpatientconsultation/{id}', 'MedicalrecordsController@viewpatientconsultation');
    Route::post('addpatient', 'MedicalrecordsController@addpatient');
    Route::post('addrequest', 'MedicalrecordsController@addrequest');
    Route::resource('medicalrecord', 'MedicalrecordsController');
});

Route::group(['middleware' => 'malasakit'], function() {
    Route::post('checkpatient', 'MalasakitController@checkpatient');
    Route::resource('malasakit', 'MalasakitController');

});




    Route::get('services', 'AncillaryController@services');
    Route::post('editservice', 'AncillaryController@editservice');
    Route::get('movetotrash/{id}', 'AncillaryController@movetotrash');
    Route::get('directrequisition', 'AncillaryController@directrequisition');
    Route::post('scandirect', 'AncillaryController@scandirect');
    Route::post('ancillaryrequisition', 'AncillaryController@ancillaryrequisition');
    Route::get('ancillarytransaction', 'AncillaryController@ancillarytransaction');
    Route::get('viewpaidrequisition/{modifier}/{patient_id}', 'AncillaryController@viewpaidrequisition');
    Route::get('removepaidrequisition/{modifier}', 'AncillaryController@removepaidrequisition');
    Route::get('paidtransaction', 'AncillaryController@paidtransaction');
    Route::post('updateancillaryrequisition', 'AncillaryController@updateancillaryrequisition');
    Route::get('unpaidtransaction', 'AncillaryController@unpaidtransaction');
    Route::get('viewunpaidrequisition/{modifier}/{patient_id}', 'AncillaryController@viewunpaidrequisition');
    Route::post('updateunpaidancillaryrequisition', 'AncillaryController@updateunpaidancillaryrequisition');
    Route::get('removeunpaidrequisition/{modifier}', 'AncillaryController@removeunpaidrequisition');
    Route::get('maskasdonerequistion/{modifier}/{patient_id}', 'AncillaryController@maskasdonerequistion');
    Route::get('markparticularasdone/{id}', 'AncillaryController@markparticularasdone');
    Route::get('markparticularaspending/{id}', 'AncillaryController@markparticularaspending');
    Route::post('viewpaidparticulars', 'AncillaryController@viewpaidparticulars');
    Route::post('viewunpaidparticulars', 'AncillaryController@viewunpaidparticulars');
    Route::get('ancillarycensus', 'AncillaryreportController@ancillarycensus');
    Route::get('ancillaryreport', 'AncillaryreportController@ancillaryreport');
    Route::get('exportservicetopdf', 'AncillaryreportController@exportservicetopdf');
    Route::get('restoreservice/{id}', 'AncillaryController@restoreservice');



    Route::get('getpatientinfo/{id}', 'AncillaryController@getpatientinfo');
    Route::get('deleteserviceRequistion/{id}', 'AncillaryController@deleteserviceRequistion');
    Route::post('insertServiceRequest', 'AncillaryController@insertServiceRequest');
    Route::post('editServiceRequest', 'AncillaryController@editServiceRequest');
    Route::post('statusServiceRequistion', 'AncillaryController@statusServiceRequistion');
    Route::get('deletefreeservicerequisition/{id}', 'AncillaryController@deletefreeservicerequisition');
    Route::get('patientservicehistory/{id}', 'AncillaryController@patientservicehistory');
    Route::resource('ancillary', 'AncillaryController');


















    
/*-------- OPDMS ----*/

Route::group(['middleware' => 'auth'], function () {

    /* Start Receptions Route */


    /*-- Reception GLOBAL Routes --*/

    Route::post('patient_info_vs', 'OPDMS\PatientInfoController@patient_info_vs'); // patient information and vital signs GLOBAL
    Route::get('patient_name/{patient?}', 'OPDMS\PatientInfoController@patient_name'); // get full patient_name GLOBAL
// consultation directly been updated
    Route::post('write_nurse_notes_two', 'OPDMS\WriteNurseNotesController@write_nurse_notes_two'); // global

    Route::post('nurse_notes_save', 'OPDMS\WriteNurseNotesController@store'); // save nurse notes now | global
    Route::post('nurse_notes_update', 'OPDMS\WriteNurseNotesController@update'); // update nurse notes now | global

    Route::post('insert_vs', 'OPDMS\VitalSignsController@insert_vs'); // insert vs on active editor tinymce | global

// get all ultrasound records for displaying on medical records modal
    Route::post('ultrasound_records', 'OPDMS\UltrasoundRecordsController@ultrasound_records'); //global

// get all xray records for displaying on medical records modal
    Route::post('xray_records', 'OPDMS\XrayRecordsController@xray_records'); // global

// get all ecg records for displaying on medical records modal
    Route::post('ecg_records', 'OPDMS\ECGRecordsController@ecg_records'); // global
// get all ecg records for displaying on medical records modal
    Route::post('laboratory_records', 'OPDMS\LaboratoryRecordsController@laboratory_records'); // global
// get all pediatric records of this patient
    Route::post('pediatric_records', 'OPDMS\PediatricRecordsController@pediatric_records'); //global
// get all industrial form records of this patient
    Route::post('industrial_form_records', 'OPDMS\IndustrialFormRecordsController@industrial_form_records'); //global
// get the count of all medical records of this patient
    Route::post('medical_records_count', 'OPDMS\MedicalRecordsCountController@medical_records_count'); //global
// insert the vital signs of this patient
    Route::post('vital_signs_insert', 'OPDMS\VitalSignsController@store'); //global
// insert the vital signs of this patient
    Route::post('charging_records', 'OPDMS\ChargingRecordsController@charging_records'); //global
    Route::post('patient_notifications', 'OPDMS\PatientNotificationsController@notifications'); // patient notifications / global
// get the number of patient notification to be displayed on dashboard
    Route::post('notifications_popup', 'OPDMS\PatientNotificationsController@notifications_popup'); // patient notifications / global

// recode on patient notifications
    Route::post('get_all_notifications', 'OPDMS\PatientNotificationsController@get_all_notifications'); // global
// get all consultation records of this patient for showing on consultation modal
    Route::post('get_all_consultation_records', 'OPDMS\ConsultationRecordsController@get_all_consultation_records'); // global
// get all referral records of this patient for showing on medical records modal
    Route::post('get_all_referral_records', 'OPDMS\ReferralRecordsController@get_all_referral_records'); // global
// get all followup records of this patient for showing on medical records modal
    Route::post('get_all_followup_records', 'OPDMS\FollowupRecordsController@get_all_followup_records'); // global
// show the selected consultation
    Route::post('show_consultation', 'OPDMS\ConsultationRecordsController@show_consultation'); // global
// generate a password
    Route::get('generatePassword', 'OPDMS\UserAccountController@generatePassword'); // global
// change account information
    Route::resource('account', 'OPDMS\UserAccountController'); // global
// check if user auth has expired
    Route::post('auth_expired', 'OPDMS\AuthExpiredController@auth_expired');


    // adding services of clinics
    Route::get('services_offered/{status?}', 'OPDMS\ServicesController@services_offered');
    // store the services created
    Route::post('services_store', 'OPDMS\ServicesController@services_store');
    // edit services
    Route::get('service_edit', 'OPDMS\ServicesController@service_edit');

    // charging services
    Route::get('ancillary_services', 'OPDMS\ChargingController@ancillary_services');
    // get mss classification for charging
    Route::get('mss_classification', 'OPDMS\MSSClassificationController@mss_classification');
    // save charging request
    Route::post('charging_save', 'OPDMS\ChargingController@charging_save');
    // get all unpaid requests of this patient
    Route::post('unpaid_request', 'OPDMS\ChargingController@unpaid_request');
    // remove the selected unpaid request
    Route::post('unpaid_remove', 'OPDMS\ChargingController@unpaid_remove');
    // paid but undone items on charging
    Route::post('paid_but_undone', 'OPDMS\ChargingController@paid_but_undone');
    // make this request done
    Route::post('paid_done', 'OPDMS\ChargingController@paid_done');
    // donE all of the requests
    Route::post('done_all', 'OPDMS\ChargingController@done_all');
    // get all of the done requests
    Route::post('paid_and_done', 'OPDMS\ChargingController@paid_and_done');
    // get vital signs history
    Route::post('vs_history', 'OPDMS\VitalSignsController@vs_history'); // global
    // get referral history
    Route::post('referral_history', 'OPDMS\ReferralController@referral_history');
    // referral clinic doctor
    Route::post('referral_clinic_doctor', 'OPDMS\ReferralController@referral_clinic_doctor');
    // save referral of doctor
    Route::post('referral_save', 'OPDMS\ReferralController@referral_save');
    //delete referral
    Route::post('referral_delete', 'OPDMS\ReferralController@referral_delete');
    // get all ff history
    Route::post('followup_history', 'OPDMS\FollowupsController@followup_history');
    // followup save
    Route::post('followup_save', 'OPDMS\FollowupsController@followup_save');
    // delete followup
    Route::post('followup_delete', 'OPDMS\FollowupsController@followup_delete');

    // icd prime class
    Route::post('icd_primeclass', 'OPDMS\ICDCodesController@icd_primeclass');
    // icd subclass one
    Route::post('icd_subclass_one', 'OPDMS\ICDCodesController@icd_subclass_one');
    // icd subclass two get
    Route::post('icd_subclass_two', 'OPDMS\ICDCodesController@icd_subclass_two');
    // icd code master get selected
    Route::get('icd_codes_master', 'OPDMS\ICDCodesController@icd_codes_master');
    // get all categories
    Route::get('icd_codes_category_master', 'OPDMS\ICDCodesController@icd_codes_category_master');



    /* End Receptions Route */


});



                                            /*-- Reception NOT GLOBAL Routes --*/

Route::group(['middleware' => 'receptions'], function () {

    Route::get('patient_queue/{status?}', 'OPDMS\ReceptionController@patient_queue'); //patient queue status | not global
    Route::post('queued_action_buttons', 'OPDMS\ActionsController@queued_action_buttons'); // generate dashboard action buttons | not global
    Route::post('assign_to_doctor', 'OPDMS\AssignationController@assign_to_doctor'); // get all doctors for patient assignation | not global
    Route::post('assign_now', 'OPDMS\AssignationController@store'); // get all doctors for patient assignation | not global
    Route::post('remove_queued_patient', 'OPDMS\ReceptionController@remove_queued_patient'); // get full patient_name  | not global
    Route::post('re_assign_patient', 'OPDMS\ReAssignationController@re_assign_patient'); // get full patient_name | not global
    Route::post('re_assign_now', 'OPDMS\ReAssignationController@re_assign_now'); // get full patient_name | not global
    Route::get('doctors_queue', 'OPDMS\DoctorsQueueController@doctors_queue'); // redirect to doctors queue page | not global
    Route::get('status_filtering/{doctors_id?}/{status?}', 'OPDMS\DoctorsQueueController@status_filtering'); // status of patient on doctors | not global
    Route::get('search_queued_patients', 'OPDMS\SearchQueuedPatientController@search'); /* search today`s queued patients | not global*/
    Route::post('qrcode', 'OPDMS\QRCodeController@qrcode'); /* search today`s queued patients | not global*/
// check if nurse notes already written today show the selected consultation
    Route::post('write_nurse_notes', 'OPDMS\WriteNurseNotesController@write_nurse_notes'); // not global
// get all the queued history from a specific date and doctor | not global reception only
    Route::get('queued_history/{start?}/{end?}/{status?}/{doctor_id?}', 'OPDMS\QueuedHistoryController@queued_history')->name('que_history'); // not global
// submit queued history reception
    Route::post('queued_history', 'OPDMS\QueuedHistoryController@queue_history'); // not global reception only
// search patient
    Route::get('search_patient', 'OPDMS\SearchPatientController@search'); // not global reception only
// get all todays referrals for showing on notification panel
    Route::get('outgoing_referral', 'OPDMS\OutgoingReferralController@outgoing_referral'); // not global reception only
// show todays outgoing referrals
    Route::get('outgoing_referrals', 'OPDMS\OutgoingReferralController@outgoing_referrals'); // not global reception only
// show all incoming referrals
    Route::get('incoming_referral', 'OPDMS\IncomingReferralsController@incoming_referral');
// incoming referrals search
    Route::get('incoming_referrals', 'OPDMS\IncomingReferralsController@incoming_referrals');
// show all charged patients notifications
    Route::get('charged_notifications', 'OPDMS\ChargedPatientsController@charged_notifications');
// get all patients that has been charged
    Route::get('charged_patients', 'OPDMS\ChargedPatientsController@charged_patients');
// get all patients that has been schedule for followup
    Route::get('followup_notif', 'OPDMS\ScheduledFollowupController@followup_notif');
// get all patients that has been schedule for followup
    Route::get('followup_notifications', 'OPDMS\ScheduledFollowupController@followup_notifications');

});





/*--------------- Doctors Route ------------*/

// get all patients assigned to doctor
Route::get('queuing/{status?}', 'OPDMS\DoctorsQueuingController@queuing'); // not global
// search and get all patients on todays queue
Route::get('queuing_search', 'OPDMS\DoctorsQueuingController@queuing_search'); // not global
// get the assignation status of patient
Route::post('assignation_status', 'OPDMS\DoctorsQueuingController@assignation_status');
// create a consultation
Route::post('create_consultation', 'OPDMS\DoctorsConsultationController@create_consultation');
// save the consultation
Route::post('consultation_save', 'OPDMS\DoctorsConsultationController@consultation_save');
// end consultation of this patient
Route::post('end_consultation', 'OPDMS\DoctorsConsultationController@end_consultation');
// check or insert smoke cessation on consultation form
Route::post('smoking_cessation', 'OPDMS\SmokeCessationController@smoking_cessation');
// save smoking cessation on db
Route::post('save_smoking_cessation', 'OPDMS\SmokeCessationController@save_smoking_cessation');















// sample for doc villanueva request
//Route::get('docted', 'DoctorsController@doc');


/* End Receptions Route */

