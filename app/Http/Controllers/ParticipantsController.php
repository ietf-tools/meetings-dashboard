<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\DataTables\Participants\SingleParticipantDataTable;
use App\DataTables\Participants\FullParticipantsDataTable;
use App\Models\MeetingParticipants;

class ParticipantsController extends Controller
{
    //
    public function index(FullParticipantsDataTable $dataTable)
    {
        return $dataTable->render('pages.participants.index');
    }
    public function participant($id)
    {
        $s = MeetingParticipants::where('participantID', $id)->get();
        $p = Participant::where('id', $id)->first();
        $d = Participant::where('dataTrackerID', $p->dataTrackerID);
        return view('pages.participants.participant', ['s' => $s,'p' => $p, 'd' => $d]);
    }

    public function hide($id){
        $p = Participant::where('id', $id)->first();
        $p->hide = 1;
        $p->save();
        return redirect()->back();
    }

}
