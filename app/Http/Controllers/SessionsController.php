<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\DataTables\Session\FullSessionsDataTable;
use App\DataTables\Session\SessionParticipantDataTable;

class SessionsController extends Controller
{
    //
    public function index(FullSessionsDataTable $dataTable)
    {
        //return \App\Models\Session::sessionParentList();
        return $dataTable->render('pages.sessions.index');
    }
    public function session(SessionParticipantDataTable $dataTable, $id)
    {
        $p = Session::where('id', $id)->first();
        $pageTitle = "Session: ".strtoupper($p->parent);
        $as = Session::where('parent', $p->parent)->where('meetingNumber', $p->meetingNumber)->get();
        //$dataTable = SessionParticipantDataTable($id);
        return view('pages.sessions.session')->with('pageTitle', $pageTitle)->with('as', $as);
    }

    public function hide($id){
        $s = Session::where('id', $id)->first();
        $s->show = 1;
        $s->save();
        return redirect()->back();
    }
}
