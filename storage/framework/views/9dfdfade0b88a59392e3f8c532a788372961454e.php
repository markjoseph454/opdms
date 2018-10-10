<h5 class="text-center"><strong class="text-default">REQUISITION</strong></h5>

<div class="col-md-3 departmentWrapper">
    <form onsubmit="return false">
        <div class="form-group">
            <input type="text" name="" class="form-control" placeholder="Search Department..." />
        </div>
    </form>
    <div class="list-group departmentsContainer">
        <h6 class="text-center">DEPARTMENTS</h6>
        <a href="" clinic-code="1031" id="pharmacyDepartment" class="list-group-item" style="background-color: #333;color: #fff">PHARMACY</a>
        <a href="" clinic-code="103299" category="10" class="list-group-item laboratories">LABORATORY</a>
        <a href="" clinic-code="1033" category="6" class="list-group-item laboratories" disabled="">ULTRASOUND</a>
        <a href="" clinic-code="1034" category="11" class="list-group-item laboratories">XRAY</a>
        <a href="" clinic-code="1019" category="7" class="list-group-item laboratories">INJECTION ROOM/ABTC</a>
        <a href="" clinic-code="0" category="12" class="list-group-item laboratories">ECG</a>
        <?php if(Auth::user()->clinic == 34): ?>
        <a href="" clinic-code="1011" category="4" class="list-group-item laboratories">SURGERY</a>
        <?php endif; ?>
        <?php if(Auth::user()->clinic == 24): ?>
            <a href="" clinic-code="1007" category="3" class="list-group-item laboratories">OPTHALMOLOGY</a>
        <?php endif; ?>

        <?php if(Auth::user()->clinic == 26): ?>
        <a href="" clinic-code="26" category="1" class="list-group-item laboratories">PEDIATRICS</a>
        <?php endif; ?>
        <?php if(Auth::user()->clinic == 5): ?>
        <a href="" clinic-code="2" category="2" class="list-group-item laboratories">ENT</a>
        <?php endif; ?>
        <?php if(Auth::user()->clinic == 3): ?>
        <a href="" clinic-code="3" category="5" class="list-group-item laboratories">DENTAL</a>
        <?php endif; ?>
        <?php if(Auth::user()->clinic == 25): ?>
        <a href="" clinic-code="25" category="8" class="list-group-item laboratories">ORTHOPEDIC</a>
        <?php endif; ?>
        <?php if(Auth::user()->clinic == 32): ?>
        <a href="" clinic-code="32" category="9" class="list-group-item laboratories">REHABILITATION</a>
        <?php endif; ?>
        <?php if(Auth::user()->clinic == 29): ?>
        <a href="" clinic-code="29" category="17" class="list-group-item laboratories">PSYCHIATRY</a>
        <?php endif; ?>
        <?php if(Auth::user()->clinic == 43): ?>
        <a href="" clinic-code="43" category="15" class="list-group-item laboratories">INDUSTRIAL CLINIC</a>
        <?php endif; ?>
        
    </div>
</div>