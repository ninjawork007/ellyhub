@extends('layouts.web')
@section('pagebodyclass')
full-width
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div class="report-main-div container-fluid">
    <h2 class="header-main">Reports</h2>
    <h4 class="header-main">Financial Overview</h4>
    <div class="filter-bar">
        <div class="row">
            <div class="col-md-6 time-period-div position-relative">
                <div class="time-period-dropdown">
                    <p>Time Period</p>
                    <label class="main-label">{{$current}}</label>
                    <i class="fa fa-chevron-down"></i>
                </div>
                @php
                    $startenddate = date('M d, Y', strtotime($created_at_start)).'-'.date('M d, Y', strtotime($created_at_end));
                @endphp
                <label class="time-period-label">{{$startenddate}}</label>
                <div class="filters position-absolute" style="width:30%;display:none;padding:10px 30px 10px 10px;top:60px;background-color: #fff;border-radius: 10px;border:1px solid #000">
                    <div class="row {{(Request::is('reports-taxes')) ? 'active' : ''}}">
                        <div class="col-md-10">
                            <a href="{{url('reports-taxes')}}" class="text-black">Current month</a>
                        </div>
                        <div class="col-md-2 text-end">
                            <i class="fa fa-check text-black"></i>
                        </div>
                    </div>
                    <div class="row {{(Request::is('reports-taxes/last-week')) ? 'active' : ''}}">
                        <div class="col-md-10">
                            <a href="{{url('reports-taxes/last-week')}}" class="text-black">Last week</a><br>
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-check text-black"></i>
                        </div>
                    </div>
                    <div class="row {{(Request::is('reports-taxes/last-month')) ? 'active' : ''}}">
                        <div class="col-md-10">
                            <a href="{{url('reports-taxes/last-month')}}" class="text-black">Last month</a><br>
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-check text-black"></i>
                        </div>
                    </div>
                    <div class="row {{(Request::is('reports-taxes/last-year')) ? 'active' : ''}}">
                        <div class="col-md-10">
                            <a href="{{url('reports-taxes/last-year')}}" class="text-black">Last year</a><br>
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-check text-black"></i>
                        </div>
                    </div>
                    <div class="row {{($current == 'Custom') ? 'active' : ''}}">
                        <div class="col-md-10">
                            <a href="#" class="text-black open-datepicker">Custom</a>
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-check text-black"></i>
                        </div>
                    </div>
                </div>

                <div class="open-daterange position-absolute" style="display:none;">
                    <input type="text" name="daterange" value="" class="text-black" />
                </div>
            </div>
            <div class="col-md-6 download-div">
                <a href="{{url('payments/download/'.$filter)}}" class="btn btn-outline-primary">Download PDF</a>
                <a class="btn btn-outline-primary">Download CSV</a>
            </div>
        </div>

        <div class="row total-col-data">
            <div class="col-md-3 ">
                <div class="main-data-div">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="div-label">Order <img src="{{url('public/assets/web/images/info-1.png')}}"></label>
                        </div>
                        <div class="col-md-6 download-icon-div">
                            <?php
                                $currentPath = request()->path();
                                $replacePath = str_replace('reports-taxes', '', $currentPath);
                            ?>
                            @if(!empty($ordersTotal))<a href="{{url('download-report'.$replacePath)}}"><img src="{{url('public/assets/web/images/download-icon.png')}}"></a>@endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="total-label">${{(!empty($ordersTotal)) ? number_format($ordersTotal, 2) : '0.00'}}</h3>
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
                        <?php $finalprice = []; ?>
                        @if(!empty($refundTotal))
                            @foreach($refundTotal as $refunds)
                                <?php
                                    $quantityPrice = ($refunds->product_price * $refunds->product_quantity);
                                    if(!empty($refunds->quantity)){
                                        $finalprice[] = ($quantityPrice / $refunds->quantity);
                                    }
                                    else{
                                        $finalprice[] = (($quantityPrice * $refunds->refund_percentage) / 100);
                                    }
                                ?>
                            @endforeach
                        @endif

                            <?php $price = array_sum($finalprice) ?>
                        <div class="col-md-12">
                            <h3 class="total-label">${{number_format($price, 2)}}</h3>
                        </div>
                    </div>
                    <div class="price-data">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="gray-label">Gross refunds</label>
                            </div>
                            <div class="col-md-4 price-div">
                                <label class="">${{number_format($price, 2)}}</label>
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
                    <div class="col-md-2"><a href="{{url('/finanical-statements')}}"><img class="download-img-link" src="{{url('public/assets/web/images/blue-download-icon.png')}}"> <span class="text-decoration-underline">DEC-2023-statement-summary.pdf</span></a></div>
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
    <h2 class="text-black fw-bold taxes-h2">Form 1099-K</h2>
    <p class="gray-text">You got a <span>Form 1099-K</span> if your sales meet minimum IRS reporting thershold in a calender year</p>
    <div class="filter-bar">
        <div class="col">
            <div class="form-switch">
                <label class="form-check-label">Paperless delivery </label>
                <input class="form-check-input checkbox" type="checkbox" name="paperless_delivery" value="1">
            </div>
        </div>
    </div>
    <p class="gray-text mt-4">You'll receive 1099-k forms electronically.</p>
    <table class="main-tabel-class table border-top">
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
            <td><a  class="link-tag" href="{{url('taxes_pdf')}}">Form 1099-K_2022.pdf</a></td>
        </tr>
        <tr>
            <td>2021</td>
            <td>Jan 21, 2022</td>
            <td><a  class="link-tag" href="#">Form 1099-K_2021.pdf</a></td>
        </tr>
    </table>
</div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $('.time-period-dropdown').click(function(){
        $('.filters').fadeToggle();
    });

    $('.open-datepicker').click(function(e){
        e.preventDefault();

        $('.open-daterange').show();
        $('.open-daterange .text-black').click();
        $('.filters').fadeOut();
    });

    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'right'
        }, function(start, end, label) {
            window.location.href='{{url('reports-taxes/custom')}}/'+start.format('YYYY-MM-DD')+'/'+end.format('YYYY-MM-DD');
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
</script>
@endsection