<div class="col-md-12">
    <br>
    <div class="row seletecItemsWrapper">
        <h5 class="text-center">
            <strong class="text-default">SELECTED ITEMS</strong>
            <span class="pull-right">MSS Classification <b class="classificationLabel"></b> ( <b class="classificationDisc"></b> )</span>
        </h5>
        <div class="table-responsive tableSelectedItems">
            <form action="<?php echo e(url('lab')); ?>" method="post" id="requisitionform">
                <?php echo e(csrf_field()); ?>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><i class="fa fa-question"></i></th>
                        <th>ITEM ID</th>
                        <th>ITEM DESCRIPTION</th>
                        <th>PRICE</th>
                        <th>QTY</th>
                        <th>AMOUNT</th>
                        <th>DISCOUNT</th>
                        <th>TOTAL</th>
                        <th>UNIT</th>
                    </tr>
                    </thead>

                    <tbody class="selectedItemsTbody">
                    <tr class="noSelectedTRwrapper">
                        <td colspan="9" class="text-center">
                            <strong class="text-danger">NO SELETECD ITEMS.</strong>
                        </td>
                    </tr>
                    </tbody>

                    <tfoot>
                    <tr>
                        <td colspan="9" align="right">
                            <h4>&#8369; <strong id="grndTotal"></strong> Grand Total</h4>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</div>


<div class="col-md-12 submitRequisition" align="right">
    <br>
    <button type="button" name="button" class="btn btn-default cancel">CANCEL</button>
    <button type="submit" name="button" form="requisitionform" class="btn btn-success">SAVE REQUISITION</button>
</div>