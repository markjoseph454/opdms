<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Pharmacy
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/reset.css')); ?>" rel="stylesheet" />
    <?php if(Auth::user()->theme == 2): ?>
        <link href="<?php echo e(asset('public/css/doctors/darkstyle.css')); ?>" rel="stylesheet" />
    <?php else: ?>
        <link href="<?php echo e(asset('public/css/doctors/greenstyle.css')); ?>" rel="stylesheet" />
    <?php endif; ?>
    <link href="<?php echo e(asset('public/css/pharmacy/overview.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/plugins/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" />

<?php $__env->stopSection(); ?>



<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('pharmacy.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('pharmacy/dashboard'); ?>
        <?php $__env->startSection('main-content'); ?>


            <div class="content-wrapper transaction">
                <br>
                </script>
                <div class="banner">
                    <h3 class="text-left"> 
                        <i class="fa fa-exchange"></i> TRANSACTION
                        <?php if(COUNT($pending) > 0): ?>
                        <div class="pull-right">
                            <small> PENDING <span class="fa fa-arrow-right"></span></small> 

                            <span class="badge badge-warning show-pending-request" data-toggle="tooltip" data-placement="top" title="UNMANAGED REQUISITION (click to view)" style="background-color: orange;cursor: pointer;"><b><?php echo e($pending[0]->request); ?></b></span> 

                            <span class="badge bg-info show-pending-manage" data-toggle="tooltip" data-placement="top" title="UNPAID MANAGED REQUISITION (click to view)" style="background-color: #00e600;cursor: pointer;"><b><?php echo e($pending[0]->managed); ?></b></span>

                            <span class="badge bg-info show-pending-done" data-toggle="tooltip" data-placement="top" title="UNDONE PAID REQUISITION (click to view)" style="background-color: red;cursor: pointer;"><b><?php echo e($pending[0]->pending_sales); ?></b></span>

                            <small>&nbsp;&nbsp;&nbsp; ISSUED <span class="fa fa-arrow-right"></span></small> 
                            <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="DONE REQUISITION (click to view)" style="background-color: rgb(51, 122, 183);cursor: pointer;"><b><?php echo e($pending[0]->done_sales); ?></b></span> 
                        </div>
                        <?php endif; ?>
                       
                    </h3>
                </div>
                <?php echo $__env->make('message.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="col-md-12 backtrack-form">
                         <form method="GET">
                        <div class="col-md-4 text-center" style="border: 1px solid #bdbdbd;padding: 5px;">
                            <div class="col-md-8">
                                <label style="margin-top: -20px;"> &nbsp;</label>
                                <input type="text" name="hospital_no" class="form-control hospital_no" minlength="6" maxlength="6" 
                                placeholder="HOSPITAL NO" <?php if(isset($_GET['hospital_no'])): ?> value="<?php echo e($_GET['hospital_no']); ?>" <?php endif; ?>  required>    
                            </div>
                            <div class="col-md-4" style="padding-left: 0px;">
                                <br>
                                <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-search"></span> SEARCH </button>
                            </div>
                        </div>
                        </form>
                        <form method="GET">
                        <div class="col-md-8" style="border: 1px solid #bdbdbd;padding: 5px;">
                            <div class="col-md-4 col-md-offset-1" style="padding-left: 0px;">
                                <label>FROM</label>
                                <div class="input-group">
                                    <input type="date" name="from" class="form-control from" <?php if(isset($_GET['to'])): ?> value="<?php echo e($_GET['from']); ?>" <?php endif; ?> required>
                                    <span class="input-group-addon fa fa-calendar"></span>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-left: 0px;">
                                <label>TO</label>
                                <div class="input-group">
                                    <input type="date" name="to" class="form-control to" <?php if(isset($_GET['to'])): ?> value="<?php echo e($_GET['to']); ?>" <?php endif; ?> required>
                                    <span class="input-group-addon fa fa-calendar"></span>
                                </div>
                            </div>
                            <div class="col-md-3" style="padding-left: 0px;">
                                <br>
                                <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-calendar"></span> FILTER DATE </button>
                            </div>
                        </div>
                        </form>
                </div>
               
                <div class="table table-responsive content-medicine">
                    <table class="table table-striped table-bordered" id="transaction">
                        <thead>
                            <tr>
                                <th hidden></th>
                                <th>CLASSIFICATION & OR#</th>
                                <th>HOSPITAL NO</th>
                                <th style="min-width: 150px;">NAME OF PATIENT</th>
                                <th align="center">REQUISITION</th>
                                <th align="center">MANAGED</th>
                                <th align="center">PAID</th>
                               
                            </tr>
                        </thead>
                        <tbody class="transaction-body">
                            <?php $__currentLoopData = $transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr id="<?php echo e($list->patients_id); ?>" discount="<?php echo e($list->discount); ?>">
                                <td hidden></td>
                                <?php if($list->label): ?>
                                    <?php if(is_numeric($list->description)): ?>
                                        <td align="center"><?php echo e($list->label.' - '.$list->description); ?>%</td>
                                    <?php else: ?>
                                        <td align="center"><?php echo e($list->label.' - '.$list->description); ?></td>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <td align="center" class="danger">NOT CLASSIFIED</td>
                                <?php endif; ?>
                               
                                
                                <td align="center"><?php echo e($list->hospital_no); ?></td>
                                <td><?php echo e($list->last_name.', '.$list->first_name.' '.substr($list->middle_name, 0,1).'.'); ?></td>
                                <td align="center"><?php echo e($list->requisition); ?></td>
                                <td align="center"><?php echo e($list->managed.' / '.$list->requisition); ?></td>
                                <td align="center"><?php echo e($list->paid.' / '.$list->requisition); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            
                            
                        </tbody>
                    </table>
                </div>
            </div> 


            <div id="usertransactionsmed-modal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">USERS TRANSACTION LIST</h4>
                       
                      </div>
                      <div class="modal-body">
                        <div class="text-right">
                            <a id="showallculomn">SHOW ALL COLUMN </a> <span class="fa fa-table"></span>
                            <br>
                        </div>
                        <div class="table-responsive usertransactions-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><span class="fa fa-check"></span></th>
                                        <th>BRAND</th>
                                        <th>GENERIC NAME</th>
                                        <th>PRICE</th>
                                        <th>STOCK</th>
                                        <th>REQUEST <br>QTY</th>
                                        <th>MANAGED <br>QTY</th>
                                        <th>AMOUNT</th>
                                        <th>DISCOUNT</th>
                                        <th>NET AMOUNT</th>
                                        <th>REQUESTED BY</th>
                                        <th>MANAGED BY</th>
                                        <th>DATETIME</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="usertransaction-tbody">
                                   
                                </tbody>
                            </table>
                        </div>
                        <div class="" style="margin-right: 50px;margin-top: -10px;">
                            <span style="background-color: yellow;color: black;padding: 3px;font-weight: bold;">&nbsp;REQUEST&nbsp;</span>
                            <span style="background-color: orange;color: white;padding: 3px;font-weight: bold;">&nbsp;MANAGED&nbsp;</span>
                            <span style="background-color: #3385ff;color: white;padding: 3px;font-weight: bold;">&nbsp;FOR ISSUANCE&nbsp;</span>
                            <span style="background-color: #00e600;color: black;padding: 3px;font-weight: bold;">&nbsp;ISSUED&nbsp;</span>
                        </div>
                        <div class="table-model" style="display: none;">
                            <form class="form-inline" onsubmit="return false" style="padding-bottom: 5px;">
                                <div class="input-group">
                                    <input type="text" name="" class="form-control" id="searchdescription" placeholder="Search By Description..." />
                                    <span class="input-group-addon fa fa-search"></span>
                                </div>
                                <div class="input-group">
                                    <input type="text" name="" class="form-control" id="searchbrand" placeholder="Search By Brand..." />
                                    <span class="input-group-addon fa fa-search"></span>
                                </div>
                                <small class="pull-right"> &nbsp; Showing <strong id="countResults"><?php echo e(count($medicines)); ?></strong> Results</small>
                            </form>
                            <table class="table table-bordered" style="margin-bottom: 0px;">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-info-circle"></i></th>
                                        <th>ITEM DESCRIPTION</th>
                                        <th>BRAND</th>
                                        <th>UNIT</th>
                                        <th>PRICE</th>
                                        <th>STOCKS</th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="table-responsive table-container">
                                <table class="table table-striped" id="medicinestable">
                                    
                                    <tbody class="selectitemsTbody">
                                        <?php if(count($medicines)): ?>
                                            <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" data-id="<?php echo e($list->id); ?>" class="check-item" style="margin-top: 0px;" />
                                                </td>
                                                <td class="item_description">
                                                    <?php echo e($list->item_description); ?>

                                                </td>
                                                <td class="item_brand">
                                                    <?php echo ($list->brand)? $list->brand : '<span class="text-danger">N/A</span>'; ?>

                                                </td>
                                                <td align="center" class="unitofmeasure">
                                                    <?php echo ($list->unitofmeasure)? $list->unitofmeasure : '<span class="text-danger">N/A</span>'; ?>

                                                </td>
                                                <td align="right" class="price">
                                                    <?php echo e(number_format($list->price, 2, '.', '')); ?>

                                                </td>
                                                <td align="center" class="stocks">
                                                    <?php echo e(($list->stock)); ?>

                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <strong class="text-danger">NO RESULTS FOUND.</strong>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div class="pull-left">
                            <button type="button" class="btn btn-default btn-sm" id="add-medicine" style="display: none;border: 1px solid black"><span class="fa fa-plus"></span> Add</button>
                            <button type="button" class="btn btn-default btn-sm" id="show-medicine"><span class="fa fa-eye" id="showhide"></span> Show Medicine</button>
                            <button type="button" class="btn btn-default btn-sm" id="print-medicine" target="_blank"><span class="fa fa-print"></span> Issuance slip</button>
                            
                        </div>
                      
                         <button type="button" class="btn btn-default btn-sm" id="save-medicine"><span class="fa fa-save"></span> Save</button>
                         <button type="button" class="btn btn-default btn-sm" id="update-medicine"><span class="fa fa-reorder"></span> Update</button>
                         <button type="button" class="btn btn-default btn-sm" id="delete-medicine"><span class="fa fa-mail-reply"></span> Cancel</button>
                         <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"> Close</button>
                      </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="postchargemodal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">LIST OF ISSUED MEDS</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 col-md-offset-5">
                                    <label class="pull-right">Choose what to display:</label>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control select-display">
                                        <option value="">Display</option>
                                        <option value="today">Today</option>
                                        <option value="all">All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive" id="postchargetable">
                                <table class="table table-striped">
                                    <thead>
                                        <tr style="background-color: #ccc">
                                            <th><input type="checkbox" name="" class="thcheck-print"></th>
                                            <th>BRAND</th>
                                            <th>GENIREC NAME</th>
                                            <th>PRICE</th>
                                            <th>QTY</th>
                                            <th class="text-center">DATE</th>
                                        </tr>
                                    </thead>
                                    <tbody class="postchargetbody">
                                       
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" id="print-postcharge"><span class="fa fa-print"></span> Print</button>
                        </div>
                    </div>
                  
                </div>
            </div>
              



            <?php echo $__env->make('pharmacy.pendingmodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php $__env->stopSection(); ?>
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/plugins/js/form.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/modernizr.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.menu-aim.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/pharmacy/main.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/pharmacy/overview.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/pharmacy/pending.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>
