@extends('seller.layouts.common')

@section('content')
    <div class="container-fluid mt-4">
        <div class="dashboard bg-white p-4 mb-4" style="-webkit-box-shadow: 0px 1px 5px 3px rgba(209,209,209,1);
-moz-box-shadow: 0px 1px 5px 3px rgba(209,209,209,1);
box-shadow: 0px 1px 5px 3px rgba(209,209,209,1);">
            <ul class="remaining-things row">
                <li class="col">
                    <div class="div-remaining text-center">
                        <h6 class="text-black">Unread Messages</h6>
                        <p class="mb-0 {{($unread_messages > 2) ? 'text-danger' : ''}}">{{$unread_messages}}</p>
                    </div>
                </li>
                <li class="col">
                    <div class="div-remaining text-center">
                        <h6 class="text-black">Awaiting shipment</h6>
                        <p class="mb-0 {{($unread_messages > 2) ? 'text-danger' : ''}}">{{$unread_messages}}</p>
                    </div>
                </li>
                <li class="col">
                    <div class="div-remaining text-center">
                        <h6 class="text-black">Sales ({{$strtotime}})</h6>
                        <p class="mb-0">${{$userOrders}}</p>
                    </div>
                </li>
                <li class="col">
                    <div class="div-remaining text-center">
                        <h6 class="text-black">Today</h6>
                        <p class="mb-0">${{$todaysOrders}}</p>
                    </div>
                </li>
                <li class="col">
                    <div class="div-remaining text-center">
                        <h6 class="text-black">Seller level</h6>
                        <p class="mb-0">Top rated</p>
                    </div>
                </li>
                <li class="col">
                    <div class="div-remaining text-center">
                        <h6 class="text-black">Returns</h6>
                        <p class="mb-0 {{($returns > 2) ? 'text-danger' : ''}}">{{$returns}}</p>
                    </div>
                </li>
                <li class="col">
                    <div class="div-remaining text-center">
                        <h6 class="text-black">Disputes</h6>
                        <p class="mb-0">Top rated</p>
                    </div>
                </li>
            </ul>

            <div class="row mt-4 equal-height-row">
                <div class="col-md-4">
                    <div class="ps-4 py-4 todo bg-silver position-relative h-100">
                        <h3 class="text-black fst-italic">To Do's</h3>
                        <div class="row">
                            <div class="col-md-10">
                                <ul>
                                    <li>
                                        <div class="first">
                                            Ready to ship
                                        </div>
                                    </li>
                                    <li>
                                        <div class="first">
                                            Overdue
                                        </div>
                                    </li>
                                    <li>
                                        <div class="first">
                                            Return request
                                        </div>
                                    </li>
                                    <li>
                                        <div class="first">
                                            Unread Messages
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-2">
                                <p class="text-black fst-italic fw-bold">45</p>
                                <p class="text-black fst-italic fw-bold">2</p>
                                <p class="text-black fst-italic fw-bold">2</p>
                                <p class="text-black fst-italic fw-bold">0</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="ps-4 py-4 todo bg-silver position-relative">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="text-black">Sales</h3>
                            </div>
                            <div class="col-md-6 text-end pe-4">
                                <select class="seller-dropdown px-2 py-0">
                                    <option value="this_month" selected>This month</option>
                                    <option value="7">7 Days</option>
                                    <option value="30">30 Days</option>
                                    <option value="90">90 Days</option>
                                </select>
                            </div>
                        </div>
                        <h3 class="text-black">${{$userOrders}} <small class="text-green"><span class="text-black">USD</span> (+1.37)</small></h3>
                        <canvas id="myChart" style="width:100%;height:200px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="row taxes-reports-returns-reviews mt-5">
                <div class="col-md-4">
                    <h3 class="text-black fst-italic">Taxes and Reports</h3>
                    <ul class="fst-italic ps-5" style="list-style-type: disc;">
                        <li><a style="font-size:20px;" href="{{url('finanical-statements')}}">Financial statements</a></li>
                        <li><a style="font-size:20px;" href="{{url('finanical-statements')}}">Financial overview</a></li>
                        <li><a style="font-size:20px;" href="{{url('tax-invoice')}}">Tax invoices</a></li>
                        <li><a style="font-size:20px;" href="{{url('taxes_pdf')}}">Form 1099-K</a></li>
                    </ul>
                </div>
                <div class="col-md-8">
                    <div class="row border-bottom">
                        <div class="col-md-6">
                            <h4 class="text-black fw-normal">Return rate</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <h4 class="text-black mb-0 fw-normal">4.42%</h4>
                            <p class="text-silver fw-normal">96 of 2,170 transactions</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <p class="text-black fw-normal">Select by category, condition or purchase price to learn
                            more about returns</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label class="text-silver fw-normal text-end">Showing your returns by: </label>
                                </div>
                                <div class="col">
                                    <select class="seller-dropdown px-2 py-0 bg-transparent border">
                                        <option value="this_month" selected>Category</option>
                                        @foreach($categoryList as $categories)
                                            <option value="{{$categories->id}}">{{Str::limit($categories->name, 5)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-5 ps-0">

                        </div>
                        <div class="col-md-7 border-top text-end px-0">
                            @if(!empty($categoryCount))
                                @foreach($categoryCount as $category)
                                        <?php $returnsOrdersArray[$category['id']][] = $category; ?>
                                @endforeach
                                @foreach($categoryCount as $key =>$category)
                                    @if($key <= 3)
                                        <?php if(isset($totalProducts[$category['id']])): ?>
                                            <?php $category_ids[$category['id']] = $category['id']; ?>
                                            <?php $categoryOrderArray[$category['name']] = [
                                                    'products_count' => count($returnsOrdersArray[$category['id']]).' of '.$totalProducts[$category['id']],
                                                    'products_percentage' => (count($returnsOrdersArray[$category['id']]) * 100) / $totalProducts[$category['id']]]; ?>
                                        <?php endif; ?>
                                    @endif
                                @endforeach

                                <?php $firstcount = 0;$totalProductsOther = 0; ?>
                            @endif
                            @if(!empty($categoryOrderArray))
                                <table class="table" style="border-collapse: collapse;">
                                    <thead class="text-black border-bottom-0">
                                        <tr>
                                            <td class="text-center border-bottom-0">Category</td>
                                            <td class="text-end border-bottom-0">Quantity</td>
                                            <td class="text-center border-bottom-0">%</td>
                                        </tr>
                                    </thead>
                                    <tbody class="border bg-silver">
                                        <?php arsort($categoryOrderArray); ?>
                                        <?php
                                        $checkOtherCategories = App\Http\Controllers\SellerhubController::otherCategories($category_ids);
                                        ?>
                                        @foreach($categoryOrderArray as $key => $categories)
                                            <tr>
                                                <td>{{$key}}</td>
                                                <td>{{$categories['products_count']}}</td>
                                                <td>{{number_format($categories['products_percentage'], 2)}}%</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>Other categories</td>
                                            <td>{{$checkOtherCategories}}</td>
                                            <td>3.46%</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="text-center text-silver" style="font-size: 15px;">Transaction period: {{date('M 01, Y', strtotime('-3 months')).' - '.date('M t, Y', strtotime('now'))}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="review-sales mt-4">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="mb-2 text-black fst-normal">Review your sales</h3>
                        <p class="text-black">Updated Jan 4 at 4:17 PST. We show sales and charges on the dates they occur. Amounts may not reflect latest sales.</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="#" class="text-black text-decoration-underline">Tell us what you think about this page</a>
                    </div>
                </div>

                <div class="border p-3">
                    <form id="report_generate">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="text-black">Sales:</label><br>
                                <select class="w-100 text-black seller-dropdown border">
                                    <option value="31">Last 31 days</option>
                                    <option value="now">Today</option>
                                    <option value="this_month">This month</option>
                                    <option value="last_month">Last month</option>
                                    <option value="this_quarter">This quarter</option>
                                    <option value="this_year">This year</option>
                                    <option value="last_year">Last year</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="text-black">Compared to:</label><br>
                                <select class="w-100 text-black seller-dropdown border">
                                    <option value="same">Same period prior months</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-seller">Generate Report</button>
                            </div>
                            <div class="col-md-1 text-start">
                                <button type="submit" class="p-0 pb-1 text-black">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="reports-third mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="text-black mb-2">Reports for Dec 5, 2023 - Jan 4, 2024</h3>
                            <p class="text-black">Compared to Nov 4, 2023 - Dec 4, 2023(31 days)</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="row justify-content-end align-items-center">
                                <div class="col-md-3">
                                    <button type="button" class="p-0 pb-1 text-black text-decoration-underline">Print report</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-seller-outline">Download &nbsp;&nbsp;<i class="fa fa-chevron-down"></i> </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="reports-sub ps-3" style="border-radius:20px;background-color: #F7F7F7;">
                        <div class="row">
                            <div class="col p-4 position-relative">
                                <h6 class="text-silver mb-4">Total sales (includes taxes) <small><i class="fa fa-info-circle"></i></small></h6>
                                <h4 class=text-black>$34,997.44</h4>
                                <p class="text-black mb-0"><i class="fa fa-angle-down"></i> <b class="text-black">35.7%</b> vs. prior time period</p>
                                <div style="border-right:2px solid #A1A1A1;height:70%;position: absolute;right:0;top:15%;"></div>
                            </div>
                            <div class="col p-4">
                                <h6 class="text-silver mb-4">Taxes and fees <small><i class="fa fa-info-circle"></i></small></h6>
                                <h4 class=text-black>$0.00</h4>
                                <p class="text-black mb-0">Collected by seller</p>
                            </div>
                            <div class="col p-4 position-relative">
                                <h6 class="text-silver mb-4"></h6>
                                <h4 class=text-black>$1,777.88</h4>
                                <p class="text-black mb-0">Collected by eBay</p>
                                <div style="border-right:2px solid #A1A1A1;height:70%;position: absolute;right:0;top:15%;"></div>
                            </div>
                            <div class="col p-4">
                                <h6 class="text-silver mb-4">Selling costs <small><i class="fa fa-info-circle"></i></small></h6>
                                <h4 class=text-black>$4,018.93</h4>
                                <b class="text-black mb-0">11.5% of your total sales</b>
                            </div>
                            <div class="col-md-3 p-0" style="background-color: #C5E5FB;border-top-right-radius: 20px;border-bottom-right-radius: 20px;">
                                <div class="p-3 h-100 mt-3">
                                    <p class="text-silver mb-0">Net&nbsp;sales&nbsp;(Net&nbsp;taxes&nbsp;and&nbsp;selling&nbsp;costs)&nbsp;<small><i class="fa fa-info-circle"></i></small></p>
                                    <h4 class="text-black mt-3">$29,200.63</h4>
                                    <p class="text-black mb-0"><i class="fa fa-angle-down"></i> <b class="text-black">35.1%</b> vs. prior time period</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="reports-sub ps-3 mt-4" style="border-radius:20px;background-color: #F7F7F7;">
                        <div class="row">
                            <div class="col p-4 position-relative">
                                <h6 class="text-silver mb-3">Quantity sold <small><i class="fa fa-info-circle"></i></small></h6>
                                <h4 class=text-black>579</h4>
                                <p class="text-black mb-0"><i class="fa fa-angle-down"></i> <b class="text-black">36.9%</b> vs. prior time period</p>
                                <div style="border-right:2px solid #A1A1A1;height:70%;position: absolute;right:0;top:15%;"></div>
                            </div>
                            <div class="col p-4 position-relative">
                                <h6 class="text-silver mb-3">Avg. sales price per item <small><i class="fa fa-info-circle"></i></small></h6>
                                <h4 class=text-black>$60.44</h4>
                                <p class="text-black mb-0"><i class="fa fa-angle-up"></i> <b class="text-black">1.9%</b> vs. prior time period</p>
                                <div style="border-right:2px solid #A1A1A1;height:70%;position: absolute;right:0;top:15%;"></div>
                            </div>
                            <div class="col p-4">
                                <h6 class="text-silver mb-3">Sales via Auction <small><i class="fa fa-info-circle"></i></small></h6>
                                <h4 class=text-black>$0.00</h4>
                                <p class="text-black mb-0"><b class="text-black">0.0%</b> vs. prior time period</p>
                            </div>
                            <div class="col p-4">
                                <h6 class="text-silver mb-3">Sales via Fixed price <small><i class="fa fa-info-circle"></i></small></h6>
                                <h4 class=text-black>$34,997.44</h4>
                                <p class="text-black mb-0"><i class="fa fa-angle-down"></i> <b class="text-black">35.7%</b> vs. prior time period</p>
                            </div>
                        </div>
                    </div>

                    <hr class="mt-4" style="background-color:#CECECE;height:3px;"/>

                    <div class="reports-selling border ps-3 mt-4" style="border-radius:20px;background-color: #F7F7F7;">
                        <div class="row">
                            <div class="col-md-4 p-4">
                                <h6 class="text-black mb-3">Selling costs</h6>
                                <h4 class=text-black>$4,018.93</h4>
                                <p class="text-black mb-0" style="font-size:14px;">11.5% of your total sales</p>
                                <p class="text-black mb-0" style="font-size:14px;"><i class="fa fa-angle-up"></i> 1.9% pts. vs. prior time period</p>
                            </div>
                            <div class="col p-4">
                                <table class="" style="border-collapse: collapse;">
                                    <thead class="text-black border-bottom">
                                        <tr>
                                            <th class="pt-0 pb-2 px-0 text-start border-bottom-0" style="text-transform: none">Breakdown</th>
                                            <th class="pt-0 pb-2 px-0 text-end border-bottom-0" style="text-transform: none">Amount</th>
                                            <th class="pt-0 pb-2 px-0 text-end border-bottom-0" style="text-transform: none">Percent of selling cost</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-black border-bottom">
                                        <tr>
                                            <td class="pb-0 px-0"><i class="fa fa-angle-down"></i> eBay fees</td>
                                            <td class="pb-0 px-0 text-end">$2,867.29</td>
                                            <td class="pb-0 px-0 text-end">71.3%</td>
                                        </tr>
                                        <tr>
                                            <td class="pt-0 px-0">Shipping lables <i class="fa fa-info-circle"></i></td>
                                            <td class="pt-0 px-0 text-end">$1,151.64</td>
                                            <td class="pt-0 px-0 text-end">28.7%</td>
                                        </tr>
                                    </tbody>
                                    <thead class="text-black">
                                        <tr>
                                            <th class="pt-2 px-0 text-start border-bottom-0" style="text-transform: none">Total selling costs <i class="fa fa-info-circle"></i></th>
                                            <th class="pt-2 px-0 text-end border-bottom-0" style="text-transform: none">$4,018.93</th>
                                            <th class="pt-2 px-0 text-end border-bottom-0" style="text-transform: none">100.0%</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="reports-funds mt-4">

                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="text-black">Your financial summary</h3>
                            <div class="p-3 bg-blue" style="height:200px;border-radius: 10px;">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="text-white mb-1" style="font-size:16px;">Your total funds</p>
                                        <h2 class="m-0 text-white">$2,083.16 &nbsp;<i class="fa fa-angle-right"></i> </h2>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <i class="text-white fa fa-question border" style="border-radius:50%;padding: 3px 7px;"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="payouts border mt-3" style="border-radius: 10px;">
                                <div class="border-bottom p-4">
                                    <p class="text-black fw-bold mb-1">Available funds</p>
                                    <p class="text-black fw-bold">$1,409.03 &nbsp;<i class="fa fa-angle-right"></i></p>
                                    <p class="text-black">Next schedule payout: Sat, Jan 6</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="border-end ps-4 py-3">
                                            <p class="text-black fw-bold mb-1">Processing</p>
                                            <p class="text-black fw-bold mb-0">$317.00 &nbsp;<i class="fa fa-angle-right"></i></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="ps-2 py-3">
                                            <p class="text-black fw-bold mb-1">On hold</p>
                                            <p class="text-black fw-bold mb-0">$357.13 &nbsp;<i class="fa fa-angle-right"></i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="" style="height:100%;">
                                <h3 class="text-black">Recent activity</h3>
                                <div class="recent-activity border" style="border-radius: 10px;height: 470px;overflow-y: scroll;overflow-x: hidden;">
                                    <div class="row align-items-top pt-3 border-bottom">
                                        <div class="col-md-3">
                                            <div class="p-4 pt-0">
                                                <p class="text-silver mb-0" style="font-size:14px;">Jan 5, 2024</p>
                                                <p class="text-silver mb-0" style="font-size:14px;">10:26:56 AM</p>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="p-2 pt-0">
                                                <p class="text-black mb-0" style="font-size:15px;"><b class="text-black">Shipping label</b> for order no. <a href="#" class="text-blue">24-11016-35038</a></p>
                                                <p class="text-black mb-0" style="font-size:15px;">USPS</p>
                                                <p class="text-black mb-0" style="font-size:15px;"><span class="activity-circle completed"></span> &nbsp;Completed</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="text-purple fw-bold mb-0" style="font-size: 14px;">-$3.90 &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right text-blue"></i> </p>
                                        </div>
                                    </div>
                                    <div class="row align-items-top pt-3 border-bottom">
                                        <div class="col-md-3">
                                            <div class="p-4 pt-0">
                                                <p class="text-silver mb-0" style="font-size:14px;">Jan 5, 2024</p>
                                                <p class="text-silver mb-0" style="font-size:14px;">10:26:56 AM</p>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="p-2 pt-0">
                                                <p class="text-black mb-0" style="font-size:15px;"><b class="text-black">Order</b> <a href="#" class="text-blue">24-11016-35038</a></p>
                                                <p class="text-black mb-0" style="font-size:15px;">HP G72-B60US, i3-M370 @2.4GHz, 2GB RAM, No HDD/OS/CADDY, *Bad Battery*</p>
                                                <p class="text-black mb-0" style="font-size:15px;"><span class="activity-circle processing"></span> &nbsp;Processing : to be completed on Jan 06</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="text-black fw-bold mb-0" style="font-size: 14px;">$32.16 &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right text-blue"></i> </p>
                                        </div>
                                    </div>
                                    <div class="row align-items-top pt-3 border-bottom">
                                        <div class="col-md-3">
                                            <div class="p-4 pt-0">
                                                <p class="text-silver mb-0" style="font-size:14px;">Jan 5, 2024</p>
                                                <p class="text-silver mb-0" style="font-size:14px;">10:26:56 AM</p>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="p-2 pt-0">
                                                <p class="text-black mb-0" style="font-size:15px;"><b class="text-black">Refund</b> for order number <a href="#" class="text-blue">24-11016-35038</a></p>
                                                <p class="text-black mb-0" style="font-size:15px;">Refund ID: <a href="#" class="text-blue">5126646261</a></p>
                                                <p class="text-black mb-0" style="font-size:15px;">Lot of 32 NEW Samsung Scb-2005N Analog Box Camera</p>
                                                <p class="text-black mb-0" style="font-size:15px;"><span class="activity-circle completed"></span> &nbsp;Completed</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="text-purple fw-bold mb-0" style="font-size: 14px;">-$8.13 &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right text-blue"></i> </p>
                                        </div>
                                    </div>
                                    <div class="row align-items-top pt-3 border-bottom">
                                        <div class="col-md-3">
                                            <div class="p-4 pt-0">
                                                <p class="text-silver mb-0" style="font-size:14px;">Jan 5, 2024</p>
                                                <p class="text-silver mb-0" style="font-size:14px;">10:26:56 AM</p>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="p-2 pt-0">
                                                <p class="text-black mb-0" style="font-size:15px;"><b class="text-black">Shipping label</b> for order no. <a href="#" class="text-blue">24-11016-35038</a></p>
                                                <p class="text-black mb-0" style="font-size:15px;">USPS</p>
                                                <p class="text-black mb-0" style="font-size:15px;"><span class="activity-circle completed"></span> &nbsp;Completed</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="text-purple fw-bold mb-0" style="font-size: 14px;">-$3.90 &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right text-blue"></i> </p>
                                        </div>
                                    </div>
                                    <div class="row align-items-top pt-3 border-bottom">
                                        <div class="col-md-3">
                                            <div class="p-4 pt-0">
                                                <p class="text-silver mb-0" style="font-size:14px;">Jan 5, 2024</p>
                                                <p class="text-silver mb-0" style="font-size:14px;">10:26:56 AM</p>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="p-2 pt-0">
                                                <p class="text-black mb-0" style="font-size:15px;"><b class="text-black">Shipping label</b> for order no. <a href="#" class="text-blue">24-11016-35038</a></p>
                                                <p class="text-black mb-0" style="font-size:15px;">USPS</p>
                                                <p class="text-black mb-0" style="font-size:15px;"><span class="activity-circle completed"></span> &nbsp;Completed</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="text-purple fw-bold mb-0" style="font-size: 14px;">-$3.90 &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right text-blue"></i> </p>
                                        </div>
                                    </div>
                                    <div class="row align-items-top pt-3 border-bottom">
                                        <div class="col-md-3">
                                            <div class="p-4 pt-0">
                                                <p class="text-silver mb-0" style="font-size:14px;">Jan 5, 2024</p>
                                                <p class="text-silver mb-0" style="font-size:14px;">10:26:56 AM</p>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="p-2 pt-0">
                                                <p class="text-black mb-0" style="font-size:15px;"><b class="text-black">Shipping label</b> for order no. <a href="#" class="text-blue">24-11016-35038</a></p>
                                                <p class="text-black mb-0" style="font-size:15px;">USPS</p>
                                                <p class="text-black mb-0" style="font-size:15px;"><span class="activity-circle completed"></span> &nbsp;Completed</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="text-purple fw-bold mb-0" style="font-size: 14px;">-$3.90 &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right text-blue"></i> </p>
                                        </div>
                                    </div>
                                    <div class="row align-items-top pt-3 border-bottom">
                                        <div class="col-md-3">
                                            <div class="p-4 pt-0">
                                                <p class="text-silver mb-0" style="font-size:14px;">Jan 5, 2024</p>
                                                <p class="text-silver mb-0" style="font-size:14px;">10:26:56 AM</p>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="p-2 pt-0">
                                                <p class="text-black mb-0" style="font-size:15px;"><b class="text-black">Shipping label</b> for order no. <a href="#" class="text-blue">24-11016-35038</a></p>
                                                <p class="text-black mb-0" style="font-size:15px;">USPS</p>
                                                <p class="text-black mb-0" style="font-size:15px;"><span class="activity-circle completed"></span> &nbsp;Completed</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="text-purple fw-bold mb-0" style="font-size: 14px;">-$3.90 &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right text-blue"></i> </p>
                                        </div>
                                    </div>
                                    <div class="row align-items-top pt-3 border-bottom">
                                        <div class="col-md-3">
                                            <div class="p-4 pt-0">
                                                <p class="text-silver mb-0" style="font-size:14px;">Jan 5, 2024</p>
                                                <p class="text-silver mb-0" style="font-size:14px;">10:26:56 AM</p>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="p-2 pt-0">
                                                <p class="text-black mb-0" style="font-size:15px;"><b class="text-black">Shipping label</b> for order no. <a href="#" class="text-blue">24-11016-35038</a></p>
                                                <p class="text-black mb-0" style="font-size:15px;">USPS</p>
                                                <p class="text-black mb-0" style="font-size:15px;"><span class="activity-circle completed"></span> &nbsp;Completed</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="text-purple fw-bold mb-0" style="font-size: 14px;">-$3.90 &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right text-blue"></i> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{url('public/assets/seller/chartjs/Chart.js')}}"></script>
    <script>
        var data1 = ['200', '50', '100', '75', '90', '145', '214', '218', '275', '175', '144', '172'];
        var data2 = ['100', '150', '130', '42', '45', '130', '134', '149', '123', '187', '234', '190'];

        function calculateFirst(i) {
            return (data1[i] / data2[i] * 100)
        }

        function calculateSecond(i) {
            return (data3[i] / data4[i] * 100)
        }


        var canvas = document.getElementById('myChart');
        var data = {
            labels: ['JAN','FEB','MAR','APR','JUN','JUL','AUG','SEP', 'OCT', 'NOV', 'DEC'],
            datasets: [{
                label: 'Last week',
                usePointStyle: true,
                data: data1,
                backgroundColor: '#52CDFF',
                datalabels: {
                    display: true,
                },
                pointStyle: 'circle',
            }, {
                label: 'This week',
                usePointStyle: true,
                data: data2,
                datalabels: {
                    display: true,
                    formatter: function(context, chart_obj) {
                        return isNaN(calculateFirst(chart_obj.dataIndex)) ? '' : calculateFirst(chart_obj.dataIndex)+ '%';
                    },
                },
                pointStyle: 'circle',
                backgroundColor: '#1F3BB3',
            }]
        };
        var option = {
            legend: {
                display: true,
            },
            tooltips: {
                enabled: true,
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                    },
                    scaleFontSize: 40,
                    scaleLabel: {
                        display: true,
                    },
                    ticks: {
                        max: 300,
                        min: 0,
                        stepSize: 100,
                        beginAtZero: true,
                        callback: function(value) {
                            return value
                        }
                    },
                }],
                xAxes: [{
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                    },
                    id: "bar-x-axis1",
                    stacked: true,
                    barThickness: 30,
                }, {
                    id: "bar-x-axis2",
                    stacked: true,
                    display: false,
                    barThickness: 10,
                }, {
                    id: "bar-x-axis3",
                    stacked: true,
                    barThickness: 30,
                    display: false
                }, {
                    id: "bar-x-axis4",
                    stacked: true,
                    display: false,
                    barThickness: 10,
                }, ],
            },
            plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'top'
                },
                legend: {
                    labels: {
                        usePointStyle: true,

                        pointStyle: 'circle'
                    },
                },
            }
        };

        var myBarChart = Chart.Bar(canvas, {
            data: data,
            options: option
        });

    </script>
@endsection