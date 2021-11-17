<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MeetingInfo;
use App\Models\Session;
use App\Models\Participant;
use App\Models\MeetingParticipants;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class Report extends Model
{
    use HasFactory;

    public static function participantSessionCount1(){
        $m = MeetingInfo::where('show', 1)->limit(5)->orderBy('meetingNumber', 'desc')->get();
        $s = Session::where('show', 0)->where('parent', '!=', 'hackathon')->get();
        $p = Participant::where('hide', 0)->where('hackathonOnly', 0)->get();
        $psc = array();

        foreach($m as $a => $val){
            $psc['IETF-'.$val->meetingNumber] = array();
            $sess = $s->where('meetingNumber', $val->meetingNumber)->all();
            $parts = $p->where('meetingID', $val->meetingNumber)->all();
            $pit = array();
            foreach($parts as $n){
                $q = 1;
                foreach($sess as $id){
                    $z = explode(',', $id->participants);
                    if(in_array($n->dataTrackerID, $z)){
                        ++$q;
                    }else{
                        //echo "<br>";
                    }
                }
                array_push($pit, $q);
            }
            $u = array_count_values($pit);
            $c = count($u);
            //dd($u);
            $onlyOne = $u[1];
            $twoToFive = 0;
            $sixToTen = 0;
            $tenOrMore = 0;
            unset($u[1]);
            $i = 2;
            while($i <= 5){
                if(isset($u[$i])){
                    $twoToFive = $twoToFive + $u[$i];
                    unset($u[$i]);
                    $i++;
                }else{
                    $i++;
                }
            }
            while($i <= 10){
                if(isset($u[$i])){
                    $sixToTen = $sixToTen + $u[$i];
                    unset($u[$i]);
                    $i++;
                }else{
                    $i++;
                }
            }
            while($i <= $c ){
                if(isset($u[$i])){
                    $tenOrMore = $tenOrMore + $u[$i];
                    unset($u[$i]);
                    $i++;
                }else{
                    $i++;
                }
            }
            //$v = array($onlyOne, $twoToFive, $sixToTen, $tenOrMore);
            array_push($psc['IETF-'.$val->meetingNumber], $onlyOne);
            array_push($psc['IETF-'.$val->meetingNumber], $twoToFive);
            array_push($psc['IETF-'.$val->meetingNumber], $sixToTen);
            array_push($psc['IETF-'.$val->meetingNumber], $tenOrMore);
        }
        return $psc;
    }
    public static function participantSessionCount(){
        $meetings = MeetingInfo::where('show', 1)->limit(5)->orderBy('meetingNumber', 'desc')->get();
        $participants = Participant::where('hide', 0)->where('hackathonOnly', 0)->get();
        $sessionTable = MeetingParticipants::all()->toArray();

        $table = collect($sessionTable);
        $tableSorted = $table->sortBy('meetingID');
        //dd($tableSorted->values('participantID')->all());
        $z = array();
        foreach($meetings as $m){
            $mParts = $participants->where('meetingID', $m->meetingNumber);
            $mPMT = $tableSorted->where('meetingID', $m->meetingNumber)->countBy('participantID')->toArray();
            $u = array_count_values($mPMT);
            //dd($u);
            $z['IETF-'.$m->meetingNumber] = array();
            $c = count($u);
            //dd($u);
            $onlyOne = $u[1];
            $twoToFive = 0;
            $sixToTen = 0;
            $tenOrMore = 0;
            unset($u[1]);
            $i = 2;
            while($i <= 5){
                if(isset($u[$i])){
                    $twoToFive = $twoToFive + $u[$i];
                    unset($u[$i]);
                    $i++;
                }else{
                    $i++;
                }
            }
            while($i <= 10){
                if(isset($u[$i])){
                    $sixToTen = $sixToTen + $u[$i];
                    unset($u[$i]);
                    $i++;
                }else{
                    $i++;
                }
            }
            while($i <= $c ){
                if(isset($u[$i])){
                    $tenOrMore = $tenOrMore + $u[$i];
                    unset($u[$i]);
                    $i++;
                }else{
                    $i++;
                }
            }
            //$v = array($onlyOne, $twoToFive, $sixToTen, $tenOrMore);
            array_push($z['IETF-'.$m->meetingNumber], $onlyOne);
            array_push($z['IETF-'.$m->meetingNumber], $twoToFive);
            array_push($z['IETF-'.$m->meetingNumber], $sixToTen);
            array_push($z['IETF-'.$m->meetingNumber], $tenOrMore);
            //array_push($z['IETF-'.$m->meetingNumber], $u);
           // $parts = $participants->where('meetingID', $m->meetingNumber);
           // $ps = array();
           // foreach($parts as $p){
           //     $pms = $tableSorted->where('meetingID', $m->meetingNumber)->where('participantID', $p->dataTrackerID)->all();
           //     if(count($pms) != 0){
           //         $ps['Participant-'.$p->username] = array();
           //         array_push($ps['Participant-'.$p->username], count($pms));
           //     }//dd($pms);
            //}
        }
        return $z;
    }

}
