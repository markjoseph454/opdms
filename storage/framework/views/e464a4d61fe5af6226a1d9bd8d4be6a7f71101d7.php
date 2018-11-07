<div id="phicAnnexModal" class="modal" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center hidden-xs">PHIC Annex 2</h4>
            </div>
            <div class="modal-body">
                <div class="icdWrapper row">
                    <div class="row">
                        <div class="col-md-8">
                                <input type="text" onkeyup="filter_result($(this), 'phic_table')" name="search" id="search" class="form-control"
                                       placeholder="Search RVS Code or Description...">
                        </div>
                    </div>
                    <br>
                    <div class="">
                        <div class="loaderWrapper">
                            <img src="<?php echo e(asset('public/images/loader.svg')); ?>" alt="Loader" class="img-responsive center-block" />
                            <p>Loading...</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped phic_table table-bordered" id="tableICD">
                                <thead>
                                <tr>
                                    <th><i class="fa fa-question"></i></th>
                                    <th>RVS Code</th>
                                    <th>Description</th>
                                </tr>
                                </thead>
                                <tbody id="phicTbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" class="close" data-dismiss="modal">OK <i class="fa fa-check"></i></button>
            </div>
        </div>

    </div>
</div>
