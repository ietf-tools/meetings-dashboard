<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    //
    public function index(){
        return view('pages.monitoring.index');
    }
}
