<div class="col-md-12">
	<div class="table-responsive" id="dispensedmeds">
		<table class="table table-bordered">
			<tr>
				<th class="text-center" colspan="15">TOP 10 DISPENSED MEDICINES</th>
			</tr>
			<tr>
				<th class="text-center" style="padding: 2px;background-color: #e6e6e6" colspan="15"><i>OPD PHARMACY 2018</i></th>
			</tr>
			<tr class="bg-success">
				<th colspan="1" rowspan="2">GENERIC NAME</th>
				<th rowspan="2">TOTAL</th>
				<th colspan="12">Month</th>
			<tr class="bg-success">
				<th>January</th>
				<th>February</th>
				<th>March</th>
				<th>April</th>
				<th>May</th>
				<th>June</th>
				<th>July</th>
				<th>August</th>
				<th>September</th>
				<th>October</th>
				<th>November</th>
				<th>December</th>
			</tr>
			<?php
				$result = App\Sales::dispensedmeds($request->month, $request->year);
				$i=1;
			?>
			<?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr <?php if($i<=10): ?> class="bg-info" <?php endif; ?>>
					<td><?php if($i<=10): ?><span class="badge"> <?php echo e($i); ?> </span> <?php endif; ?> <?php echo e($list->item_description); ?> (<?php echo e($list->unitofmeasure); ?>)</td>
					<td align="center"><?php echo e($list->result); ?></td>
					<td align="center"><?php if($request->month=="1"): ?> <?php echo e($list->result); ?> <?php endif; ?></td>
					<td align="center"><?php if($request->month=="2"): ?> <?php echo e($list->result); ?> <?php endif; ?></td>
					<td align="center"><?php if($request->month=="3"): ?> <?php echo e($list->result); ?> <?php endif; ?></td>
					<td align="center"><?php if($request->month=="4"): ?> <?php echo e($list->result); ?> <?php endif; ?></td>
					<td align="center"><?php if($request->month=="5"): ?> <?php echo e($list->result); ?> <?php endif; ?></td>
					<td align="center"><?php if($request->month=="6"): ?> <?php echo e($list->result); ?> <?php endif; ?></td>
					<td align="center"><?php if($request->month=="7"): ?> <?php echo e($list->result); ?> <?php endif; ?></td>
					<td align="center"><?php if($request->month=="8"): ?> <?php echo e($list->result); ?> <?php endif; ?></td>
					<td align="center"><?php if($request->month=="9"): ?> <?php echo e($list->result); ?> <?php endif; ?></td>
					<td align="center"><?php if($request->month=="10"): ?> <?php echo e($list->result); ?> <?php endif; ?></td>
					<td align="center"><?php if($request->month=="11"): ?> <?php echo e($list->result); ?> <?php endif; ?></td>
					<td align="center"><?php if($request->month=="12"): ?> <?php echo e($list->result); ?> <?php endif; ?></td>
				</tr>
				<?php
				$i++;
				?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
		</table>
	</div>
	
</div>
