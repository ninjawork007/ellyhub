@extends('layouts.web')
@section('pagebodyclass')
full-width
@endsection
@section('content')
<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Reports
</nav>
<div class="report-main-div">
    <h2 class="header-main taxes-h2">Tax Invoices</h2>
    <p class="gray-text mt-4">These invoices are issued for services rendered and include a PDF summary and a CSV  file with a detailed breakdown of all applicable selling costs and fee.</p>
    <a  class="link-tag mt-4" href="#">Learn more about tax invoise</a>
    <table class="main-tabel-class table mt-4">
        <thead class="table-light text-normal">
            <tr>
                <th>Tax Invoice Name</th>
                <th>Date generated</th>
                <th>Date range</th>
                <th>Actions</th>
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
                <td>{{$yearMonth}} tax invoice</td>
                <td>{{$monthend}}</td>
                <td>{{$monthstart.' - '.$monthend}}</td>
                <td><a  class="link-tag" href="{{url('tax-invoice/download/'.$monthstart.' - '.$monthend)}}">Summary Download</a> | <a  class="link-tag" href={{url('tax-invoice/download/'.$monthstart.' - '.$monthend)}}>Detail Download</a></td>
            </tr>
        @endforeach
    </table>
</div>
@endsection