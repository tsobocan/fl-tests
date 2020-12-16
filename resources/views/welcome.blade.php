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
    
    <code>SELECT value as RATE, GROUP_CONCAT(date order by date ASC SEPARATOR ', ') as Dates FROM rates GROUP BY value;</code>
    
    
    <h6 class="mt-3">Assignment 3</h6>
    
    <p>There are more ways to do this. For performance-wise there should be testing for different scenarios. <br>
        For cost-wise option: </p>
    <ul style="list-style: upper-roman">
        <li>I would select vendors that ship to Virginia at least one item (this way we get rid of D, E).</li>
        <li>In next step I would prepare single options.</li>
        <li>
            <ul>
                <li>Single A : 217,2 + 15 + 3 = 235,20.</li>
                <li>Single B : not possible.</li>
                <li>Single C : not possible.</li>
            </ul>
        </li>
        <li>We can take cheapest option from single options, and this is vendor A since it is only one possible and move
            to combinations.
        </li>
        <li>For next step we can go over all possible combinations, while combining cheapest vendor for each item (but we
            get doubled shipping).
        </li>
        <li>
            <ul>
                <li>Combination AB: not possible because item 1 is even more expensive (B), while item 2 is not
                    available (or is available only by vendor A).
                </li>
                <li>Combination AC: we could take item 1 from vendor C: 112 + 67,2 + 15 + 15 = 209,20.</li>
                <li>Combination BC: not possible because item 2 is not available.</li>
            </ul>
        </li>
        <li>
            In case when both vendors have both items we can make two options and choose cheapest.
        </li>
        <li>
            For final step I would choose two or more best options, mark best one and leave decision to customer. Most
            probably in case of combination the delivery wont be on same day, etc..
        </li>
        <li>If we are looking for cheapest option then this is combination of vendor C for Item 1 and vendor A for item
            2.
        </li>
    </ul>
    <p>This would be my strategy, but those calculations depend on number vendors, shipping options, items, etc. Most
        probably this is not perfect algorithm, but I would go with elimination of vendors as soon as possible. There is
        always an option to prepare all possible scenarios but can be time consuming.</p>

@endsection