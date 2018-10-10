<!-- Modal -->


<style>
    input[name="barcode"]{
        height: 70px;
        text-align: center;
        font-size: 25px;
        background-color: transparent;
        border: 2px solid #00b300;
        border-radius: 5px;
    }
    input[name="barcode"]:focus{
        border:2px solid #00b300;
        box-shadow: 5px -5px 12px #b3ffb3, -5px 5px 12px #b3ffb3;
    }
    #qrcodeModal .modal-body{
        padding: 50px;
    }
</style>

<div id="qrcodeModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Enter QRCode or Hospital No.</h4>
            </div>
            <div class="modal-body">

                <form action="{{ url('receptionsbarcode') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group @if($errors->has('barcode')) has-error @endif">
                        <input type="text" name="barcode" class="form-control" value="" autofocus required />
                        @if($errors->has('barcode'))
                            <span class="help-block">
                            <strong>{{ $errors->first('barcode') }}</strong>
                        </span>
                        @endif
                    </div>
                </form>


                <br>
                <p class="text-center">
                    <strong>
                        “ Prioritization of patients for medical treatment ”
                    </strong>
                </p>
                <p class="text-center text-muted">
                    Medicine is a science of uncertainty and an art of probabality.
                </p>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>