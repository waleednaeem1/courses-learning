<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Auth;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function invoices()
    {
        // $data['invoices'] = Events::whereDate('end_date' , '>=' , now())->where('status', 'Y')->get();
        return view('invoice.invoice');

    }
}