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
    <h2 class="header-main">Reports</h2>
    <h4 class="header-main">Financial Overview</h4>
    <div class="filter-bar">
        <div class="row">
            <div class="col-md-6 time-period-div">
                <div class="time-period-dropdown">
                    <p>Time Period</p>
                    <label class="main-label">Current month</label>
                    <i class="fa fa-chevron-down"></i>
                </div>
                <label class="time-period-label">Jan 01, 2024-Jan 09,2024</label>
            </div>
            <div class="col-md-6 download-div">
                <button type="button" class="btn btn-outline-primary">Download PDF</button>
                <button type="button" class="btn btn-outline-primary">Download CSV</button>
            </div>
        </div>
        <div class="row total-col-data">
            <div class="col-md-3 ">
                <div class="main-data-div">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="div-label">Order   <img src="{{url('public/assets/web/images/info-1.png')}}"></label>
                        </div>
                        <div class="col-md-6 download-icon-div">
                            <img src="{{url('public/assets/web/images/download-icon.png')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="total-label">$9,595.54</h3>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-3">
                <div class="main-data-div">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="div-label">Refunds   <img src="{{url('public/assets/web/images/info-1.png')}}"></label>
                        </div>
                        <div class="col-md-6 download-icon-div">
                            <img src="{{url('public/assets/web/images/download-icon.png')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="total-label">-$396.43</h3>
                        </div>
                    </div>
                    <div class="price-data">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="gray-label">Gross refunds</label>
                            </div>
                            <div class="col-md-4 price-div">
                                <label class="">-$396.43</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="gray-label">Gross claims</label>
                            </div>
                            <div class="col-md-4 price-div">
                                <label class="">$0.00</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="gray-label">Gross payment disputes</label>
                            </div>
                            <div class="col-md-4 price-div ">
                                <label class="">$0.00</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="main-data-div">
                <div class="row">
                    <div class="col-md-6">
                        <label class="div-label">Expenses   <img src="{{url('public/assets/web/images/info-1.png')}}"></label>
                    </div>
                    <div class="col-md-6 download-icon-div">
                        <img src="{{url('public/assets/web/images/download-icon.png')}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="total-label">-$1,204,63</h3>
                    </div>
                </div>
                <div class="price-data">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="gray-label">Fees</label>
                        </div>
                        <div class="col-md-4 price-div">
                            <label class="">-$926.21</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label class="gray-label">Shipping labels</label>
                        </div>
                        <div class="col-md-4 price-div">
                            <label class="">$278.42</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label class="gray-label">Donations</label>
                        </div>
                        <div class="col-md-4 price-div ">
                            <label class="">$0.00</label>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="main-data-div">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="div-label">Net transfers <img src="{{url('public/assets/web/images/info-1.png')}}"></label>
                        </div>
                        <div class="col-md-6 download-icon-div">
                            <img src="{{url('public/assets/web/images/download-icon.png')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="total-label">-$8,029,68</h3>
                        </div>
                    </div>
                    <div class="price-data">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="gray-label">Charge</label>
                            </div>
                            <div class="col-md-4 price-div">
                                <label class="">$0.00</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="gray-label">Payouts</label>
                            </div>
                            <div class="col-md-4 price-div">
                                <label class="">-$8,029,68</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="financial-doc-div">
            <div class="row border-bottom">
                <h3>Financial documents</h3>
            </div>
            <div class="financial-table">
                <div class="row border-bottom">
                    <div class="col-md-3">
                        <h4>Transection Repports</h4>
                    </div>
                    <div class="col-md-5">
                        <p>These CSV files provides a detailed view of all the transections that occured over a custom... <u>show more</u></p>
                        <a href="#">See transaction reports explained</a>
                    </div>
                    <div class="col-md-2"><label>No report requested.</label></div>
                    <div class="col-md-2"><a href="#">create report</a></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-3">
                        <h4>Financial Statements</h4>
                    </div>
                    <div class="col-md-5">
                        <p>These PDF files provides a summary of your selling activity, including orders,refunds,claims,payment... <u>show more</u></p>
                        <a href="#">See transaction reports explained</a>
                    </div>
                    <div class="col-md-2"><a href="#"><img class="download-img-link" src="{{url('public/assets/web/images/blue-download-icon.png')}}"> <u>DEC-2023-statement-summary.pdf</u></a></div>
                    <div class="col-md-2"><a href="{{url('/finanical-statements')}}">See all</a></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-3">
                        <h4>Tax invoices</h4>
                    </div>
                    <div class="col-md-5">
                        <p>These invoices are issued for services rendered and include a PDF summary and a CSV file with detasiled... <u>show more</u></p>
                        <a href="#">See transaction reports explained</a>
                    </div>
                    <div class="col-md-2"><label>No report requested.</label></div>
                    <div class="col-md-2"><a href="{{url('/tax-invoice')}}">See all</a></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-3">
                        <h4>1099-K Forms</h4>
                    </div>
                    <div class="col-md-5">
                        <p>These ISR forms are taxpayers to report applicable payment transactions recived within a... <u>show more</u></p>
                        <a href="#">See transaction reports explained</a>
                    </div>
                    <div class="col-md-2"><label>No report requested.</label></div>
                    <div class="col-md-2"><a href="#">See all</a></div>
                </div>
            </div>
            
        </div>
    </div>
    <h2 class="header-main taxes-h2">Taxes</h2>
    <p class="header-main">Here you'll find your ebay tax documents from the past year, and a custom guide to help you navigate them.<br>If you have any questions about tax filling or regulations,consult a tax professional.</p>
    <div class="filter-bar">
        <div class="row">
            <div class="col-md-12 form-div">
                <button type="button" class="btn btn-outline-primary">Form 1099-K</button>
                <button type="button" class="btn btn-outline-primary">Form 1099-K details</button>
            </div>
        </div>
    </div>
    <h2 class="header-main taxes-h2">Form 1099-K</h2>
    <p class="gray-text">You got a <span>Form 1099-K</span> if your sales meet minimum IRS reporting thershold in a calender year</p>
    <div class="filter-bar">
        <div class="col">
            <div class="form-switch">
                <label class="form-check-label " for="flexSwitchCheckChecked">Paperless delivery </label>
                <input class="form-check-input" type="radio" id="flexSwitchCheckChecked" checked>
            </div>
        </div>
    </div>
    <p class="gray-text mt-4">You'll receive 1099-k forms electronically.</p>
    <table class="main-tabel-class table">
        <thead class="table-light text-normal">
            <tr>
                <th>Tax Year</th>
                <th>Date generated</th>
                <th>Download</th>
            </tr>
        </thead>
        <tr>
            <td>2023</td>
            <td>-</td>
            <td>You don't have a form 1099-K for this tax year.<img src="{{url('public/assets/web/images/info-1.png')}}"></td>
        </tr>
        <tr>
            <td>2022</td>
            <td>Jan 21, 2023</td>
            <td><a  class="link-tag" href="#">Form 1099-K_2022.pdf</a></td>
        </tr>
        <tr>
            <td>2021</td>
            <td>Jan 21, 2022</td>
            <td><a  class="link-tag" href="#">Form 1099-K_2021.pdf</a></td>
        </tr>
    </table>
</div>
@endsection