<div class="box-header with-border text-right">
    <form action="{{ url('topLeadingServices') }}" method="post" class="form-inline" role="form" onsubmit="full_loader()">
        {{ csrf_field() }}

        <div class="form-group">
            <div class="input-group">
        <span class="input-group-addon" id="startingDate" onclick="document.getElementById('start').focus()">
            <i class="fa fa-calendar"></i>
        </span>
                <input type="text" name="starting" class="form-control datepicker1" value="{{ $starting }}"
                       placeholder="Starting Date" aria-describedby="startingDate" id="start" />
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
                <input type="text" name="ending" class="form-control datepicker1" value="{{ $ending }}"
                       placeholder="Ending Date" aria-describedby="endingDate" id="ending">
            </div>
            @if ($errors->has('ending'))
                <span class="help-block">
                <strong class="">{{ $errors->first('ending') }}</strong>
            </span>
            @endif
        </div>


        &nbsp;
        <div class="form-group">
            <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-filter"></i>
            </span>
                <select name="limit" id="" class="form-control">
                    <option value="10" {{ ($limit == 10)? 'selected' : '' }}>Top 10</option>
                    <option value="20" {{ ($limit == 20)? 'selected' : '' }}>Top 20</option>
                    <option value="40" {{ ($limit == 40)? 'selected' : '' }}>Top 40</option>
                    <option value="80" {{ ($limit == 80)? 'selected' : '' }}>Top 80</option>
                    <option value="100" {{ ($limit == 100)? 'selected' : '' }}>Top 100</option>
                </select>
            </div>
        </div>

        &nbsp;
        <div class="form-group">
            <button class="btn btn-success btn-flat">Submit</button>
        </div>

    </form>
</div>