<div class="box-header with-border">
        <form class="form-inline text-right" method="GET" onsubmit="full_loader()">
            <div class="form-group">
                <label>FILTER </label>
                <select class="form-control" name="top" required>
                    <option value="" hidden>CHOOSE</option>
                    @if(isset($_GET['top']))
                        <option value="10"  @if($_GET['top'] == '10') selected @endif>TOP 10</option>
                        <option value="20"  @if($_GET['top'] == '20') selected @endif>TOP 20</option>
                        <option value="30"  @if($_GET['top'] == '30') selected @endif>TOP 30</option>
                        <option value="ALL" @if($_GET['top'] == 'ALL') selected @endif>ALL</option>
                    @else
                        <option value="10">TOP 10</option>
                        <option value="20">TOP 20</option>
                        <option value="30">TOP 30</option>
                        <option value="ALL">ALL</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label>FROM </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="date" name="from" class="form-control" @if(isset($_GET['to'])) value="{{  $_GET['from'] }}" @endif required>
                </div>
            </div>
            <div class="form-group">
                <label>TO </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="date" name="to" class="form-control" @if(isset($_GET['to'])) value="{{  $_GET['to']  }}" @endif required>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-flat"> SUBMIT <span class="fa fa-cog"></span></button>
            </div>
        </form>

</div>

