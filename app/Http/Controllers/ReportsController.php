<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    //
    public function index(){
        return view('pages.reports.index');
    }

    public function test(){
        return view('pages.reports.test');
    }
}
