<style>
    h1,h2,h3,h4,h5,h6,p{
        margin-top:0;
        margin-bottom:3px;
    }

    td{
        vertical-align: baseline;
    }
</style>
<table width="100%">
    <tr>
        <td>
            <h3>Statement number</h3>
            <p>{{$randomstring}}</p>
        </td>
        <td>
            <h1 style="margin-bottom:20px;">Financial statement</h1>
            <?php
                $explode_date = explode('-', $dates);
            ?>
            <p>Date range: {{date('m/d/y H:i A', strtotime($explode_date[0]))}} - {{date('m/d/y H:i A', strtotime($explode_date[1]))}} PST</p>
            <p>Generated: {{date('M d, Y', strtotime('now'))}}</p>
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td>
            <h2>Transaction summary</h2>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="22%">
            <h4>Opening funds <span style="color:#d0d0d0;">(on {{date('M d', strtotime($explode_date[0]))}})</span></h4>
        </td>
        <td style="width:50%;vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="10%">
            <h4>$2,927.68</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="22%">
            <h4>Orders <span style="color:#d0d0d0;">(Total minus fees)</span></h4>
        </td>
        <td style="width:50%;vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="10%">
            <h4>$31,952.56</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="35%">
            <h4>Claims <span style="color:#d0d0d0;">(Total net of fees and credits)</span></h4>
        </td>
        <td style="width:50%;vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="10%">
            <h4>-$2,014.37</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="40%">
            <h4>Refunds <span style="color:#d0d0d0;">(Total net of fees and credits)</span></h4>
        </td>
        <td style="width:50%;vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="13%">
            <h4>-$3,979.39</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="50%">
            <h4>Payment disputes <span style="color:#d0d0d0;">(Total net of fees and credits)</span></h4>
        </td>
        <td style="vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="10%">
            <h4>-$0.00</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="16%">
            <h4>Shipping lables</h4>
        </td>
        <td style="vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="12%">
            <h4>-$1,419.91</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="11%">
            <h4>Other fees</h4>
        </td>
        <td style="vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="12%">
            <h4>-$135.00</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="12%">
            <h4>Adjustment</h4>
        </td>
        <td style="vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="10%">
            <h4>$18.00</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="10%">
            <h4>Purchases</h4>
        </td>
        <td style="vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="10%">
            <h4>$0.0</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="9%">
            <h4>Charges</h4>
        </td>
        <td style="vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="10%">
            <h4>$0.0</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="9%">
            <h4>Payouts</h4>
        </td>
        <td style="vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="13%">
            <h4>-$25,965.66</h4>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="45%">
            <h3>Closing funds <span style="color:#d0d0d0;font-size:17px;">(Moving to next statement)</span></h3>
        </td>
        <td style="vertical-align: bottom">
            <div style="border:1px dotted #000;"></div>
        </td>
        <td width="10%" style="vertical-align: bottom">
            <h4 style="color:#1A905C">$1,383.91</h4>
        </td>
    </tr>
</table>