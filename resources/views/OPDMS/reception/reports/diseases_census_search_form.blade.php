<div class="box-header with-border">

    <div class="row">
        <div class="col-md-3">
            <h3 style="margin: 0" class="text-blue">{{ $clinic->name }}</h3>
        </div>
        <div class="col-md-9 text-right">
            <form action="{{ url('receptionCensus') }}" class="form-inline" method="post" onsubmit="full_loader()">
                {{ csrf_field() }}


                <div class="form-group @if ($errors->has('startingDate')) has-error @endif">
                    <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-filter"></i>
                                </span>
                        <select name="filter" id="" class="form-control">
                            <option value="5000" {{ ($limit == 5000)? 'selected' : '' }}>Show All</option>
                            <option value="10" {{ ($limit == 10)? 'selected' : '' }}>Top 10 Diseases</option>
                            <option value="20" {{ ($limit == 20)? 'selected' : '' }}>Top 20 Diseases</option>
                            <option value="50" {{ ($limit == 50)? 'selected' : '' }}>Top 50 Diseases</option>
                        </select>
                    </div>
                </div>



                {{--<div class="form-group">
                    <label for="">Filter By:</label>
                    <select name="filter" id="" class="form-control">
                        <option value="5000">Show All</option>
                        <option value="10">Top 10 Diseases</option>
                        <option value="20">Top 20 Diseases</option>
                        <option value="50">Top 50 Diseases</option>
                    </select>
                </div>--}}

                {{--<div class="form-group @if ($errors->has('startingDate')) has-error @endif" style="margin: 0 15px">


                    <div class="input-group">
                        <span class="input-group-addon" id="endingDate" onclick="document.getElementById('ending').focus()">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" name="startingDate" value="{{ $starting or '' }}"
                               id="datepicker" placeholder="Enter Starting Date" class="form-control" />
                    </div>



                    @if ($errors->has('startingDate'))
                        <span class="help-block">
                            <strong class="">{{ $errors->first('startingDate') }}</strong>
                        </span>
                    @endif

                </div>--}}


                &nbsp;



                <div class="form-group @if ($errors->has('startingDate')) has-error @endif">
                    <div class="input-group">
                                <span class="input-group-addon" onclick="document.getElementById('starting').focus()">
                                    <i class="fa fa-calendar"></i>
                                </span>
                        <input type="text" name="startingDate" value="{{ $starting or '' }}"
                               id="starting" placeholder="Enter Starting Date" class="form-control datepicker1" />
                    </div>
                    @if ($errors->has('startingDate'))
                        <span class="help-block">
                                     <strong class="">{{ $errors->first('startingDate') }}</strong>
                                 </span>
                    @endif
                </div>



                {{--<i class="fa fa-arrow-right" style="margin: 0 20px"></i>--}}

                {{--<div class="form-group @if ($errors->has('endingDate')) has-error @endif">
                    <label for="">Ending Date <i class="fa fa-calendar"></i> :</label>
                    <input type="text" id="endingDate" value="{{ old('endingDate') }}" name="endingDate" placeholder="Enter Ending Date" class="form-control" />
                    @if ($errors->has('endingDate'))
                        <span class="help-block">
                            <strong class="">{{ $errors->first('endingDate') }}</strong>
                        </span>
                    @endif
                </div>--}}


                &nbsp;




                <div class="form-group @if ($errors->has('endingDate')) has-error @endif">
                    <div class="input-group">
                                <span class="input-group-addon" onclick="document.getElementById('endingDate').focus()">
                                    <i class="fa fa-calendar"></i>
                                </span>
                        <input type="text" id="endingDate" value="{{ $ending or ''}}" name="endingDate"
                               placeholder="Enter Ending Date" class="form-control datepicker1" />
                    </div>
                    @if ($errors->has('endingDate'))
                        <span class="help-block">
                                     <strong class="">{{ $errors->first('endingDate') }}</strong>
                                 </span>
                    @endif
                </div>



                &nbsp;




                <div class="form-group">
                    <button type="submit" class="btn btn-flat btn-success">Submit</button>
                </div>



            </form>
        </div>
    </div>

</div>