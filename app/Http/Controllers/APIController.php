<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\MeetingInfo;

class APIController extends Controller
{
    //
    public function countryData(){
        $m = MeetingInfo::where('active', 1)->first();
        $countries = Participant::where('meetingID', $m->meetingNumber)->where('hide', 0)->pluck('geoCode')->toArray();

        return array_count_values($countries);
    }
    public function regionData(){
        $m = MeetingInfo::where('active', 1)->first();
        $regions = array_count_values(Participant::where('meetingID', $m->meetingNumber)->where('hide', 0)->pluck('geo')->toArray());
        arsort($regions);
        $j = array();

        //return $regions;
        foreach($regions as $region => $val){
            $r['name'] = $region;
            $r['value'] = $val;
            array_push($j, $r);
        }
        return response()->json($j);
    }
}
