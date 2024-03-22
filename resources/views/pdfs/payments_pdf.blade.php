<style>
    h1,h2,h3,h4,h5,h6,p{
        margin-top:0;
        margin-bottom:3px;
    }

    td{
        vertical-align: baseline;
    }

    .taxes tbody:before {
        /* This doesn't work because of border-collapse */
        line-height:1em;
        content:".";
        color:white; /* bacground color */
        display:block;
    }

    p{font-size:13px;}

    .taxes tr:nth-child(even) {background-color: #f2f2f2;}

    .taxes tr td{padding:10px;}
</style>
<table width="100%">
    <tr>
        <td>

        </td>
        <td style="text-align: right;vertical-align: baseline">
            <h2 style="margin-bottom:10px;">Payments</h2>
            <p>Date range: {{date('M d, Y', strtotime($created_at_start))}} - {{date('M d, Y', strtotime($created_at_end))}}</p>
            <p>Generated: {{date('M d, Y', strtotime('now'))}}</p>
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td>
            <h3>Financial overview</h3>
        </td>
    </tr>
</table>

<table width="100%" class="taxes" cellspacing=0>
    <tr>
        <td>
            <p>Orders</p>
        </td>
        <td style="text-align: right;">
            <p>${{(!empty($ordersTotal)) ? number_format($ordersTotal, 2) : '0.00'}}</p>
        </td>
    </tr>
    <tr>
        <td>
            <p>Refunds</p>
        </td>
        <td style="text-align: right;">
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
            <p>${{number_format($price, 2)}}</p>
        </td>
    </tr>
    <tr>
        <td>
            <p>Expenses</p>
        </td>
        <td style="text-align: right;">
            $0.00
        </td>
    </tr>
    <tr>
        <td>
            <p>Net transfers</p>
        </td>
        <td style="text-align: right;">
            $0.00
        </td>
    </tr>
</table>

<hr style="margin-top:20px;margin-bottom:20px;height:2px;background-color: #000"/>

<table width="100%">
    <tr>
        <td>
            <h3>Transactions summary</h3>
        </td>
    </tr>
</table>

<table width="100%" class="taxes" cellspacing=0>
    <thead>
        <tr>
            <th style="text-align: left;">Orders</th>
            <th style="text-align: right;">Debits</th>
            <th style="text-align: right;">Credits</th>
            <th style="text-align: right;">Net</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: left;">
                <p>Subtotal</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
    </tbody>
</table>

<table width="100%" class="taxes" cellspacing=0 style="margin-top:30px;">
    <thead>
        <tr>
            <th style="text-align: left;">Refunds</th>
            <th style="text-align: right;">Debits</th>
            <th style="text-align: right;">Credits</th>
            <th style="text-align: right;">Net</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: left;">
                <p>Gross refunds</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;">
                <p>Gross claims</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;">
                <p>Gross payment disputes</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;">
                <p>Subtotal</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
    </tbody>
</table>

<table width="100%" class="taxes" cellspacing=0 style="margin-top:30px;">
    <thead>
        <tr>
            <th style="text-align: left;">Expenses</th>
            <th style="text-align: right;">Debits</th>
            <th style="text-align: right;">Credits</th>
            <th style="text-align: right;">Net</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: left;">
                <p>Fees</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;padding-left:20px;">
                <p>Advanced listing upgrade fees</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;padding-left:20px;">
                <p>Insertion fees</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;padding-left:20px;">
                <p>Other fees</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;padding-left:20px;">
                <p>Transaction fees</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;">
                <p>Shipping labels</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;">
                <p>Donations</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;">
                <p>Subtotal</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
            <td style="text-align: right;">
                <p>$0.00</p>
            </td>
        </tr>
    </tbody>
</table>