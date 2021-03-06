<li class="dropdown messages-menu qrcode_main_wrapper">
    <!-- Menu toggle button -->
    <a href="" class="dropdown-toggle"
       onclick="qrcode_open($(this))" title="QR Code / Hospital Number">
        <i class="fa fa-qrcode"></i>
        <span class="hidden-xs">QR Code</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header text-center text-muted">
            <strong>Scan QR Code or Enter Hospital No.</strong>
        </li>
        <li class="qr_code_parent_list">
            <!-- Inner Menu: contains the notifications -->
            <ul class="menu">
                <li><!-- start notification -->
                    <form action="{{ url('qrcode') }}" method="post" onsubmit="full_loader()">
                        {{ csrf_field() }}
                        <input type="text" name="qrcode" class="form-control input-lg" required />
                    </form>
                </li>
                <!-- end notification -->
            </ul>
        </li>
        <li class="footer">
            <a href="#">
                <em>Include patient on the queuing list</em>
            </a>
        </li>
    </ul>
</li>
<!-- /.qr code-menu -->




{{-- patients queue --}}
<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="{{ url('patient_queue') }}" title="Patients Queue" onclick="full_loader()">
        <i class="fa fa-users"></i>
        <span class="hidden-xs">Patients</span>
    </a>
</li>


{{-- doctors queue --}}
<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="{{ url('doctors_queue') }}" title="Doctors Queue" onclick="full_loader()">
        <i class="fa fa-user-md"></i>
        <span class="hidden-xs">Doctors</span>
    </a>
</li>


{{-- queuing history --}}
<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="{{ url('queued_history') }}" title="Queuing History" onclick="full_loader()">
        <i class="fa fa-history"></i>
        <span class="hidden-xs">Queuing History</span>
    </a>
</li>


{{-- ancillary & services --}}
<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="{{ url('services_offered') }}" title="Ancillary items & Services offered" onclick="full_loader()">
        <i class="fa fa-stethoscope"></i>
        <span class="hidden-xs">Ancillary & Services</span>
    </a>
</li>




<!-- todays follow-up -->
<li class="dropdown notifications-menu followup_notification">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Todays Follow-up">
        <i class="fa fa-refresh"></i>
        @if($followup_notification)
            <span class="label bg-red">{{ $followup_notification }}</span>
        @endif
    </a>
    <ul class="dropdown-menu">
        <li class="header">Todays Follow-up</li>
        <li>
            <ul class="menu">
                @include('OPDMS.partials.loader_notification') {{-- loader icon --}}
                <li class="list_notif followup_list_notification">
                    <!-- inner menu: contains the messages -->
                    {{-- content goes here via ajax --}}
                </li>
            </ul>
        </li>
        <li class="footer">
            <a href='{{ url("followup_notifications?start=".Carbon::now()->format('Y-m-d')."&end=".Carbon::now()->format('Y-m-d')."&search=") }}'
               onclick="full_loader()">
                See all scheduled follow-up
            </a>
        </li>
    </ul>
</li>





<!-- todays outgoing referrals -->
<li class="dropdown notifications-menu todays_referral_li">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Outgoing Referrals">
        <i class="fa fa-arrow-up"></i>
        @if($outgoing_referrals)
            <span class="label bg-red">{{ $outgoing_referrals }}</span>
        @endif
    </a>
    <ul class="dropdown-menu">
        <li class="header">Outgoing Referrals</li>
        <li>
            <ul class="menu">
                @include('OPDMS.partials.loader_notification') {{-- loader icon --}}
                <li class="list_notif list_notification">
                    <!-- inner menu: contains the messages -->
                    {{-- content goes here via ajax --}}
                </li>
            </ul>
        </li>
        <li class="footer">
            <a href='{{ url("outgoing_referrals?start=".Carbon::now()->format('Y-m-d')."&end=".Carbon::now()->format('Y-m-d')."&search=") }}'
               onclick="full_loader()">
                See all outgoing referrals
            </a>
        </li>
    </ul>
</li>



<!-- todays incoming referrals -->
<li class="dropdown notifications-menu incoming_referrals_list">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Incoming Referrals">
        <i class="fa fa-arrow-down"></i>
        @if($incoming_referrals)
            <span class="label bg-red">{{ $incoming_referrals }}</span>
        @endif
    </a>
    <ul class="dropdown-menu">
        <li class="header">Incoming Referrals</li>
        <li>
            <ul class="menu">
                @include('OPDMS.partials.loader_notification') {{-- loader icon --}}
                <li class="list_notif list_notification_incoming_referrals">
                    <!-- inner menu: contains the messages -->
                    {{-- content goes here via ajax --}}
                </li>
            </ul>
        </li>
        <li class="footer">
            <a href='{{ url("incoming_referrals?start=".Carbon::now()->format('Y-m-d')."&end=".Carbon::now()->format('Y-m-d')."&search=") }}'
               onclick="full_loader()">
                See all incoming referrals
            </a>
        </li>
    </ul>
</li>






<!-- charging notifications -->
<li class="dropdown notifications-menu charging_notification">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Charged Patients">
        <i class="fa fa-database"></i>
        @if($charged_patients[0]->total)
            <span class="label bg-red">{{ $charged_patients[0]->total }}</span>
        @endif
    </a>
    <ul class="dropdown-menu">
        <li class="header">Charged Patients</li>
        <li>
            <ul class="menu">
                @include('OPDMS.partials.loader_notification') {{-- loader icon --}}
                <li class="list_notif charged_menu_list">
                    <!-- inner menu: contains the messages -->
                    {{-- content goes here via ajax --}}
                </li>
            </ul>
        </li>
        <li class="footer">
            <a href='{{ url("charged_patients?start=".Carbon::now()->format('Y-m-d')."&end=".Carbon::now()->format('Y-m-d')."") }}'
               onclick="full_loader()">
                See all charged patients
            </a>
        </li>
    </ul>
</li>













