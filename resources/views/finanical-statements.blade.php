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
        @for($i=1;$i<=18;$i++)
        <tr>
            <td>Dec 2023 Statement</td>
            <td>Dec 1, 2023 - Dec 31, 2023</td>
            <td><a  class="link-tag" href="#">Preview</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  class="link-tag" href="#">Download</a></td>
        </tr>
        @endfor
    </table>
</div>
@endsection