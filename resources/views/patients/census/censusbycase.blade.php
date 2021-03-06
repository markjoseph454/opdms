<div class="table-responsive" id="referralcensus">
	<table class="table table-bordered">
		<tr>
			<th class="text-center" colspan="14">EVRMC REFERRAL</th>
		</tr>
		<tr>
			<th class="text-center" style="padding: 2px;background-color: #e6e6e6" colspan="14"><i>OUT PATIENT DEPARTMENT</i></th>
		</tr>
		<tr class="bg-success">
			<th colspan="1" rowspan="2" class="text-center">{{$request->hospital}}</th>
			<th rowspan="2">TOTAL</th>
			<th colspan="12" class="text-center">Month</th>
		<tr class="bg-success">
			@php
				$month = 'January,February,March,April,May,June,July,August,September,October,November,December';
				$exmonth =  explode(',', $month); 
			@endphp
		
			
			@for($i=0;$i < 12;$i++)
			<th><a href="{{ url('referralreport') }}?month={{$i+1}}&years={{$request->years}}&hospitalidbymonth={{$request->hospitalid}}&hospital={{$request->hospital}}">{{$exmonth[$i]}} </a></th>
			@endfor
			
		</tr>
		
		@foreach($data as $list)
		<tr>
			<td>{{ $list->diagnosis }}</td>
			<td>{{ $list->results }}</td>
			@php
				$result = App\Regfacility::countpercase($list->diagid, $list->facility, $request->starting_month, $request->ending_month, $request->years);
			@endphp
			@for($lo = 1; $lo <= 12; $lo++)
				<td align="center">
					@foreach($result as $var) 
						@if($var->yearmonth == $lo) 
							{{ $var->results }}
						@endif
					@endforeach
				</td>
			@endfor
		</tr>
		@endforeach
		
	</table>
</div>