<style>
    .cd-side-nav > ul > li.customer > a::before {
      font-family: FontAwesome;
      content: "\f007";
      font-size: 16px;
      color: #fff;
    }
    .cd-side-nav > ul > li.transaction > a::before {
      font-family: FontAwesome;
      content: "\f0ec";
      font-size: 16px;
      color: #fff;
    }
    .cd-side-nav > ul > li.medicine > a::before {
      font-family: FontAwesome;
      content: "\f0fa";
      font-size: 16px;
      color: #fff;
    }
    .cd-side-nav > ul > li.logs > a::before {
      font-family: FontAwesome;
      content: "\f02d";
      font-size: 16px;
      color: #fff;
    }
    .cd-side-nav > ul > li.reports > a::before {
      font-family: FontAwesome;
      content: "\f1c1";
      font-size: 16px;
      color: #fff;
    }
    .cd-side-nav > ul > li.cubes > a::before {
      font-family: FontAwesome;
      content: "\f1b3";
      font-size: 16px;
      color: #fff;
    }
    .formsfordate{
      padding: 10px!important;
    }
    .formsfordate label{
      color: #ffffff;
      font-size: 10px;
    }
    .formsfordate input{
      border-radius: 0px;
      height: 25px;
      font-size: 10px;
    }
</style>
<main class="cd-main-content">
    <nav class="cd-side-nav">
        <ul>
            <li class="cd-label">Main</li>
            <!-- <li class="has-children medicine <?php if(Request::is('manualinput')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('manualinput')); ?>">Requisition</a>
            </li> -->
           <!--  <li class="has-children customer <?php if(Request::is('patientrequest') || Request::is('managerequest')): ?> active <?php endif; ?>">
                <a href="#0">Customer</a> -->
                <!-- <span class="count">3</span> -->

              <!--   <ul>
                    <li><a href="<?php echo e(url('patientrequest')); ?>">Issue Request</a></li>
                    <li><a href="<?php echo e(url('managerequest')); ?>">Control Request</a></li>
                    <li><a href="<?php echo e(url('manualinput')); ?>">Direct Render</a></li>
                </ul>
            </li> -->
            <li class="has-children transaction <?php if(Request::is('phartransaction')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('phartransaction')); ?>">Transaction</a>
            </li>

            <li class="has-children medicine <?php if(Request::is('pharmacy')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('pharmacy?stats=all')); ?>">Medicine</a>
            </li>
            

        </ul>

        <ul>
            <li class="cd-label">Secondary</li>
            <li class="has-children logs <?php if(Request::is('logs')): ?> active <?php endif; ?>">
                <?php
                $now = Carbon::now();
                $date = Carbon::parse($now)->format('Y-m-d');
                ?>
                <a href="logs?from=<?php echo e($date); ?>&to=<?php echo e($date); ?>">Logs</a>

                
            </li>
            <li class="has-children cubes <?php if(Request::is('pharmacycencus')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('pharmacycencus')); ?>" target="_blank">Census</a>
            </li>
            <li class="has-children reports <?php if(Request::is('reports')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('reports')); ?>">Reports</a>
            </li>
            <!-- <li class="has-children reports">
                <a href="#0">Reports</a>

                <ul>
                    <li><a href="<?php echo e(url('issuance_C')); ?>">Issuance - CLASS C</a></li>
                    <li><a href="<?php echo e(url('issuance_D')); ?>">Issuance - CLASS D</a></li>
                    <li><a href="<?php echo e(url('issuance_DOH')); ?>">Issuance - DOH</a></li>
                    <li><a href="<?php echo e(url('inventory_R')); ?>">Inventory</a></li>
                    <li><a href="<?php echo e(url('consolidation_C')); ?>">Consolidation</a></li>
                    
                </ul>
            </li> -->

            <!-- <li class="has-children cubes <?php if(Request::is('inventory')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('inventory')); ?>">Consolidition</a>
            </li> -->
        </ul>

    </nav>

    <?php echo $__env->yieldContent('main-content'); ?>
    
</main> <!-- .cd-main-content -->
