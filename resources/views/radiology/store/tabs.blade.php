<ul class="nav nav-tabs">



@if(Request::is('addResult/*'))
    <li class="active">
        <a data-toggle="tab" href="#addResultWrapper">
            Add Result <i class="fa fa-file-text-o"></i>
        </a>
    </li>
@else
        <li class="active">
            <a data-toggle="tab" href="#addResultWrapper">
                Edit Result <i class="fa fa-file-text-o"></i>
            </a>
        </li>
@endif


@if(Auth::user()->clinic == 21)
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Ultrasound
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        @foreach($ultrasound as $row)
            <li>
                <a href="#" onclick="showTemplate({{ $row->id }})">
                    {{ $row->description }}
                </a>
            </li>
        @endforeach
    </ul>
</li>
@endif


@if(Auth::user()->clinic == 22)
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        X-Ray
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        @foreach($xray as $row)
            <li>
                <a href="#" onclick="showTemplate({{ $row->id }})">
                    {{ $row->description }}
                </a>
            </li>
        @endforeach
    </ul>
</li>
@endif



@if(Request::is('radiology/*/edit'))
<li>
    <a href="{{ url('radiologyPrint/'.$radiology->id) }}" target="_blank">
        Print <i class="fa fa-print"></i>
    </a>
</li>
@endif



</ul>