@include('OPDMS.reception.modals.patient_assignation') {{-- patient assignation --}}
@include('OPDMS.reception.modals.patient_re_assignation') {{-- patient re_assignation --}}
@include('OPDMS.partials.modals.medical_records') {{-- medical records --}}
@include('OPDMS.partials.modals.consultation_show') {{-- consultation show records --}}

{{--@include('OPDMS.partials.modals.notifications')--}}{{-- notification status goes here --}}

@include('OPDMS.partials.modals.consultation_all'){{-- show all consultations of this patient goes here --}}

@include('OPDMS.partials.modals.nurse_notes') {{-- nurse notes --}}

@include('OPDMS.partials.modals.patient_notifications'){{-- notification status goes here --}}
@include('OPDMS.partials.modals.patient_information') {{-- patient information --}}
@include('OPDMS.partials.modals.vital_signs_form') {{-- nurse notes --}}