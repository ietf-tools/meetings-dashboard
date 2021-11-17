<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MeetingInfo;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;

class Session extends Model
{
    use HasFactory;

    protected $table = 'meeting_sessions';
    protected $fillable = ['title', 'meetingNumber', 'parent', 'description','show', 'startDate', 'endDate', 'startTime', 'endTime', 'totalParticipantCount'];

    public static function currentMeetingSessions(){

        $s = DB::table('meeting_sessions')->where('meetingNumber', MeetingInfo::activeMeeting())->where('show', 0)->orderBy('startTime')->get();
        return $s;
    }
    public static function todaysMeetingSessions(){
        $s = DB::table('meeting_sessions')->where('meetingNumber', MeetingInfo::activeMeeting())->where('show', 0)->where('startDate', date('Y-m-d'))->orderBy('startTime')->get();
        return $s;
    }
    public static function yesterdaysMeetingSessions(){
        $m = MeetingInfo::where('active', 1)->pluck('meetingNumber');
        $s = DB::table('meeting_sessions')->where('meetingNumber', $m)->where('show', 0)->where('startDate', date('Y-m-d', time() - 60 * 60 * 24))->orderBy('startTime')->get();
        return $s;
    }
    public static function currentMeetingSessionsByDay(){
        $m = MeetingInfo::where('active', 1)->first();
        $dates = MeetingInfo::meetingDates($m->id);
        //return $dates;
        $s = array();
        foreach($dates as $date){
            $d = $date->toDateString();
            $day = $date->format('l');
            $ds = DB::table('meeting_sessions')->where('startDate', $d)->where('show', 0)->orderBy('startTime')->get();
            if(count($ds) > 0){
                $s[$day] = array();
                $s[$day] = $ds;
            }
        }
        return $s;
    }
    public static function sessionParentList(){
        $m = MeetingInfo::where('active', 1)->pluck('meetingNumber');
        $s = DB::table('meeting_sessions')->where('meetingNumber', $m)->where('show', 0)->get();
        $t = $s->unique('parent');
        return $t;
    }
    public static function totalSessionParticipants($id){
        $s = Session::where('id', $id)->first();
        $ps = Session::where('parent', $s->parent)->where('meetingNumber', $s->meetingNumber)->get();

        $c = count($ps);
        //dd($c);
        if($c == 0){
            return 0;
        }elseif($c == 1){
            $count = array();
            $count = $ps[0]->totalParticipantCount;
            //dd($count);
            return $count;
        }else{
            $dtIDs = array();
            $t = array();
            foreach($ps as $d){
                $e = explode(',', $d->participants);
                array_push($dtIDs, $e);
            }
            foreach($dtIDs as $dt){
                $t = array_merge($t, $dt);
            }
            //dd($t);
            $v = array_unique($t);
            //dd($v);
            return $v;
        }
    }
}
