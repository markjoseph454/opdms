<form action="<?php echo e(url('search_patient')); ?>" method="post" class="sidebar-form whiteSearchBar">
    <?php echo e(csrf_field()); ?>

    <div class="input-group">
        <input type="hidden" name="redirector" value="<?php echo e($redirector); ?>"/>
        <input type="text" name="search" class="form-control" placeholder="Search Patient...">
          <span class="input-group-btn">
              <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
    </div>
</form>