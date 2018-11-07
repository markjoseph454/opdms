<?php $__env->startComponent('OPDMS.partials.header'); ?>


    <?php $__env->slot('title'); ?>
        Highest Cases Census
    <?php $__env->endSlot(); ?>


<?php $__env->startSection('pagestyle'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_queue.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/partials/patient_information.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/patient_assignation.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/OPDMS/css/reception/notification.css')); ?>" />
<?php $__env->stopSection(); ?>




<?php $__env->startSection('vue-container-start'); ?>
    <div id="vue-queue">
<?php $__env->stopSection(); ?>





    <?php $__env->startSection('navigation'); ?>
        <?php echo $__env->make('OPDMS.partials.boilerplate.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>


    <?php $__env->startSection('dashboard'); ?>
        <?php $__env->startComponent('OPDMS.partials.boilerplate.dashboard'); ?>
    <?php $__env->startSection('search_form'); ?>
        <?php echo $__env->make('OPDMS.reception.partials.search_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>
    <?php echo $__env->renderComponent(); ?>
    <?php $__env->stopSection(); ?>



    <?php $__env->startSection('content'); ?>



        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            <?php echo $__env->make('OPDMS.partials.boilerplate.header',
            ['header' => 'Highest Cases Census', 'sub' => 'Showing all the highest cases per demographic area.'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger">



                        <?php echo $__env->make('OPDMS.reception.reports.highest_case_search_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



                        <div class="box-body">


                            <?php if($starting && $ending): ?>


                                <?php
                                    $clinic = App\Clinic::find(Auth::user()->clinic);
                                    $clinicName = $clinic->name;
                                    $grandTotal = 0;
                                    $monthTotal = array();
                                ?>

                                <div class="table-responsive" id="highestCasesTable">
                                    <table class="table table-bordered">

                                        <tr>
                                            <td class="text-center">
                                                <?php echo e(strtoupper($clinicName)); ?>

                                            </td>
                                            <?php
                                                $colSpan = ((Carbon::parse($ending)->month + 1) - Carbon::parse($starting)->month) * 3;
                                            ?>
                                            <td colspan="<?php echo e($colSpan); ?>" class="text-center">MONTH</td>
                                            <td rowspan="3">
                                                TOTAL PER AREA <br>
                                                <small>(No. of Consultations)</small>
                                            </td>
                                            <td rowspan="3">
                                                TOTAL PER AREA <br>
                                                <small>(Referrals From)</small>
                                            </td>
                                            <td rowspan="3">
                                                TOTAL PER AREA <br>
                                                <small>(Referrals To)</small>
                                            </td>
                                        </tr>




                                        <tr>
                                            <td rowspan="2">
                                                NAME OF PROVINCES / AREAS CASES
                                            </td>

                                            <?php for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++): ?>
                                                <td colspan="3" class="text-center bg-info">
                                                    <?php echo e(Carbon::parse("2018-$i-01")->format('F')); ?>

                                                </td>
                                                <?php
                                                    $monthTotal['m'.$i] = 0;
                                                ?>
                                            <?php endfor; ?>
                                        </tr>




                                        <tr>
                                            <?php for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++): ?>
                                                <td>No. of Consultations</td>
                                                <td>Referrals (FROM)</td>
                                                <td>Referrals (TO)</td>
                                            <?php endfor; ?>
                                        </tr>




                                        

                                        <?php $__currentLoopData = $leyte; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <tr class="bg-success leyte">
                                                <?php
                                                switch ($row->district){
                                                    case 1:
                                                        $distrito = '1st';
                                                        break;
                                                    case 2:
                                                        $distrito = '2nd';
                                                        break;
                                                    case 3:
                                                        $distrito = '3rd';
                                                        break;
                                                    case 4:
                                                        $distrito = '4th';
                                                        break;
                                                    default:
                                                        $distrito = '5th';
                                                        break;
                                                }
                                                ?>
                                                <td>
                                                    <strong><?php echo e(($loop->first)? $row->citymunDesc : $row->provDesc.' '.$distrito.' District'); ?></strong>
                                                </td>
                                                <?php for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 2; $i++): ?>
                                                    <td <?php echo 'id="m'.$i.$row->citymunCode.'"'; ?>></td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                <?php endfor; ?>
                                            </tr>




                                            <tr class="leyte">
                                                <?php
                                                    $totalPerRow = 0;
                                                    $sumPerColumn = array();
                                                ?>
                                                <?php for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++): ?>
                                                    <?php
                                                        $year = Carbon::parse($starting)->year;
                                                        $date = Carbon::create($year, $i)->format('Y-m');
                                                        $tacloban = App\Radiology::highestCases($date, $row->citymunCode, $row->provCode, $row->district, $row->regCode);
                                                        if ($tacloban){
                                                            $cid = $tacloban[0]->cid;
                                                            (array_key_exists('m'.$i, $monthTotal)) ? $monthTotal['m'.$i] += $tacloban[0]->highest : $monthTotal['m'.$i] = $tacloban[0]->highest;
                                                        }
                                                    ?>
                                                    <?php if($i == Carbon::parse($starting)->month): ?>
                                                        <td style="padding-left: 40px">
                                                            Highest Case:
                                                            <strong><?php echo e(isset($tacloban[0]->subcategory) ? $tacloban[0]->subcategory : ''); ?></strong>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td><?php echo e(isset($tacloban[0]->highest) ? $tacloban[0]->highest : 0); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <?php
                                                        $totalPerRow += ($tacloban)? $tacloban[0]->highest : 0;
                                                        $sumPerColumn['s'.$i] = ($tacloban)? $tacloban[0]->highest : 0;
                                                    ?>
                                                <?php endfor; ?>
                                                <td><?php echo e($totalPerRow); ?></td>
                                                <td></td>
                                                <td></td>
                                                <?php
                                                    $grandTotal += $totalPerRow;
                                                ?>
                                            </tr>


                                            <tr class="leyte">
                                                <?php
                                                    $totalPerOthersRow = 0;
                                                ?>
                                                <?php for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++): ?>
                                                    <?php if($tacloban): ?>
                                                        <?php
                                                            $year = Carbon::parse($starting)->year;
                                                            $date = Carbon::create($year, $i)->format('Y-m');
                                                            $taclobanOther = App\Radiology::otherCases($date, $row->citymunCode, $cid, $row->provCode, $row->district, $row->regCode);
                                                        ?>
                                                    <?php endif; ?>
                                                    <?php if($i == Carbon::parse($starting)->month): ?>
                                                        <td style="padding-left: 40px">
                                                            <?php echo e($clinicName); ?> Total Cases:
                                                        </td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <?php if($tacloban): ?>
                                                            <?php echo e(isset($taclobanOther[0]->others) ? $taclobanOther[0]->others : 0); ?>

                                                            <?php
                                                                $totalPerOthersRow += $taclobanOther[0]->others;
                                                                $sumPerColumn['s'.$i] += $taclobanOther[0]->others;
                                                                (array_key_exists('m'.$i, $monthTotal))? $monthTotal['m'.$i] += $taclobanOther[0]->others : $monthTotal['m'.$i] = 0;
                                                            ?>
                                                        <?php else: ?>
                                                            0
                                                        <?php endif; ?>
                                                    </td>
                                                    <td></td>
                                                    <td></td>


                                                    <script>
                                                        document.getElementById("m<?php echo e($i.$row->citymunCode); ?>").innerText <?php echo e("=".$sumPerColumn['s'.$i]); ?>;
                                                    </script>

                                                <?php endfor; ?>
                                                <td><?php echo e($totalPerOthersRow); ?></td>
                                                <td></td>
                                                <td></td>
                                                <?php
                                                    $grandTotal += $totalPerOthersRow;
                                                ?>
                                            </tr>




                                            <script>
                                                document.getElementById("m<?php echo e((Carbon::parse($ending)->month + 1).$row->citymunCode); ?>").innerText <?php echo e("=" . ($totalPerRow + $totalPerOthersRow)); ?>;
                                            </script>



                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                        









                                        

                                        <?php $__currentLoopData = $samar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php
                                            switch ($row->district){
                                                case 1:
                                                    $distrito = '1st';
                                                    break;
                                                default:
                                                    $distrito = '2nd';
                                                    break;
                                            }

                                            switch ($row->provCode){
                                                case '0826':
                                                    $province = 'esamar';
                                                    break;
                                                case '0848':
                                                    $province = 'nsamar';
                                                    break;
                                                case '0860':
                                                    $province = 'wsamar';
                                                    break;
                                                case '0864':
                                                    $province = 'sleyte';
                                                    break;
                                                default:
                                                    $province = 'biliran';
                                                    break;
                                            }

                                            ?>
                                            <tr class="bg-success <?php echo e($province); ?>">
                                                <td>
                                                    <strong><?php echo e(($loop->first && $row->citymunCode == '083747')? $row->citymunDesc : $row->provDesc.' '.$distrito.' District'); ?></strong>
                                                </td>
                                                <?php for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 2; $i++): ?>
                                                    <td <?php echo 'id="m'.$i.$row->citymunCode.'"'; ?>></td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                <?php endfor; ?>
                                            </tr>

                                            <tr class="<?php echo e($province); ?>">
                                                <?php
                                                    $totalPerRow = 0;
                                                    $sumPerColumn = array();
                                                ?>
                                                <?php for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++): ?>
                                                    <?php
                                                        $year = Carbon::parse($starting)->year;
                                                        $date = Carbon::create($year, $i)->format('Y-m');
                                                        $tacloban = App\Radiology::highestCases($date, $row->citymunCode, $row->provCode, $row->district, $row->regCode);
                                                        if ($tacloban){
                                                            $cid = $tacloban[0]->cid;
                                                            (array_key_exists('m'.$i, $monthTotal))? $monthTotal['m'.$i] += $tacloban[0]->highest : $monthTotal['m'.$i] = 0;
                                                        }
                                                    ?>
                                                    <?php if($i == Carbon::parse($starting)->month): ?>
                                                        <td style="padding-left: 40px">
                                                            Highest Case:
                                                            <strong><?php echo e(isset($tacloban[0]->subcategory) ? $tacloban[0]->subcategory : ''); ?></strong>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td><?php echo e(isset($tacloban[0]->highest) ? $tacloban[0]->highest : 0); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <?php
                                                        $totalPerRow += ($tacloban)? $tacloban[0]->highest : 0;
                                                        $sumPerColumn['s'.$i] = ($tacloban)? $tacloban[0]->highest : 0;
                                                    ?>
                                                <?php endfor; ?>
                                                <td><?php echo e($totalPerRow); ?></td>
                                                <td></td>
                                                <td></td>
                                                <?php
                                                    $grandTotal += $totalPerRow;
                                                ?>
                                            </tr>

                                            <tr class="<?php echo e($province); ?>">
                                                <?php $totalPerOthersRow = 0; ?>
                                                <?php for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++): ?>
                                                    <?php if($tacloban): ?>
                                                        <?php
                                                            $year = Carbon::parse($starting)->year;
                                                            $date = Carbon::create($year, $i)->format('Y-m');
                                                            $taclobanOther = App\Radiology::otherCases($date, '083747', $cid, $row->provCode, $row->district, $row->regCode);
                                                        ?>
                                                    <?php endif; ?>
                                                    <?php if($i == Carbon::parse($starting)->month): ?>
                                                        <td style="padding-left: 40px">
                                                            <?php echo e($clinicName); ?> Total Cases:
                                                        </td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <?php if($tacloban): ?>
                                                            <?php echo e(isset($taclobanOther[0]->others) ? $taclobanOther[0]->others : 0); ?>

                                                            <?php
                                                                $totalPerOthersRow += $taclobanOther[0]->others;
                                                                $sumPerColumn['s'.$i] += $taclobanOther[0]->others;
                                                                (array_key_exists('m'.$i, $monthTotal))? $monthTotal['m'.$i] += $taclobanOther[0]->others : $monthTotal['m'.$i] = 0;
                                                            ?>
                                                        <?php else: ?>
                                                            0
                                                        <?php endif; ?>
                                                    </td>
                                                    <td></td>
                                                    <td></td>


                                                    <script>
                                                        document.getElementById("m<?php echo e($i.$row->citymunCode); ?>").innerText <?php echo e("=".$sumPerColumn['s'.$i]); ?>;
                                                    </script>


                                                <?php endfor; ?>
                                                <td><?php echo e($totalPerOthersRow); ?></td>
                                                <td></td>
                                                <td></td>
                                                <?php
                                                    $grandTotal += $totalPerOthersRow;
                                                ?>
                                            </tr>



                                            <script>
                                                document.getElementById("m<?php echo e((Carbon::parse($ending)->month + 1).$row->citymunCode); ?>").innerText <?php echo e("=" . ($totalPerRow + $totalPerOthersRow)); ?>;
                                            </script>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                        












                                        

                                        <tr class="bg-success outside">
                                            <td>
                                                <strong>Outside Region 8</strong>
                                            </td>
                                            <?php for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 2; $i++): ?>
                                                <td <?php echo 'id="m'.$i.'"'; ?>></td>
                                                <td>0</td>
                                                <td>0</td>
                                            <?php endfor; ?>
                                        </tr>

                                        <tr class="outside">
                                            <?php
                                                $totalPerRow = 0;
                                                $sumPerColumn = array();
                                            ?>
                                            <?php for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++): ?>
                                                <?php
                                                    $year = Carbon::parse($starting)->year;
                                                    $date = Carbon::create($year, $i)->format('Y-m');
                                                    $tacloban = App\Radiology::highestCases($date, false, false, false, 'outside');
                                                    if (!empty($tacloban)){
                                                        $cid = $tacloban[0]->cid;
                                                        (array_key_exists('m'.$i, $monthTotal))? $monthTotal['m'.$i] += $tacloban[0]->highest : $monthTotal['m'.$i] = 0;
                                                    }
                                                ?>
                                                <?php if($i == Carbon::parse($starting)->month): ?>
                                                    <td style="padding-left: 40px">
                                                        Highest Case:
                                                        <strong><?php echo e(($tacloban)? $tacloban[0]->subcategory : ''); ?></strong>
                                                    </td>
                                                <?php endif; ?>
                                                <td><?php echo e(isset($tacloban[0]->highest) ? $tacloban[0]->highest : 0); ?></td>
                                                <td></td>
                                                <td></td>
                                                <?php
                                                    $totalPerRow += ($tacloban)? $tacloban[0]->highest : 0;
                                                    $sumPerColumn['s'.$i] = ($tacloban)? $tacloban[0]->highest : 0;
                                                ?>
                                            <?php endfor; ?>
                                            <td><?php echo e($totalPerRow); ?></td>
                                            <td></td>
                                            <td></td>
                                            <?php
                                                $grandTotal += $totalPerRow;
                                            ?>
                                        </tr>

                                        <tr class="outside">
                                            <?php $totalPerOthersRow = 0; ?>
                                            <?php for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++): ?>
                                                <?php if($tacloban): ?>
                                                    <?php
                                                        $year = Carbon::parse($starting)->year;
                                                        $date = Carbon::create($year, $i)->format('Y-m');
                                                        $taclobanOther = App\Radiology::otherCases($date, false, $cid, false, false, 'outside');
                                                    ?>
                                                <?php endif; ?>
                                                <?php if($i == Carbon::parse($starting)->month): ?>
                                                    <td style="padding-left: 40px">
                                                        <?php echo e($clinicName); ?> Total Cases:
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <?php if($tacloban): ?>
                                                        <?php echo e(($taclobanOther)? $taclobanOther[0]->others : 0); ?>

                                                        <?php
                                                            $totalPerOthersRow += $taclobanOther[0]->others;
                                                            $sumPerColumn['s'.$i] += $taclobanOther[0]->others;
                                                            (array_key_exists('m'.$i, $monthTotal))? $monthTotal['m'.$i] += $taclobanOther[0]->others : $monthTotal['m'.$i] = 0;
                                                        ?>
                                                    <?php else: ?>
                                                        0
                                                    <?php endif; ?>
                                                </td>
                                                <td></td>
                                                <td></td>


                                                <script>
                                                    document.getElementById("m<?php echo e($i); ?>").innerText <?php echo e("=".$sumPerColumn['s'.$i]); ?>;
                                                </script>


                                            <?php endfor; ?>
                                            <td><?php echo e($totalPerOthersRow); ?></td>
                                            <td></td>
                                            <td></td>
                                            <?php
                                                $grandTotal += $totalPerOthersRow;
                                            ?>
                                        </tr>


                                        <script>
                                            document.getElementById("m<?php echo e((Carbon::parse($ending)->month + 1)); ?>").innerText <?php echo e("=" . ($totalPerRow + $totalPerOthersRow)); ?>;
                                        </script>


                                        




                                        <tr>
                                            <td>Total</td>
                                            <?php for($i= Carbon::parse($starting)->month; $i < Carbon::parse($ending)->month + 1; $i++): ?>
                                                <td><?php echo e($monthTotal['m'.$i]); ?></td>
                                                <td></td>
                                                <td></td>
                                            <?php endfor; ?>
                                            <td class="total"><?php echo e($grandTotal); ?></td>
                                            <td></td>
                                            <td></td>
                                        </tr>



                                    </table>
                                </div>


                            <?php else: ?>

                                <hr>
                                <h4 class="text-center text-danger">
                                    Please select a date to be retrieve <i class="fa fa-calendar"></i>
                                </h4>

                            <?php endif; ?>



                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Showing all the highest cases per demographic area.
                                </em>
                            </small>
                        </div>

                    </div>



                </section>
                <!-- /.content -->

            </div>
            <!-- /.content-wrapper -->
        <?php $__env->stopSection(); ?>



        <?php $__env->startSection('footer'); ?>
            <?php echo $__env->make('OPDMS.partials.boilerplate.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php $__env->stopSection(); ?>



        <?php $__env->startSection('aside'); ?>
            <?php echo $__env->make('OPDMS.partials.boilerplate.aside', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php $__env->stopSection(); ?>



        
<?php $__env->startSection('vue-container-end'); ?>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('pluginscript'); ?>
    <script src="<?php echo e(asset('public/plugins/js/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/preventDelete.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('pagescript'); ?>
    <script src="<?php echo e(asset('public/OPDMS/vue/reception/queue.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/reception/notification.js')); ?>"></script>
    <script src="<?php echo e(asset('public/OPDMS/js/partials/texteditor.js')); ?>"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>