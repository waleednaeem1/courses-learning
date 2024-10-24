<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Auth;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index()
    {
        $data['events'] = Events::whereDate('end_date' , '>=' , now())->where('status', 'Y')->get();
        return view('events.events',compact('data'));
    }
}