<div class="box-header with-border">

    <div class="col-md-5">
        <h3 style="margin: 5px 0 0 0 " class="text-blue">{{ $clinicName->name }}</h3>
    </div>

    <div class="col-md-7 text-right">


        <form action="{{ url('refferalsReport') }}" method="post" class="form-inline" onsubmit="full_loader()">

            {{ csrf_field() }}

            <div class="form-group @if ($errors->has('starting')) has-error @endif">
                <div class="input-group">
                            <span class="input-group-addon" id="startingDate" onclick="document.getElementById('starting').focus()">
                                <i class="fa fa-calendar"></i>
                            </span>
                    <input type="text" name="starting" class="form-control datepicker1" value="{{ $starting or '' }}"
                           placeholder="Starting Date" aria-describedby="startingDate" id="starting" required />
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
                    <input type="text" name="ending" class="form-control datepicker1" value="{{ $ending or '' }}"
                           placeholder="Ending Date" aria-describedby="endingDate" id="ending">
                </div>
                @if ($errors->has('ending'))
                    <span class="help-block">
                                <strong class="">{{ $errors->first('ending') }}</strong>
                            </span>
                @endif
            </div>


            <div class="form-group">
                <button class="btn btn-success btn-flat" type="submit">Submit</button>
            </div>

        </form>

    </div>

</div>