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
</style>
<table width="100%">
    <tr>
        <td>
            <h3>Invoice number</h3>
            <p style="text-transform: uppercase;color:#A2A2A2;">{{$randomstring}}</p>
        </td>
        <td style="text-align: right;vertical-align: baseline">
            <h1 style="margin-bottom:0;">Tax invoice</h1>
            <?php
            $explode_date = explode('-', $dates);
            ?>
            <p>{{date('M d, Y', strtotime($explode_date[1]))}}</p>
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td>
            <p style="font-size:18px;color:#a2a2a2;margin-bottom:20px;">This document is not a request for payment. You do not need to pay the total current invoice<br>amount shown.</p>
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td>
            <h3 style="margin-bottom:10px;">Marketplace Entity Fee</h3>
            <p style="font-size:18px;color:#919191;margin-bottom:20px;">Collected eBay Inc.</p>
        </td>
        <td style="text-align: right;">
            {{$dates}}
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td>
            <h2>Fees in USD ($)</h2>
        </td>
    </tr>
</table>
<table width="100%" class="taxes" style="text-align: center;">
    <thead style="border-bottom:1px solid #000;padding-bottom:10px;">
        <tr>
            <th style="text-align: left">Type</th>
            <th>Net</th>
            <th>Tax(%)</th>
            <th>Tax amount</th>
        </tr>
    </thead>
    <tbody>
        <tr style="color:#919191;font-size:18px;">
            <td style="text-align: left;">
                Final values fees
            </td>
            <td>
                $3,046.64
            </td>
            <td>
                -
            </td>
            <td>
                -
            </td>
        </tr>
        <tr style="color:#919191;font-size:18px;">
            <td style="text-align: left;">
                Insertion fees
            </td>
            <td>
                $114.25
            </td>
            <td>
                -
            </td>
            <td>
                -
            </td>
        </tr>
        <tr style="color:#919191;font-size:18px;">
            <td style="text-align: left;">
                Shipping fees
            </td>
            <td>
                $126.69
            </td>
            <td>
                -
            </td>
            <td>
                -
            </td>
        </tr>
        <tr style="color:#919191;font-size:18px;">
            <td style="text-align: left;">
                International fees
            </td>
            <td>
                $23.41
            </td>
            <td>
                -
            </td>
            <td>
                -
            </td>
        </tr>
        <tr style="color:#919191;font-size:18px;">
            <td style="text-align: left;">
                Subscription and onetime<br>fees
            </td>
            <td>
                $21.95
            </td>
            <td>
                -
            </td>
            <td>
                -
            </td>
        </tr>
        <tr>
            <td style="color:#919191;font-size:18px;text-align: left;">
                Credits
            </td>
            <td style="color:#189361;">
                -$389.34
            </td>
            <td>
                -
            </td>
            <td>
                -
            </td>
        </tr>
        <tr>
            <td style="text-align: left;">
                <h3>Subtotal</h3>
            </td>
            <td>
                $2943.60
            </td>
            <td>
                -
            </td>
            <td>
                <b>$0.00</b>
            </td>
        </tr>
    </tbody>
</table>

<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="26%">
            <h3>Taxes</h3>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="26%">
            <h4 style="color:#919191;">Total non-taxable amount</h4>
        </td>
        <td style="vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="10%">
            <h4 style="color:#4B4B4B;">$2,943.60</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="28%">
            <h4 style="color:#919191;">Total taxable amount at 0%</h4>
        </td>
        <td style="vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="10%">
            <h4 style="color:#4b4b4b;">$0.00</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="30%">
            <h4>Total current invoice in USD</h4>
        </td>
        <td style="vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="10%">
            <h4>$2,943.60</h4>
        </td>
    </tr>
</table>
