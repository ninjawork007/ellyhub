<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\userOrders;
use Dompdf\Dompdf;
use Illuminate\Http\Request;


class reportsAndTeaxesController extends Controller
{
    public function getreportsAndTaxes($filter = ''){
        $request = Request();

        if($filter == ''){
            $ordersTotal->where('created_at', '>=', date('Y-m-01'));
        }
        $ordersTotal = userOrders::where('userid', $request->session()->get('userid'))->groupBy('order_id')->get()->sum('after_discount_paid_by_customer');

        $refundTotal = Refund::select('orders.after_discount_paid_by_customer','orders.product_quantity', 'refunds.*')->where(['orders.userid' => $request->session()->get('userid')])
            ->groupBy('orders.order_id')
            ->leftJoin('orders', 'orders.order_id', 'refunds.order_id')
            ->get();

        dd($ordersTotal);

        return view('reports-taxes', compact('ordersTotal', 'refundTotal'));
    }

    public function getTaxInvoices(){
        return view('tax-invoice');
    }

    public function getFinancialStatements(){
        return view('finanical-statements');
    }

    public function downloadTaxPdf(){
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('pdfs/tax_pdf'));

        $dompdf->setPaper('A2', 'portrait');

        $dompdf->render();

        $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
        $dompdf->stream();
        //return view('pdfs/tax_pdf');
    }
}
