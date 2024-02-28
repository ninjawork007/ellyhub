<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class reportsAndTeaxesController extends Controller
{
    public function getreportsAndTaxes(){
        return view('reports-taxes');
    }
    public function getTaxInvoices(){
        return view('tax-invoice');
    }
    public function getFinancialStatements(){
        return view('finanical-statements');
    }
}
