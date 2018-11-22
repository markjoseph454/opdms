<div class="box-header with-border">
    <form action="{{ url('queued_history') }}" class="form-inline" method="post">
        {{ csrf_field() }}
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" name="start" class="form-control datepicker1" placeholder="Starting Date"
                    data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="{{ $start }}" />
        </div>
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" name="end" class="form-control datepicker1" placeholder="Ending Date"
                   data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="{{ $end }}" />
        </div>
        <div class="form-group">
            <select name="status" class="form-control select2">
                <option value="A" @if($status == 'A') selected @endif>All</option>
                <option value="F" @if($status == 'F') selected @endif>Finished</option>
                <option value="S" @if($status == 'S') selected @endif>Serving</option>
                <option value="P" @if($status == 'P') selected @endif>Pending</option>
                <option value="H" @if($status == 'H') selected @endif>Paused</option>
                <option value="C" @if($status == 'C') selected @endif>NAWC</option>
                <option value="U" @if($status == 'U') selected @endif>Unassigned</option>
            </select>
        </div>
        <div class="form-group">
            <select name="doctor_id" class="form-control select2">
                <option value="">SHOW ALL</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" @if($doctor_id == $doctor->id) selected @endif>
                        {{ $doctor->last_name.', '.$doctor->first_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-flat bg-green" onclick="full_window_loader()">
                Submit
            </button>
        </div>
    </form>
</div>