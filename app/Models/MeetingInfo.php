<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Participant;
use Carbon\CarbonPeriod;
use Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

class MeetingInfo extends Model
{
    use HasFactory;

    protected $table = 'MeetingInfo';

    protected $fillable = [
        'meetingNumber',
        'meetingCity',
        'meetingCountry',
        'meetingTZ',
        'startDate',
        'endDate',
        'hackStartDate',
        'hackEndDate',
        'active',
        'meetechoAPIURL',
        'meetechoAPIToken',
    ];

    public function deactivate(){
        $this->active = 0;
        $this->save();
    }

    public function activate(){
        $this->active = 1;
        $this->save();
        if(!Schema::hasTable('pct'.$this->meetingNumber)){
            $pct = Schema::create('pct'.$this->meetingNumber, function(Blueprint $table){
                $table->increments('id');
                $table->decimal('pCount', 0);
                $table->timestamp('check_time');
            });
            $seedPCT = DB::table('pct'.$this->meetingNumber)->insert([
                'check_time' => Carbon::now(),
                'pCount' => 0

            ]);
        }
    }

    public static function participantCount($id){
        $p = Participant::where('meetingID', $id)->where('hide', 0)->where('hackathonOnly', 0)->get();
        return $p;
    }

    public static function meetingDates($id){
        $m = MeetingInfo::where('id', $id)->first();
        $period = CarbonPeriod::create($m->startDate, $m->endDate);
        $dates = $period->toArray();
        return $dates;
    }

    public static function activeMeeting(){
        $m = MeetingInfo::where('active', 1)->pluck('meetingNumber')->first();
        return $m;
    }

}
