<div class="modal" id="icd_codes_modal">

    <div class="modal-dialog modal-xxl">

        <?php echo $__env->make('OPDMS.partials.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

                <div class="row">
                    <div class="col-md-6">
                        <h4 class="modal-title text-primary text-uppercase">{{ p_name }}</h4>
                        <button class="btn btn-flat btn-default" v-on:click.prevent="patient_information">
                            <i class="fa fa-user-circle fa-lg text-blue"></i>
                            <span>Patient Information</span>
                        </button>
                    </div>
                    <div class="col-md-6">
                        <h4 class="modal-title text-orange">
                            International Classification of Diseases (ICD 10 Codes)
                        </h4>
                        <small class="text-muted">
                            You may browse the classification by using the hierarchy on the left or by using the search functionality
                        </small>
                    </div>
                </div>


            </div>

            <div class="modal-body">


                <div class="row">

                    <div class="col-md-3">
                        <?php echo $__env->make('OPDMS.partials.loader_notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <h5 class="text-blue text-bold inline">Chapters</h5>
                        <small v-if="icdPrimeclass.length" class="text-muted pull-right">
                            {{ icdPrimeclass.length }} results found
                        </small>
                        <input type="text" name="search" class="form-control mb5" placeholder="Search Code or Chapters..."
                               required v-model="searchPrimaryClass" autocomplete="off" />
                        <div class="icd_codes_min_height">
                            <table class="table table-bordered table-striped table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Chapter</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(icd, index) in search_primary_class" v-on:click="icd_subclass_one(icd.code)">
                                        <td>{{ icd.code }}</td>
                                        <td>{{ icd.description }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>




                    <div class="col-md-3 sub_class_one">
                        <?php echo $__env->make('OPDMS.partials.loader_notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <h5 class="text-blue text-bold inline">Blocks</h5>
                        <small v-if="icdSubclassOne.length" class="text-muted pull-right">
                            {{ icdSubclassOne.length }} results found
                        </small>
                        <input type="text" name="search" class="form-control mb5" placeholder="Search Code or Blocks..."
                               required v-model="searchSubClassOne" autocomplete="off" />
                        <div class="icd_codes_min_height">
                            <table class="table table-bordered table-striped table-hover table-condensed primaryClassTable">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Blocks</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(icd, index) in search_sub_class_one" v-on:click="icd_subclass_two(icd.code)">
                                        <td>{{ icd.code }}</td>
                                        <td>{{ icd.description }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>




                    <div class="col-md-3 sub_class_two">
                        <?php echo $__env->make('OPDMS.partials.loader_notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <h5 class="text-blue text-bold inline">Categories</h5>
                        <small v-if="icdSubclassTwo.length" class="text-muted pull-right">
                            {{ pagination_two.total }} results found
                        </small>

                        <form class="mb5" v-on:submit.prevent="icd_code_search_two">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search Code or Category..."
                                       required v-model="searchSubClassTwo" autocomplete="off" />
                                <span class="input-group-btn">
                                    <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <div class="icd_codes_min_height">
                            <table class="table table-bordered table-striped table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Categories</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(icd, index) in search_sub_class_two" v-on:click="icd_codes_master(icd.code)">
                                        <td>{{ icd.code }}</td>
                                        <td>{{ icd.description }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <nav class="text-center" aria-label="Page navigation" v-if="search_sub_class_two.length">
                            <ul class="pagination pagination-sm icd_paginate">
                                <li>
                                    <a href="" aria-label="Previous"
                                       v-on:click.prevent="changePageTwo(pagination.current_page - 1)"
                                       v-bind:class="previous_btn_two() ? 'active_link' : '' ">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li v-for="page in pages_two" v-bind:class="isCurrentPageTwo(page) ? 'active' : ''">
                                    <a href="" v-on:click.prevent="changePageTwo(page)">{{ page }}</a>
                                </li>
                                <li>
                                    <a href="" aria-label="Next"
                                       v-on:click.prevent="changePageTwo(pagination.current_page + 1)"
                                       v-bind:class="next_btn_two() ? 'active_link' : '' ">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                    </div>









                    <div class="col-md-3 icdCodesMaster">

                        <?php echo $__env->make('OPDMS.partials.loader_notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <h5 class="text-blue text-bold inline">Codes</h5>
                        <small v-if="icdCodes.length" class="text-muted pull-right">
                            {{ pagination.total }} results found
                        </small>

                        <form class="mb5" v-on:submit.prevent="icd_code_search">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search Code or Description..."
                                       required v-model="searchICDCodes" autocomplete="off" />
                                <span class="input-group-btn">
                                    <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <div class="icd_codes_min_height">
                            <table class="table table-bordered table-striped table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>
                                        <i class="fa fa-info"></i>
                                    </th>
                                    <th>Code</th>
                                    <th>Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(icd, index) in icd_codes_list">
                                        <td>
                                            <input type="checkbox" />
                                        </td>
                                        <td>{{ icd.code }}</td>
                                        <td>{{ icd.description }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <nav class="text-center" aria-label="Page navigation" v-if="icd_codes_list.length">
                            <ul class="pagination pagination-sm icd_paginate">
                                <li>
                                    <a href="" aria-label="Previous"
                                       v-on:click.prevent="changePage(pagination.current_page - 1)"
                                       v-bind:class="previous_btn() ? 'active_link' : '' ">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li v-for="page in pages" v-bind:class="isCurrentPage(page) ? 'active' : ''">
                                    <a href="" v-on:click.prevent="changePage(page)">{{ page }}</a>
                                </li>
                                <li>
                                    <a href="" aria-label="Next"
                                       v-on:click.prevent="changePage(pagination.current_page + 1)"
                                       v-bind:class="next_btn() ? 'active_link' : '' ">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                    </div>



                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal"
                        aria-label="Close">Close
                </button>
                <small class="text-muted">
                    In order to generate statistical data about the diseases acquired by the patients, it is highly <br>
                    important that you select ICD 10 Codes here and include it on the consultation form.
                </small>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>