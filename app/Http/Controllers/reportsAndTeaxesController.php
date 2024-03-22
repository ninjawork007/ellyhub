<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\userOrders;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class reportsAndTeaxesController extends Controller
{
    public function getreportsAndTaxes($filter = '', $from = '', $to = ''){
        $request = Request();

        if($filter == ''){
            $created_at_start = date('Y-m-01');
            $created_at_end = date('Y-m-d');

            $current = 'Current month';
        }

        if($filter == 'last-week'){

            $previous_week = strtotime("-1 week +1 day");

            $start_week = strtotime("last sunday midnight",$previous_week);
            $end_week = strtotime("next saturday",$start_week);

            $start_week = date("Y-m-d",$start_week);
            $end_week = date("Y-m-d",$end_week);

            $created_at_start = $start_week;
            $created_at_end = $end_week;

            $current = 'Last week';
        }

        if($filter == 'last-month'){

            $start_week = date("Y-m-01", strtotime('last month'));
            $end_week = date("Y-m-d",strtotime('last day of last month'));

            $created_at_start = $start_week;
            $created_at_end = $end_week;

            $current = 'Last month';
        }

        if($filter == 'last-year'){

            $year = date('Y') - 1; // Get current year and subtract 1
            $start = mktime(0, 0, 0, 1, 1, $year);
            $end = mktime(0, 0, 0, 12, 31, $year);

            $created_at_start = date('Y-m-d', $start);
            $created_at_end = date('Y-m-d', $end);

            $current = 'Last year';
        }

        if($filter == 'custom'){
            $created_at_start = $from;
            $created_at_end = $to;

            $current = 'Custom';
        }

        $ordersTotal = userOrders::whereBetween('created_at', [$created_at_start, $created_at_end])->where('userid', $request->session()->get('userid'))->groupBy('order_id')->get()->sum('after_discount_paid_by_customer');

        $refundTotal = Refund::select('orders.after_discount_paid_by_customer','orders.product_quantity','orders.product_price', 'refunds.*')
            ->groupBy('orders.order_id')
            ->leftJoin('orders', 'orders.order_id', 'refunds.order_id')
            ->where(['orders.userid' => $request->session()->get('userid')])
            ->whereBetween('refunds.created_at', [$created_at_start, $created_at_end])
            ->get();

        return view('reports-taxes', compact('ordersTotal', 'refundTotal', 'created_at_start', 'created_at_end', 'current', 'filter'));
    }

    public function downloadReport($filter = '', $from = '', $to = ''){
        $request = Request();

        if($filter == ''){
            $created_at_start = date('Y-m-01');
            $created_at_end = date('Y-m-d');
        }

        if($filter == 'last-week'){

            $previous_week = strtotime("-1 week +1 day");

            $start_week = strtotime("last sunday midnight",$previous_week);
            $end_week = strtotime("next saturday",$start_week);

            $start_week = date("Y-m-d",$start_week);
            $end_week = date("Y-m-d",$end_week);

            $created_at_start = $start_week;
            $created_at_end = $end_week;
        }

        if($filter == 'last-month'){

            $start_week = date("Y-m-01", strtotime('last month'));
            $end_week = date("Y-m-d",strtotime('last day of last month'));

            $created_at_start = $start_week;
            $created_at_end = $end_week;
        }

        if($filter == 'last-year'){

            $year = date('Y') - 1; // Get current year and subtract 1
            $start = mktime(0, 0, 0, 1, 1, $year);
            $end = mktime(0, 0, 0, 12, 31, $year);

            $created_at_start = date('Y-m-d', $start);
            $created_at_end = date('Y-m-d', $end);
        }

        if($filter == 'custom'){
            $created_at_start = $from;
            $created_at_end = $to;
        }

        $ordersTotal = userOrders::whereBetween('created_at', [$created_at_start, $created_at_end])->where('userid', $request->session()->get('userid'))->groupBy('order_id')->get();

        $filename = public_path("orders.csv");
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('Order id', 'Order total', 'Name', 'Order creation date'));

        foreach($ordersTotal as $row) {
            fputcsv($handle, array($row->order_id, '$'.number_format($row->order_total, 2), $row->name, $row->created_at));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download(public_path('orders.csv'), 'orders.csv', $headers);
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

        $dompdf->stream("tax_pdf.pdf", array("Attachment" => false));
        $dompdf->stream();
        //return view('pdfs/tax_pdf');
    }

    public function downloadFinancialReport($dates){
        $dompdf = new Dompdf();

        $randomstring = $this->generateRandomString(30);
        $dompdf->loadHtml(view('pdfs/financial_report', compact('dates', 'randomstring')));

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        //$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
        $dompdf->stream($dates);
        return view('pdfs/financial_report', compact('dates'));
    }

    public function downloadTaxInvoices($dates){
        $dompdf = new Dompdf();

        $randomstring = $this->generateRandomString(13);
        $dompdf->loadHtml(view('pdfs/tax_invoices', compact('dates', 'randomstring')));

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        //$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
        $dompdf->stream($dates);
        return view('pdfs/tax_invoices', compact('dates'));
    }

    public function downloadPaymentsPdf($filter, $from = '', $to = ''){

        if($filter == ''){
            $created_at_start = date('Y-m-01');
            $created_at_end = date('Y-m-d');
        }

        if($filter == 'last-week'){

            $previous_week = strtotime("-1 week +1 day");

            $start_week = strtotime("last sunday midnight",$previous_week);
            $end_week = strtotime("next saturday",$start_week);

            $start_week = date("Y-m-d",$start_week);
            $end_week = date("Y-m-d",$end_week);

            $created_at_start = $start_week;
            $created_at_end = $end_week;
        }

        if($filter == 'last-month'){

            $start_week = date("Y-m-01", strtotime('last month'));
            $end_week = date("Y-m-d",strtotime('last day of last month'));

            $created_at_start = $start_week;
            $created_at_end = $end_week;
        }

        if($filter == 'last-year'){

            $year = date('Y') - 1; // Get current year and subtract 1
            $start = mktime(0, 0, 0, 1, 1, $year);
            $end = mktime(0, 0, 0, 12, 31, $year);

            $created_at_start = date('Y-m-d', $start);
            $created_at_end = date('Y-m-d', $end);
        }

        if($filter == 'custom'){
            $created_at_start = $from;
            $created_at_end = $to;
        }

        $request = Request();

        $refundTotal = Refund::select('orders.after_discount_paid_by_customer','orders.product_quantity','orders.product_price', 'refunds.*')
            ->groupBy('orders.order_id')
            ->leftJoin('orders', 'orders.order_id', 'refunds.order_id')
            ->where(['orders.userid' => $request->session()->get('userid')])
            ->whereBetween('refunds.created_at', [$created_at_start, $created_at_end])
            ->get();

        $ordersTotal = userOrders::whereBetween('created_at', [$created_at_start, $created_at_end])->where('userid', $request->session()->get('userid'))->groupBy('order_id')->get()->sum('after_discount_paid_by_customer');
        $dompdf = new Dompdf();

        $randomstring = $this->generateRandomString(13);

        $view = view('pdfs/payments_pdf', compact('created_at_start', 'created_at_end', 'ordersTotal', 'randomstring', 'refundTotal'));

        $dompdf->loadHtml($view);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
        $dompdf->stream($created_at_start.'-'.$created_at_end);
        return $view;
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
