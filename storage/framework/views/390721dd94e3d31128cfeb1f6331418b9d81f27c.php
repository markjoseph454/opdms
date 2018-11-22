<li class="dropdown messages-menu qrcode_main_wrapper">
    <!-- Menu toggle button -->
    <a href="" class="dropdown-toggle"
       onclick="qrcode_open($(this))" title="QR Code / Hospital Number">
        <i class="fa fa-qrcode"></i>
        
    </a>
    <ul class="dropdown-menu">
        <li class="header text-center text-muted">
            <strong>Scan QR Code or Enter Hospital No.</strong>
        </li>
        <li class="qr_code_parent_list">
            <!-- Inner Menu: contains the notifications -->
            <ul class="menu">
                <li><!-- start notification -->
                    <form action="<?php echo e(url('qrcode')); ?>" method="post" onsubmit="full_loader()">
                        <?php echo e(csrf_field()); ?>

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





<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="<?php echo e(url('patient_queue')); ?>" title="Patients Queue" onclick="full_loader()">
        <i class="fa fa-user-circle"></i>
    </a>
</li>



<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="<?php echo e(url('doctors_queue')); ?>" title="Doctors Queue" onclick="full_loader()">
        <i class="fa fa-stethoscope"></i>
    </a>
</li>



<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="<?php echo e(url('queued_history')); ?>" title="Queuing History" onclick="full_loader()">
        <i class="fa fa-history"></i>
    </a>
</li>




<!-- todays follow-up -->
<li class="dropdown notifications-menu followup_notification">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Todays Follow-up">
        <i class="fa fa-refresh"></i>
        <?php if($followup_notification): ?>
            <span class="label bg-red"><?php echo e($followup_notification); ?></span>
        <?php endif; ?>
    </a>
    <ul class="dropdown-menu">
        <li class="header">Todays Follow-up</li>
        <li>
            <ul class="menu">
                <?php echo $__env->make('OPDMS.partials.loader_notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                <li class="list_notif followup_list_notification">
                    <!-- inner menu: contains the messages -->
                    
                </li>
            </ul>
        </li>
        <li class="footer">
            <a href='<?php echo e(url("followup_notifications?start=".Carbon::now()->format('Y-m-d')."&end=".Carbon::now()->format('Y-m-d')."&search=")); ?>'
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
        <?php if($outgoing_referrals): ?>
            <span class="label bg-red"><?php echo e($outgoing_referrals); ?></span>
        <?php endif; ?>
    </a>
    <ul class="dropdown-menu">
        <li class="header">Outgoing Referrals</li>
        <li>
            <ul class="menu">
                <?php echo $__env->make('OPDMS.partials.loader_notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                <li class="list_notif list_notification">
                    <!-- inner menu: contains the messages -->
                    
                </li>
            </ul>
        </li>
        <li class="footer">
            <a href='<?php echo e(url("outgoing_referrals?start=".Carbon::now()->format('Y-m-d')."&end=".Carbon::now()->format('Y-m-d')."&search=")); ?>'
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
        <?php if($incoming_referrals): ?>
            <span class="label bg-red"><?php echo e($incoming_referrals); ?></span>
        <?php endif; ?>
    </a>
    <ul class="dropdown-menu">
        <li class="header">Incoming Referrals</li>
        <li>
            <ul class="menu">
                <?php echo $__env->make('OPDMS.partials.loader_notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                <li class="list_notif list_notification_incoming_referrals">
                    <!-- inner menu: contains the messages -->
                    
                </li>
            </ul>
        </li>
        <li class="footer">
            <a href='<?php echo e(url("incoming_referrals?start=".Carbon::now()->format('Y-m-d')."&end=".Carbon::now()->format('Y-m-d')."&search=")); ?>'
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
        <?php if($charged_patients[0]->total): ?>
            <span class="label bg-red"><?php echo e($charged_patients[0]->total); ?></span>
        <?php endif; ?>
    </a>
    <ul class="dropdown-menu">
        <li class="header">Charged Patients</li>
        <li>
            <ul class="menu">
                <?php echo $__env->make('OPDMS.partials.loader_notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                <li class="list_notif charged_menu_list">
                    <!-- inner menu: contains the messages -->
                    
                </li>
            </ul>
        </li>
        <li class="footer">
            <a href='<?php echo e(url("charged_patients?start=".Carbon::now()->format('Y-m-d')."&end=".Carbon::now()->format('Y-m-d')."")); ?>'
               onclick="full_loader()">
                See all charged patients
            </a>
        </li>
    </ul>
</li>













