@extends('app')
@section('content')
    
    <h3>Report</h3>
    <span>
        <a href="{{route('home')}}">Go back</a>
    </span>
    @if($rates->isEmpty())
        <strong>Please import rates before using reports.</strong>
    @else
        <a role="button" href="{{route('export')}}" class="btn btn-sm btn-primary mx-2">Export to .xlsx</a>
        <table class="table table-sm f-table">
            <thead>
            <tr>
                <th>Year/Month</th>
                <th class="ft-right">Min</th>
                <th class="ft-right">Max</th>
                <th class="ft-right">Avg</th>
            </tr>
            </thead>
            <tbody>
                @foreach($rates as $rate)
                    <tr>
                        <td><strong>{{$rate->month_year}}</strong></td>
                        <td class="ft-right">{{$rate->min_value}}</td>
                        <td class="ft-right">{{$rate->max_value}}</td>
                        <td class="ft-right"><span data-toggle="tooltip"  data-placement="top" title="Based on {{$rate->total_records}} records.">{{$rate->avg_value}}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <small>Hovering over avg value will display total count of entries in month.</small>
    @endif


@endsection