<ul class="nav nav-pills">
    <li>
        <a href="{{ url('overview') }}"
           class="unassignedTab {{ ($status == false)? 'unassignedTabActive' : '' }}">
            Unassigned <span class="badge">{{ count($unassigend) }}</span>
        </a>
    </li>
    <li>
        <a href="{{ url('overview/P') }}"
           class="pendingTab {{ ($status == 'P')? 'pendingTabActive' : '' }}">
            Pending <span class="badge">{{ (isset($survey[0]->pending))? $survey[0]->pending : 0 }}</span>
        </a>
    </li>
    <li>
        <a href="{{ url('overview/H') }}"
           class="pausedTab {{ ($status == 'H')? 'pausedTabActive' : '' }}">
            Paused <span class="badge">{{ (isset($survey[0]->paused))? $survey[0]->paused : 0 }}</span>
        </a>
    </li>
    <li>
        <a href="{{ url('overview/C') }}"
           class="nawcTab {{ ($status == 'C')? 'nawcTabActive' : '' }}">
            NAWC <span class="badge">{{ (isset($survey[0]->nawc))? $survey[0]->nawc : 0 }}</span>
        </a>
    </li>
    <li>
        <a href="{{ url('overview/S') }}"
           class="servingTab {{ ($status == 'S')? 'servingTabActive' : '' }}">
            Serving <span class="badge">{{ (isset($survey[0]->serving))? $survey[0]->serving : 0 }}</span>
        </a>
    </li>
    <li>
        <a href="{{ url('overview/F') }}"
           class="finishedTab {{ ($status == 'F')? 'finishedTabActive' : '' }}">
            Finished <span class="badge">{{ (isset($survey[0]->finished))? $survey[0]->finished : 0 }}</span>
        </a>
    </li>
    <li>
        <a href="{{ url('overview/T') }}"
           class="totalTab {{ ($status == 'T')? 'totalTabActive' : '' }}">
            Total <span class="badge">
                @if(isset($survey) && $survey)
                {{ $survey[0]->serving + $survey[0]->pending + $survey[0]->nawc + $survey[0]->finished + $survey[0]->paused + count($unassigend) }}
                @else
                    {{ count($unassigend) }}
                @endif
                </span>
        </a>
    </li>
</ul>