@extends('layouts.web')
@section('pagebodyclass')
full-width
@endsection
@section('content')
<div class="report-main-div container-fluid">
    <h2 class="header-main taxes-h2">Financial Statements</h2>
    <p class="gray-text mt-4">These PDF files provide a summary of your selling activity, including orders,refunds,claims,payment disputes,payouts, and more for given month.</p>
    <a  class="link-tag mt-4" href="#">Learn more about financial statements</a>
    <table class="main-tabel-class table mt-4">
        <thead class="table-light text-normal">
            <tr>
                <th>Statement Name</th>
                <th>Date range</th>
                <th>Options</th>
            </tr>
        </thead>
        <?php
        $months = array("1", "2", "3", "4", '5','6', '7', '8', '9', '10','11', '12');
        ?>
        @foreach ($months as $month)
            <?php
                $year = date('Y') - 1; // Get current year and subtract 1
                $start = mktime(0, 0, 0, $month, 1, $year);

                $monthstart = date('M 01, Y', $start);

                $monthend = date('M t, Y', $start);

                $yearMonth = date('M Y', $start);
            ?>
        <tr>
            <td>{{$yearMonth}} Statement</td>
            <td>{{$monthstart.' - '.$monthend}}</td>
            <td><a  class="link-tag" href="{{url('finanical-statements/preview/'.$monthstart.' - '.$monthend)}}">Preview</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  class="link-tag" href="{{url('finanical-statements/download/'.$monthstart.' - '.$monthend)}}">Download</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection