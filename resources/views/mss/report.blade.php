@component('partials/header')

  @slot('title')
    OPD | REPORT
  @endslot

  @section('pagestyle')
    <link href="{{ asset('public/css/mss/report.css') }}" rel="stylesheet" />
  @endsection

  @section('header')
    @include('mss/navigation')
  @endsection

  @section('content')
    <div class="container mainWrapper" id="wrapper">
        <div class="submitclassificationgenerate">
            <img src="public/images/loader.svg">
        </div>
        <div class="panel" id="mssreportgenarete">
            <div class="panel-heading">
            <h3>MSS REPORT <i class="fa fa-file-text-o"></i></h3>
            </div>
            <div class="panel-body" id="generatereportbody">
                <form class="form-horizontal generatemssreport" method="post" action="{{ url('genaratedreport') }}">
                     {{ csrf_field() }}
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>EMPLOYEE NAME</th>
                                <th colspan="2">DATE OF TRANSACTION</th>
                            </tr>
                            <tr>
                                <td rowspan="2">
                                    <select name="users_id" class="form-control" required>
                                        <option value="" hidden>--choose--</option>
                                        @foreach($employee as $list);
                                        <option value="{{ $list->id }}">{{ $list->last_name.' '.$list->first_name }}</option>
                                        @endforeach
                                        <option value="ALL">ALL</option>
                                        
                                    </select>
                                </td>
                                <td>FROM(start of date transact)</td>
                                <td>TO(end of date transact)</td>
                            </tr>
                            <tr>
                                <td><input type="date" name="from" class="form-control" required></td>
                                <td><input type="date" name="to" class="form-control" required></td>
                            </tr>
                        </table>
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success">GENERATE <i class="fa fa-cog"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  @endsection
  @section('pagescript')
    @include('message/toaster')
    <script src="{{ asset('public/js/mss/report.js') }}"></script>
  @endsection
@endcomponent
