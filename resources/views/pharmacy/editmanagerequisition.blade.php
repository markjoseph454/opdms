@component('partials/header')

    @slot('title')
        OPD | Pharmacy
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
     <link href="{{ asset('public/css/pharmacy/managerequest.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('pharmacy.navigation')
@stop



@section('content')
    @component('pharmacy/dashboard')
        @section('main-content')


            <div class="content-wrapper" style="margin-left: 150px;padding-right: 20px;">
                <div class="banner">
                    <h3 class="text-left"> <i class="fa fa-user-md"></i> MANAGE REQUEST</h3>
                </div>
                <div class="">
                    <br>
                </div>
                <div class="container-fluid">
                   
                    <div class="col-md-12 requsitionWrapper">
                        <div class="row">
                            <div class="col-md-3 departmentWrapper">
                                <table class="table table-condensed table-bordered">
                                    <tr>
                                        <th>PATIENT INFORMATION</th>
                                    </tr>
                                    <tr>
                                        <td><b>NAME: </b> {{ $patient->first_name.' '.$patient->middle_name.' '.$patient->last_name }}</td>
                                    </tr>
                                    <tr>
                                        @php
                                            $agePatient = App\Patient::age($patient->birthday)
                                        @endphp
                                        <td><b>AGE: </b> {{ $agePatient }}</td>
                                    </tr>
                                    <tr>
                                       @if(is_numeric($patient->description))
                                       <td><b>CLASSIFICATION: </b> {{ $patient->label.'-'.$patient->description }}%</td>
                                       @else
                                       <td><b>CLASSIFICATION: </b> {{ $patient->label.'-'.$patient->description }}</td>
                                       @endif
                                        
                                    </tr>
                                    <tr>
                                        <td><b>GENDER: </b> {{ ($patient->sex=='M')? 'MALE':'FEMALE' }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>ADDRESS: <br></b> {{ $patient->address }}</td>
                                        
                                    </tr>
                                </table>

                            </div>
                            <div class="col-md-9 requsitionSelection">
                                <form class="updatemanagerequest" method="post" action="{{ url('updatemanagerequest') }}">
                                    <div class="table-responsive">
                                       <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" name="" class="th-check"></th>
                                                <th>ITEM BRAND</th>
                                                <th>ITEM NAME</th>
                                                <th>PRICE</th>
                                                <th width="120px">PHARMACY <br> STOCK</th>
                                                <th>REQUESTED <br> QTY</th>
                                                <th width="120px">ISSUE <br> QTY</th>
                                                <th width="120px">ISSUANCE <br>CONTROL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            {{ csrf_field() }}
                                             @php
                                                $now = Carbon::now();
                                                $date = Carbon::parse($now)->format('Y-m-d');
                                            @endphp
                                            <input type="hidden" name="modifier" value="{{ $mgmtmod }}">
                                            @if(count($managed) > 0)
                                                @foreach($managed as $list)
                                                    @if($list->error || $list->rqty == $list->manage_qty || $list->status == 'N' || $list->expire_date <= $date)
                                                    <tr class="danger">
                                                        <td align="center">
                                                            <input type="checkbox" name="" class="" disabled></td>
                                                    @elseif($list->mgmtid)
                                                    <tr class="">
                                                        <td align="center">
                                                           
                                                            <input type="checkbox" name="" class="td-check" checked>
                                                        </td>
                                                    @else
                                                    <tr>
                                                        <td align="center">
                                                             <input type="checkbox" name="" class="td-check">
                                                        </td>
                                                    @endif
                                                        <td>{{ $list->brand }}
                                                            <input type="hidden" name="" value="{{ $list->mgmtid }}" class="item_id">
                                                            <input type="hidden" name="" value="{{ $list->reqid }}" class="req_id">
                                                        </td>
                                                        <td>{{ $list->item_description }}<input type="hidden" name="" value="{{ $list->anc_id }}" class="anc_id"></td>
                                                        <td align="right" class="price">{{ number_format($list->price, 2, '.', ',') }}</td>
                                                        <td class="info pharstock" align="center">
                                                            @if($list->error)
                                                            {{ $list->error }}
                                                            @elseif($list->status == 'N')
                                                            {{ "NOT AVAILABLE" }}
                                                            @elseif($list->expire_date <= $date)
                                                            {{ "EXPIRED" }}
                                                            @else
                                                            {{ $list->stock }}
                                                            @endif
                                                            
                                                        </td>
                                                        <td align="center" class="qtyt">{{ $list->rqty }}</td>
                                                        <td align="center">{{ $list->manage_qty }}</td>

                                                        <td>
                                                            @if($list->mgmtid && $list->status == 'Y' && $list->expire_date >= $date)
                                                            <input type="number" name="manage" class="form-control manage" value="@if($list->error){{0}}@elseif($list->mgmtqty){{$list->mgmtqty}}@else{{ '0' }}@endif" style="text-align: center;">
                                                            @else
                                                             <input type="number" name="manage" class="form-control manage" value="0" readonly style="cursor: not-allowed;text-align: center;">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                            <tr>
                                                <td colspan="7" class="danger" align="center" height="100px">NO REQUESITION FOUND</td>
                                            </tr>
                                            @endif
                                           
                                        </tbody>
                                           
                                            
                                           
                                       </table> 
                                    </div>
                                  
                                        <div class="col-md-12 manage-footer" align="right">
                                                <div class="tobesubmit">
                                                    <input type="" name="mss_id" value="{{ $patient->mss_id }}">
                                                    <div class="contents">
                                                    </div>
                                                </div>
                                            <button type="submit" class="btn btn-default submitbutton">SAVE</button>
                                            <button type="button" class="btn btn-default">CANCEL</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>               
            </div> 




            
            <!-- .content-wrapper -->

        @endsection
    @endcomponent
@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/pharmacy/main.js') }}"></script> 
     <script src="{{ asset('public/js/pharmacy/editmanagerequest.js') }}"></script>
   
@stop


@endcomponent
