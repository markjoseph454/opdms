<div class="col-md-9 requsitionSelection">

    <div>
        <form class="form-inline" onsubmit="return false">
            <input type="text" name="" class="form-control" id="searchDesc" data-search="description" onkeyup="search($(this))" placeholder="Search By Description..." />
            <input type="text" name="" class="form-control" data-search="item" onkeyup="search($(this))" placeholder="Search By Item Id..." />
            <input type="text" name="" class="form-control" data-search="price" onkeyup="search($(this))" placeholder="Search By Price..." />
            <small class="text-right"> &nbsp; Showing <strong id="countResults">{{ count($medicines) }}</strong> Results</small>
        </form>
    </div>

    <br/>
    <div class="table-responsive tableWrapper">

        <div class="loaderWrapper">
            <img src="{{ asset('public/images/loader.svg') }}" alt="loader" class="img-responsive" />
            <p>Loading...</p>
        </div>

        <table class="table" id="itemsDeptTable">

            <thead class="theadRequistion">
                <tr>
                    <th><i class="fa fa-question"></i></th>
                    <th>ITEM ID</th>
                    <th>ITEM DESCRIPTION</th>
                    <th>BRAND</th>
                    <th>UNIT</th>
                    <th>PRICE</th>
                    <th>STOCKS</th>
                    <th>STATUS</th>
                </tr>
            </thead>

            <tbody class="selectitemsTbody">

            @if(count($medicines))
                @foreach($medicines as $medicine)
                    <tr class="{{ ($medicine->status == 'Y' && $medicine->stock)? 'bg-success' : 'bg-danger' }}">
                        <td>
                            <input type="checkbox" data-check="{{ $medicine->id.'M' }}" data-category="1031" data-id="{{ $medicine->id }}"
                                   name="" onclick="chooseItem($(this))" />
                        </td>
                        <td class="item_id">
                            {{ $medicine->item_id }}
                        </td>
                        <td class="item_description">
                            {{ $medicine->item_description }}
                        </td>
                        <td class="item_brand">
                            {!! ($medicine->brand)? $medicine->brand : '<span class="text-danger">N/A</span>' !!}
                        </td>
                        <td class="unitofmeasure">
                            {!! ($medicine->unitofmeasure)? $medicine->unitofmeasure : '<span class="text-danger">N/A</span>' !!}
                        </td>
                        <td class="price">
                            {{ $medicine->price }}
                        </td>
                        <td class="stocks">
                            {!! ($medicine->stock)? $medicine->stock : '<span class="text-danger">Out</span>' !!}
                        </td>
                        <td>
                            {!! ($medicine->status == 'Y' && $medicine->stock)?
                            '<span class="text-success">Available</span>' : '<span class="text-danger">Unavailable</span>' !!}
                        </td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <td colspan="5" class="text-center">
                        <strong class="text-danger">NO RESULTS FOUND.</strong>
                    </td>
                </tr>
            @endif
            </tbody>

        </table>


    </div>
</div>