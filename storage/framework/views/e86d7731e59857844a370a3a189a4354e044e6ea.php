<?php $__env->startComponent('partials/header'); ?>



  <?php $__env->slot('title'); ?>
    OPD | classification
  <?php $__env->endSlot(); ?>



  <?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/mss/view.css')); ?>" rel="stylesheet" />
  <?php $__env->stopSection(); ?>



  <?php $__env->startSection('header'); ?>
    <?php echo $__env->make('mss/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php $__env->stopSection(); ?>



  <?php $__env->startSection('content'); ?>
  <div class="container mainWrapper">
  	<div class="panel" id="classification_panel">
  		<div class="panel-default">
  			<div class="panel-heading">
  				<h3>PATIENT CLASSIFICATION</h3>
  			</div>
  			<div class="panel-body table-responsive">
           <div class="col-sm-3 n nameofinterviewed" style="padding: 0px;margin-bottom: 5px;margin-top: -15px;">
               <p>NAME OF INTERVIEWEE: <?php echo e($view->interviewed); ?></p>
           </div>
  				<table class="table table-bordered PgovStatus" id="PgovStatus" style="margin-bottom: 0px;border-bottom: 0px;">
  					<tr style="text-align: center;">
  						<td width="25%" >DATE OF INTERVIEW: <br><?php echo e($view->created_at); ?></td>
  						<td width="25%">DATE OF ADMISSION/CONSULTATION:  <br> <?php echo e($view->date_admission); ?></td>
  						<td width="17%" align="center">WARD: <br> OPD</td>
  						<td width="17%">HOSP NO: <br> <?php echo e($view->hospital_no); ?></td>
  						<td width="16%">MSWD NO: <br> <?php echo e($view->mswd); ?></td>
  					</tr>
  					<tr>
  						<td colspan="2">SOURCE OF REFERRAL: <?php echo e($view->referral); ?></td>
  						<td colspan="2">ADDRESS: <?php echo e($view->referral_addrress); ?></td>
  						<td>TEL. NO: <?php echo e($view->referral_telno); ?></td>
  					</tr>
  					<tr>
  						<th colspan="5">&nbsp;I. DEMOGRAPHIC DATA: </th>

  					</tr>
  					<tr>
  						<td colspan="2">RELIGION: <?php echo e($view->religion); ?></td>
  						<td colspan="3">COMPANION UPON ADMISSION: <?php echo e($view->companion); ?></td>
  					</tr>
  					<tr align="center">
  						<td>PATIENTS NAME</td>
  						<td>AGE</td>
  						<td>SEX</td>
  						<td>GENDER</td>
  						<td>CIVIL STATUS</td>
  					</tr>
  					<tr align="center">
  						<td><?php echo e($view->last_name.', '.$view->first_name.' '.$view->middle_name); ?></td>
  						<td><?php echo e($view->age); ?></td>
                        <td><?php echo e(($view->sex == 'M')?"MALE":"FEMALE"); ?></td>
  						<td><?php echo e(($view->gender == 'M')?"MASCULANE":"FEMININE"); ?></td>
  						<td><?php echo e($view->civil_status); ?></td>
  					</tr>
  					<tr>
  						<td colspan="2" style="padding: 3px!important;">PERMANET ADDRESSS: <br><br><?php echo e($view->address); ?></td>
  						<td colspan="2" style="padding: 3px!important;">TEMPORARY ADDRESS: <br><br><?php echo e($view->temp_address); ?>

  						</td>
  						<td style="padding: 3px!important;text-align:center">DATE/PLACE OF BIRTH: <br><?php echo e($view->birthday); ?><br>
  						<?php echo e($view->pob); ?>

  						</td>
  					</tr>
  					<tr>
  						<td colspan="2">
  							<div class="col-sm-6" style="padding: 0px;">
  								&nbsp;KIND OF LIVING ARRANGEMENT: &nbsp;
  							</div>
  							<div class="col-sm-6" style="padding: 0px;">
                                    <?php if($view->living_arrangement == "O"): ?>
                                        <?php echo e("Owned"); ?>

                                    <?php elseif($view->living_arrangement == "R"): ?>
                                        <?php echo e("Rented"); ?>

                                    <?php elseif($view->living_arrangement == "S"): ?>
                                        <?php echo e("Shared"); ?>

                                    <?php elseif($view->living_arrangement == "I"): ?>
                                        <?php echo e("Institution"); ?>

                                    <?php elseif($view->living_arrangement == "H"): ?>
                                        <?php echo e("Homeless"); ?>

                                    <?php endif; ?>
                            </div>
  						</td>
  						<td colspan="3"></td>
  					</tr>
  					<tr>
  						<td colspan="2"><?php echo e($view->education); ?></td>
  						<td rowspan="2">EMPLOYER: <br><?php echo e($view->employer); ?></td>
  						<td rowspan="2">INCOME: <br><?php echo e($view->income); ?></td>
  						<td rowspan="2">PER CAPITA INCOME: <br><?php echo e($view->capita_income); ?></td>
  					</tr>
  					<tr>
  						<td colspan="2"><?php echo e($view->occupation); ?></td>
  					</tr>
  					<tr>
  						<td>PHILHEALTH: <?php echo e(($view->philhealth == 'M')?"MEMBER":"DEPENDENT"); ?></td>
  						<td align="center">CATEGORY</td>
  						<td align="center">4P's</td>
  						<td colspan="2" align="center">CLASSIFICATION </td>
  					</tr>
  					<tr>
  						<td>TYPE: <?php echo e($view->membership); ?></td>
  						<td align="center">
                            <?php if($view->category == "O"): ?>
                                <?php echo e("Old Pt"); ?>

                            <?php elseif($view->category == "N"): ?>
                                <?php echo e("New Pt"); ?>

                            <?php else: ?>
                                <?php echo e("Case Forward"); ?>

                            <?php endif; ?>
                        
                        </td>
  						<td align="center"><?php echo e($view->fourpis); ?></td>
  						<td  colspan="2" align="center">
  							<?php echo e($view->label."-".$view->description); ?>

  						</td>
  					</tr>
  					<tr>
  						<td colspan="2">SECTORIAL MEMBERSHIP: <?php echo e($view->sectorial); ?></td>
  						<td colspan="3"></td>
  					</tr>
  				</table>
  				<table class="table table-bordered" id="PgovStatus">
  					<tr align="center">
  						<td colspan="7">FAMILY COMPOSITION</td>
  					</tr>
  					<tr align="center">
  						<td width="30%">NAME</td>
  						<td width="10%">AGE</td>
  						<td>CIVIL STATUS</td>
  						<td>RELATION TO PATIENT</td>
  						<td>EDUC'L ATTAINMENT</td>
  						<td>OCCUPATION</td>
  						<td>MONTHLY INCOME</td>
  					</tr>
            <?php $count = 1; ?> 
            <?php $__currentLoopData = $family; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($count.". ".$list->name); ?></td>
                        <td><?php echo e($list->age); ?></td>
                        <td><?php echo e($list->status); ?></td>
                        <td><?php echo e($list->relationship); ?></td>
                        <td><?php echo e($list->feducation); ?></td>
                        <td><?php echo e($list->foccupation); ?></td>
                        <td><?php echo e($list->fincome); ?></td>
                    </tr>
            <?php $count++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php for($i = $count; $i<=8;$i++): ?>
  					<tr>
  						<td><?php echo e($i); ?></td>
  						<td></td>
  						<td></td>
  						<td></td>
  						<td></td>
  						<td></td>
  						<td></td>
  					</tr>
            <?php endfor; ?>

  					<tr>
  						<td colspan="3">OTHER SOURCES OF INCOME: <?php echo e($view->source_income); ?></td>
  						<td colspan="4">HOUSEHOLD SIZE: <?php echo e($view->household); ?></td>
  					</tr>
  					<tr>
  						<td colspan="3">MONHTLY EXPENSES: <?php echo e($view->monthly_expenses); ?></td>
  						<td colspan="4">TOTAL MONTHLY EXPENDITURES: <?php echo e($view->monthly_expenditures); ?></td>
  					</tr>
  					<tr>
  						<td>HOUSE AND LOT: <?php echo e($view->houselot); ?> </td>
  						<td colspan="2">LIGHT SOURCE: <?php echo e($view->light); ?> </td>
  						<td colspan="2">WATER SOURCE: <?php echo e($view->water); ?> </td>
  						<td colspan="2">FUEL SOURCE: <?php echo e($view->fuel); ?> </td>
  					</tr>
  					<tr>
  						<td>FOOD: Php <?php echo e($view->food); ?></td>
  						<td colspan="2">EDUCATION: Php <?php echo e($view->educationphp); ?> </td>
  						<td colspan="2">CLOTHING: Php <?php echo e($view->clothing); ?></td>
  						<td colspan="2">TRANSPORATION: Php <?php echo e($view->transportation); ?></td>
  					</tr>
  					<tr>
  						<td>HOUSE HELP: Php <?php echo e($view->house_help); ?></td>
  						<td colspan="2">MEDICAL EXPENDITURES: Php <?php echo e($view->expinditures); ?></td>
  						<td colspan="2">INSURANCE PREMIUM: Php <?php echo e($view->insurance); ?></td>
  						<td colspan="2">OTHERS: <?php echo e($view->other_expenses); ?></td>
  					</tr>
  					<tr>
  						<td colspan="3">INTERNET CONNECTION: Php <?php echo e($view->internet); ?></td>
  						<td colspan="4">CABLE: Php <?php echo e($view->cable); ?></td>
  					</tr>
  					<tr>
  						<th colspan="7">II. MEDICAL RECORD</th>
  					</tr>
  					<tr>
  						<td>MEDICAL DATA: <br><?php echo e($view->medical); ?></td>
  						<td colspan="3">ADMITTING DIAGNOSIS: <br> <?php echo e($view->admitting); ?></td>
  						<td colspan="3">FINAL DIAGNOSIS:    <br> <?php echo e($view->final); ?></td>
  					</tr>
  					<tr>
  						<td colspan="7">DURATION OF PROBLEM/ SYMPTOMS: <?php echo e($view->duration); ?></td>
  					</tr>
  					<tr>
  						<td colspan="7">PREVIOUS TREATMENT DURATION: <?php echo e($view->previus); ?> </td>
  					</tr>
  					<tr>
  						<td colspan="7">PRESENT TREATMENT PLAN: <?php echo e($view->present); ?></td>
  					</tr><tr>
  						<td colspan="7">HEALTH ACCESSIBILITY PROBLEM: <?php echo e($view->health); ?></td>
  					</tr>
  					<tr>
  						<td colspan="3">ASSESSMENT FINDINGS: <?php echo e($view->findings); ?></td>
  						<td colspan="4">RECOMMENDED INTERVENTIONS: <?php echo e($view->interventions); ?></td>
  					</tr>
  					<tr>
  						<td colspan="3">PRE-ADMISSION PLANNING: <?php echo e($view->admision); ?>

  						</td>
  						<td colspan="4">DISCHARGE PLANNING: <?php echo e($view->planning); ?></td>
  					</tr>
  					<tr>
  						<td colspan="7">COUNSELING: <?php echo e($view->counseling); ?></td>
  					</tr>
  				</table>
  			</div>
  		</div>
  	</div>
  </div>

  <?php $__env->stopSection(); ?>
<?php echo $__env->renderComponent(); ?>
