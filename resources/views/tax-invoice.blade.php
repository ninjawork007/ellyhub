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
        @for($i=1;$i<=18;$i++)
        <tr>
            <td>Dec 2023 tax invoice</td>
            <td>Dec 31, 2023</td>
            <td>Dec 1, 2023 - Dec 31, 2023</td>
            <td><a  class="link-tag" href="#">Summary Download</a> | <a  class="link-tag" href="#">Detail Download</a></td>
        </tr>
        @endfor
    </table>
</div>
@endsection