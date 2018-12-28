@component('partials/header')

    @slot('title')
        OPD | Classified Patient
    @endslot

    @section('pagestyle')
         <link href="{{ asset('public/css/partials/navigation.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/mss/classified.css') }}" rel="stylesheet" />
    @stop



    @section('header')
        @include('mss/navigation')
    @stop



    @section('content')
        <div class="container">
            <!-- <h3 class="text-center" style="font-weight: bold;">CLASSIFIED PATIENT's <i class="fa fa-users"></i><span class="pull-right">
            @if(isset($date))
                {{ $date }}
            @else
                {{ Carbon::today()->toDateString() }}
            @endif
            &nbsp;<i class="fa fa-calendar calendar" data-toggle="tooltip" data-placement="left" title="Click to view Another Day"></i></span></h3>

            <br> -->
            <br>
            <div class="data-adjustment">
                <form class="form-inline pull-left" method="GET">
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" placeholder="Patient name.." 
                        value="{{ $request->name }}" 
                        >
                        <span class="input-group-addon fa fa-user"></span>
                    </div>
                    <div class="input-group">
                        <input type="text" name="hospital_no" class="form-control" placeholder="Hospital no.." 
                        value="{{ $request->hospital_no }}" 
                        >
                        <span class="input-group-addon fa fa-building"></span>
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-sm">Filter</button>
                </form>
                <form class="form-inline text-right" method="GET">
                    <!-- <select class="form-control" name="type">
                        <option value="mss" hidden="" @if($request->type == "") selected @endif>TYPE</option>
                        <option value="mss" @if($request->type == "mss") selected @endif>MSS</option>
                        <option value="malasakit" @if($request->type == "malasakit") selected @endif>MALASAKIT</option>
                        <option value="mss" @if($request->type == "all") selected @endif>ALL</option>
                    </select> -->
                    <div class="input-group">
                        <input type="date" name="from" class="form-control" 
                        @if(isset($_GET['from'])) value="{{ $_GET['from'] }}" @endif 
                         required>
                        <span class="input-group-addon fa fa-calendar"></span>
                    </div>
                    <div class="input-group">
                         <input type="date" name="to" class="form-control" 
                         @if(isset($_GET['to'])) value="{{ $_GET['to'] }}" @endif 
                          required>
                        <span class="input-group-addon fa fa-calendar"></span>
                    </div>
                    
                   
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                </form>
            </div>
            <div class="text-left bg-default">
                <br>
            </div>
            <div>
              <ul class="nav nav-tabs">
                    @php
                        $total = 0;
                    @endphp
                    @foreach($tab as $list)
                    <li @if($request->id == $list->mss_id) class="active" @endif>
                        <a href="classified?id={{ $list->mss_id }}&type={{ $request->type }}&from={{ $request->from }}&to={{ $request->to }}&name={{ $request->name }}&hospital_no={{ $request->hospital_no }}"
                           class="" 
                           data-toggle="tooltip" data-placement="top" title="VIEW ONLY {{ $list->label.' - '.$list->description }}">
                            {{ $list->label.' - '.$list->description }}
                            <span class="badge">{{ $list->counts }}</span>
                        </a>
                    </li>
                    @php
                        $total += $list->counts;
                    @endphp
                    @endforeach
                    <li @if(!$request->id) class="active" @endif>
                        <a href="classified?type={{ $request->type }}&from={{ $request->from }}&to={{ $request->to }}&name={{ $request->name }}&hospital_no={{ $request->hospital_no }}"
                           class="" 
                           data-toggle="tooltip" data-placement="top" title="TOTAL">
                            TOTAL
                            <span class="badge">{{ $total }}</span>
                        </a>
                    </li>
                  
              </ul>
              <br>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="classifiedTable">
                    <thead>
                        <tr>
                            <th hidden></th>
                            <th>HOSPITAL#</th>
                            <th>PATIENTNAME</th>
                            <th>ADDRESS</th>
                            <th>BIRTHDAY</th>
                            <th>SEX</th>
                            <th>CLASSIFICATION</th>
                            <th>REFERRAL</th>
                            <th>CLASSIFIED BY</th>
                            <th>CLASSIFIED.DATE</th>
                            <th>PRINT</th>
                            <th>EDIT</th>
                            <th>VIEW</th>
                            <!-- <th>MALASAKIT</th> -->
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classified as $var)
                            <tr>
                                <td hidden></td>
                                <td>{{ $var->hospital_no }}</td>
                                <td>{{ $var->last_name.', '.$var->first_name.' '.$var->middle_name }}</td>
                                <td>{{ $var->address }}</td>
                                <td>{{ Carbon::parse($var->birthday)->format('m/d/Y') }}</td>
                                <td>{{ $var->sex }}</td>
                                <td>{{ $var->mss }}</td>
                                <td>{{ $var->referral }}</td>
                                <td>{{ $var->users }}</td>
                                <td>{{ Carbon::parse($var->created_at)->format('m/d/Y g:ia') }}</td>
                                <td><a href="{{ url('mssform/'.$var->id) }}" class="btn btn-primary" target="_blank" data-id="{{ $var->id }}"><span class="fa fa-print"></span></a>
                                    
                                </td>
                                <td><a href="{{ url('mss/'.$var->id.'/edit') }}" class="btn btn-success"><i class="fa fa-pencil"></i></a></td>
                                <td><a href="{{ url('view/'.$var->id) }}" class="btn btn-default"><i class="fa fa-eye"></i></a></td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="choosedatemodal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <form method="post" action="{{ url('classifiedbyday') }}">
                       {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">CHOOSE DATE</h4>
                    </div>
                    <div class="modal-body">
                        <input type="date" name="date" id="choose_date" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">OK</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    @endsection




    @section('pagescript')
        @include('message/toaster')
        <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/js/mss/classified.js') }}"></script>
    @stop


@endcomponent
