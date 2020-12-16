@extends('app')
@section('content')
    
    <h3>Exchange Rates</h3>
    <a role="button" href="{{route('fetch')}}" class="btn btn-sm btn-primary">Fetch Rates</a>
    <a role="button" href="{{route('report')}}" class="btn btn-sm btn-primary">Report</a>
    <a role="button" href="{{route('export')}}" class="btn btn-sm btn-primary">Export to .xlsx</a>

    @if(isset($message) && isset($status))
        <strong class="d-block my-2 {{$status == 200 ? 'text-success' : 'text-danger'}}">{{$message}}</strong>
    @endif
    
    <h6 class="mt-3">Note: you can try api on this <a href="/api/rate">url</a>. Add <code>date</code> parameter.</h6>
    <h6 class="mt-5">Query for assignment 2:</h6>
    
    <code>SELECT value, GROUP_CONCAT(date SEPARATOR ', ') as dates FROM rates GROUP BY value;</code>
    
    
    <h6 class="mt-3">Assignment 3</h6>
    
    <p>There are more ways to do this. For performance-wise there should be testing for different scenarios. <br>
        For cost-wise option:</p>
@endsection