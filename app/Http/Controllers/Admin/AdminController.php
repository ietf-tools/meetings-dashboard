<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AdminUserDataTable;
use App\DataTables\Admin\MeetingInfoDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeetingInfo;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminUserDataTable $dataTable){
        return $dataTable->render('pages.admin.index');
    }

    public function systems(MeetingInfoDataTable $dataTable){
        return $dataTable->render('pages.admin.systems');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function promote($id, User $user){
        $user->find($id)->promote();
        return redirect()->back();

    }

    public function meetingActive($id, MeetingInfo $m){

        $d = $m->where('active', 1)->first();
        $d->deactivate();


        $a = $m->where('id', $id)->first();
        $a->activate();

        return redirect()->back();
    }
    public function addMeeting(Request $request){
        $m = MeetingInfo::create([
            'meetingNumber' => $request->meetingNumber,
            'meetingCity' => $request->meetingCity,
            'meetingCountry' => $request->meetingCountry,
            'meetingTZ' => $request->meetingTZ,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'hackStartDate' => $request->hackStartDate,
            'hackEndDate' => $request->hackEndDate,
        ]);
        return redirect()->back();
    }

    public function destroy($id){
        User::destroy($id);
        return redirect()->back();
    }

    public function meetingDestroy($id){
        MeetingInfo::destroy($id);
        return redirect()->back();
    }
    public function updateMeetEchoParams(Request $request){
        $url = $request->url;
        $token = $request->token;
        $m = MeetingInfo::where('active', 1)->first();

        $m->meetechoAPIURL = $url;
        $m->meetechoAPIToken = $token;
        $m->save();

        return redirect()->back()->withSuccess($token.','.$url);
    }

}

