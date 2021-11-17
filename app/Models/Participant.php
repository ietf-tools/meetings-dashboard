<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\MeetingInfo;
use App\Models\MeetingParticipants;

class Participant extends Model
{
    use HasFactory;
    protected $fillable = ['username', 'email', 'dataTrackerID', 'uniHash', 'ipv4Address', 'geo', 'city', 'state', 'country', 'geoCode', 'lastGeoUpdate', 'login', 'logout', 'status', 'hide', 'meetingID', 'sessionCount', 'hackathonOnly', 'hackathonParticipant'];

    public static function onlineCount(){
        $m = MeetingInfo::where('active', 1)->first();
        $online = DB::table('participants')->where('status', 1)->where('meetingID', $m->meetingNumber)->where('hide', 0)->get();
        $oc = $online->count();
        return $oc;
    }
    public static function totalCount(){
        $m = MeetingInfo::where('active', 1)->first();
        $total = DB::table('participants')->where('meetingID', $m->meetingNumber)->where('hide', 0)->get();
        $tc = $total->count();
        return $tc;
    }
    public static function currentParticipants(){
        $m = MeetingInfo::where('active', 1)->first();
        $p = DB::table('participants')->where('meetingID', $m->meetingNumber)->where('hide', 0)->get();
        return $p;
    }

    public static function currentRegionData(){
        $m = MeetingInfo::where('active', 1)->first();
        $regions = array_count_values(Participant::where('meetingID', $m->meetingNumber)->where('hide', 0)->pluck('geo')->toArray());
        arsort($regions);
        $j = array();
        foreach($regions as $region => $val){
            $r['name'] = $region;
            $r['value'] = $val;
            array_push($j, $r);
        }
        return $j;
    }
    public static function allRegionData($m){
        //$m = MeetingInfo::where('active', 1)->first();
        $regions = array_count_values(Participant::where('meetingID', $m)->where('hide', 0)->where('hackathonOnly', 0)->pluck('geo')->toArray());
        arsort($regions);
        $j = array();
        foreach($regions as $region => $val){
            $r['name'] = $region;
            $r['value'] = $val;
            array_push($j, $r);
        }
        return $j;
    }
    public static function participantDays($id){
        $ps = MeetingParticipants::where('participantID', $id)->get();
        $s = array();
        foreach ($ps as $a){
            $b['day'] = Session::where('id', $a->sessionID)->pluck('startDate')->first();
            array_push($s, $b);
        }
        $su = array_unique(array_column($s, 'day'));
        return $su;
    }
    public static function participantSessions($id){
        $s = MeetingParticipants::where('participantID', $id)->get();
        return $s;
    }

    public static function participantSessionLogins($sessions){
        $i = 0;
        $meetingLogins = array();
        foreach($sessions as $s ){
            $meetingLogins[$i] = DB::table('wg_'.$s->sessionID.'_'.$s->meetingID)->where('dataTrackerID', '=', Participant::where('id', $s->participantID)->pluck('dataTrackerID')->first())->get();
            $i++;
        }
        if($meetingLogins){
            return $meetingLogins;
        }else{
            return null;
        }
    }

    public static function removeParticipantPii(){
        $participants = Participant::whereNotNull('ipv4Address')->get();
        foreach($participants as $p){
            $p->ipv4Address = '';
            $p->city = '';
            $p->state = '';
            $p->save();
        }
    }

    public static function concurrentSessionLogins(){
        $i = 0;
        $m = MeetingInfo::where('active', 1)->first();
        $sessionList = Session::where('meetingNumber', $m->meetingNumber)->where('show', 0)->orderBy('startDate')->get();
        $sDate = $sessionList->unique('startDate')->all();
        $sDateTime = array();
        $sDateTimeParticipants = array();
        $sParticipants = array();
        foreach($sDate as $sd){
            $sDateTime[$sd->startDate] = $sessionList->where('startDate', $sd->startDate)->unique('startTime')->pluck('startTime');
        }
        foreach($sDateTime as $d => $val){
            foreach($val as $t)
                $sDateTimeParticipants[$d.'_'.$t] = $sessionList->where('startDate', $d)->where('startTime', $t)->pluck('participants')->all();
        }
        foreach($sDateTimeParticipants as $p => $value){
            foreach($value as $a){
                $parts[$p] = array_count_values(explode(',',$a));
            }
        }
        foreach($parts as $p){
            if($p > 1){
                $i + 1;
            }
        }
        return $i;
    }
}
