<div class="box-header with-border">

<form action="{{ url('monitoring') }}" method="post" class="form-inline" role="form" onsubmit="full_loader()">

    {{ csrf_field() }}


    <div class="form-group">
        <div class="radio">
            <label><input type="radio" value="daily" name="optradio" class="dailyBtn" checked> Daily</label>
        </div>
        &nbsp;
        <div class="radio">
            <label><input type="radio" value="monthly" name="optradio" class="monthlyBtn"> Monthly</label>
        </div>
    </div>


    &nbsp;


    <div class="form-group dailyWrapper">
        <div class="input-group">
                    <span class="input-group-addon" id="startingDate" onclick="document.getElementById('start').focus()">
                        <i class="fa fa-calendar"></i>
                    </span>
            <input type="text" name="daily" class="form-control datepicker" value="{{ $daily or '' }}"
                   placeholder="Select Month" aria-describedby="startingDate" id="start" required />
        </div>
        @if ($errors->has('daily'))
            <span class="help-block">
                        <strong class="">{{ $errors->first('daily') }}</strong>
                    </span>
        @endif
    </div>



    <div class="monthlyWrapper">

        <div class="form-group @if ($errors->has('starting')) has-error @endif">
            <div class="input-group">
                    <span class="input-group-addon" id="startingDate" onclick="document.getElementById('starting').focus()">
                        <i class="fa fa-calendar"></i>
                    </span>
                <input type="text" name="starting" class="form-control datepicker" value="{{ $starting or '' }}"
                       placeholder="Starting Date" aria-describedby="startingDate" id="starting" />
            </div>
            @if ($errors->has('starting'))
                <span class="help-block">
                        <strong class="">{{ $errors->first('starting') }}</strong>
                    </span>
            @endif
        </div>


        <div class="form-group @if ($errors->has('ending')) has-error @endif">
            <div class="input-group">
                    <span class="input-group-addon" id="endingDate" onclick="document.getElementById('ending').focus()">
                        <i class="fa fa-calendar"></i>
                    </span>
                <input type="text" name="ending" class="form-control datepicker" value="{{ $ending or '' }}"
                       placeholder="Ending Date" aria-describedby="endingDate" id="ending">
            </div>
            @if ($errors->has('ending'))
                <span class="help-block">
                        <strong class="">{{ $errors->first('ending') }}</strong>
                    </span>
            @endif
        </div>

    </div>


    &nbsp;

    <div class="form-group">
        <button class="btn btn-success btn-flat">Submit</button>
    </div>

</form>

</div>