{{--<style>
    td{
        height: 40px;
    }
</style>--}}
<table border="1">
        {{--<tr>
            <th colspan="4" align="center" style="height: 15px">
                <strong>{{ ($radiology->clinic == 22)? 'RADIOGRAPHIC' : 'ULTRASOUND'}} RESULT</strong>
            </th>
        </tr>--}}
        {{--<tr>
            <td style="width: 300px;height: 20px">
                EVRMC-RADIO-UTZ &nbsp; <strong>{{ $radiology->imageID }}</strong> &nbsp; S.2018
            </td>
            <td colspan="3" style="width: 267px">
                Effectivity: Aug 18, 2017 Rev.1
            </td>
        </tr>--}}
        <tr>
            <td>
                <b>Name:</b>
                {{ $radiology->patient }}
            </td>
            <td>
                <b>Hospital Number:</b>
                098908
            </td>
            <td>
                <b>Date:</b>
                {{ Carbon::parse($radiology->created_at)->toFormattedDateString() }}
            </td>
            {{--<td>
                Age
                <br>
                {{ App\Patient::age($radiology->birthday).' / '.$radiology->sex }}
            </td>
            <td style="width: 70px">
                Ward <br>
                OPD
            </td>
            <td style="width: 127px">
                Date/Time
                <br>
                {{ Carbon::parse($radiology->created_at)->toFormattedDateString() }}
            </td>--}}
        </tr>
        <tr>
            <td>
                <b>Birthdate:</b>
                {{ \Carbon\Carbon::parse($radiology->birthday)->toFormattedDateString() }}
            </td>
            <td>
                <b>Case Number:</b>
                <br>
                EVRMC-RADIO-UTZ &nbsp; <strong>{{ $radiology->imageID }}</strong> &nbsp; S.2018
            </td>
            <td>
                <b>Time</b>
                {{ \Carbon\Carbon::parse($radiology->created_at)->format('h:i a') }}
            </td>
        </tr>
        <tr>
            <td>
                <b>Address:</b> {{ $radiology->address }}
            </td>
            <td>
                <b>Age:</b>
                {{ \App\Patient::age($radiology->birthday) }}
                &nbsp;
                <b>Sex:</b>
                {{ $radiology->sex }}
            </td>
            <td>
                <b>Ward:</b> OPD
            </td>
        </tr>
        <tr>
            <td>
                <b>Clinical Data:</b>
                <br>
                {{ $radiology->clinicalData }}
            </td>
            <td>
                <b>Attending Physician</b>
                <br>
                {{ $radiology->physician }}
            </td>
            <td>
                <b>OR NO.:</b>
            </td>
        </tr>
        {{--<tr>
            <td style="height: 35px">
                Clinic Data <br>
                {{ $radiology->clinicalData }}
            </td>
            <td style="width: 267px">
                Attending Physician <br>
                {{ $radiology->physician }}
            </td>
        </tr>--}}
</table>


