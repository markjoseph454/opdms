<!--------------------------------- FileManager Upload ---------------------------->

<div id="fileupload" class="modal" role="dialog">
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Filemanager</h4>
            </div>
            <div class="modal-body">
                <div class="fileuploadWrapper bg-danger text-center">

                    <div id="uploadingLoader" class="loaderImageWrapper col-md-1">
                        <img src="<?php echo e(asset('public/images/loader.svg')); ?>" alt="loader" class="img-responsive" />
                        <p>Uploading...</p>
                    </div>
                    <div id="deleteLoader" class="loaderImageWrapper col-md-1">
                        <img src="<?php echo e(asset('public/images/loader.svg')); ?>" alt="loader" class="img-responsive" />
                        <p>Deleting..</p>
                    </div>

                    <h4>Upload Images or Documents</h4>
                    <br>
                    <div>
                        <label class="btn btn-default">
                            Select Files <input type="file" name="filemanager" class="filemanager" style="display: none" >
                        </label>
                    
                        <input type="hidden" class="editCID" name="editCID" value="<?php echo e((isset($editCID))? $editCID : '0'); ?>" />
                        
                    </div>
                    <br>
                    <p><small>Maximum upload file size 50 MB</small></p>
                </div>
                <br>
                <div class="uploadedFilesWrapper">
          

                    <?php if($fileAttachments): ?>
                        <?php $fileTypes = array('doc','docx','txt','xlsx','xls','pdf','ppt','pptx') ?>
                        <?php $__currentLoopData = $fileAttachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attchment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $random = random_int(000001, 600000);
                                $fileExt = explode('.', $attchment->filename);
                                if ($fileExt[1] == 'doc' || $fileExt[1] == 'docx') {
                                    $src = asset('public/images/mswordlogo.svg');
                                    $data_file = 'docx';
                                }elseif ($fileExt[1] == 'txt') {
                                    $src = asset('public/images/textlogo.svg');
                                    $data_file = 'txt';
                                }elseif ($fileExt[1] == 'xlsx' || $fileExt[1] == 'xls') {
                                    $src = asset('public/images/excellogo.svg');
                                    $data_file = 'xlsx';
                                }elseif ($fileExt[1] == 'pdf') {
                                    $src = asset('public/images/pdflogo.svg');
                                    $data_file = 'pdf';
                                }elseif ($fileExt[1] == 'ppt' || $fileExt[1] == 'pptx') {
                                    $src = asset('public/images/powerpointlogo.svg');
                                    $data_file = 'pptx';
                                }else{
                                    $src = "/PatientFiles/EVRMC-".$attchment->ptid.'-'.$attchment->last_name.'/'.$attchment->filename;
                                    $data_file = 'img';
                                }
                            ?>

                            <div class="<?php echo e($random); ?>">
                               <img src="<?php echo $src; ?>" class="img-responsive" 
                               data-path="PatientFiles/EVRMC-<?php echo e($attchment->ptid); ?>-<?php echo e($attchment->last_name); ?>/<?php echo e($attchment->filename); ?>"
                               data-file="<?php echo e($data_file); ?>" data-random="<?php echo e($random); ?>" onclick="showattachments($(this))" />
                               <input type="hidden" name="img[]" value="<?php echo e($attchment->filename); ?>" />
                               <input type="hidden" name="title[]" class="title <?php echo e($random); ?>" value="<?php echo e($attchment->description); ?>" />
                               <textarea hidden="" name="description[]" class="description <?php echo e($random); ?>"><?php echo e($attchment->description); ?></textarea>
                               <code hidden="" fn="<?php echo e($attchment->filename); ?>" ft="<?php echo e($data_file); ?>" fs="Unknown" 
                                up="<?php echo e(Carbon::parse($attchment->created_at)->toFormattedDateString()); ?>"></code>
                            </div>
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>






<!--------------------------------- FileManager Attachments ---------------------------->
<div id="attachments" class="modal" role="dialog">
    <div class="modal-dialog modal-xxl">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Attachment Details</h4>
            </div>
            <div class="modal-body">
                <div class="row attachmentsWrapper">

                    <div class="col-md-8 imgContainer">
                        <img src="" class="img-responsive center-block imagesuploaded" />
                    </div>

                    <div class="col-md-4 imgDetailsContainer">
                        <p><b>File name:</b><span class="filename"></span></p>
                        <p><b>File type:</b> <span class="filetype"></span></p>
                        <p><b>File size:</b> <span class="filesize"></span></p>
                        <p><b>Uploaded on:</b> <span class="uploadedDate"> December 1, 2017 </span></p>

                        <hr>
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" class="form-control showtitle" />
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea rows="5" class="form-control showdescription"></textarea>
                                </div>
                        <br>
                        <hr>

                        <a href="#" class="text-danger deletefile">Delete Permanently <i class="glyphicon glyphicon-trash"></i></a>
                        <a href="#" id="openAttachment" target="_blank" class="text-primary"> | Open Attachment <i class="fa fa-file-text-o"></i></a>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>