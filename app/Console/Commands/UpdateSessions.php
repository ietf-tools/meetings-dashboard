<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Session;
use App\Models\MeetingInfo;
use App\Models\MeetingParticipants;
use App\Models\Participant;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;

class UpdateSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateSessions:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
        {
            Log::info("Query Sessions - Initiated");
            $this->info('UpdateSessions:cron Command is Initiating');
            $wgSessions = Session::where('meetingNumber', MeetingInfo::activeMeeting())->whereBetween('startDate', [Carbon::yesterday(), Carbon::today()])->get();
            foreach($wgSessions as $wg){
                $this->info('Updating Session Participants in '.$wg->title);
                $response = Http::withToken(MeetingInfo::where('active', 1)->first()->meetechoAPIToken)->
                    acceptJson()->
                    get(MeetingInfo::where('active', 1)->first()->meetechoAPIURL.'rooms/'.$wg->title.'/accesses');
                if($response->failed()){
                    $this->error('No Respsone from MeetEcho API Host');
                }
                if($response->serverError()){
                    $this->info('MeetEcho API Needs a Break');
                }
                if($response->clientError()){
                    $this->error('No Respsone from MeetEcho API Host');
                }
                if($response->successful()){
                    $this->info('API Query Successful');
                    $sessionParticipants = $response->collect();
                    $this->info('----- Session '.$wg->title.': ----');
                    //print_r($sessionParticipants);
                    foreach($sessionParticipants as $sp){
                        $mpTableEntry = MeetingParticipants::where('sessionID', $wg->id)->where('participantID', Participant::where('dataTrackerID', $sp['user_id'])->where('meetingID', MeetingInfo::activeMeeting())->first()->id)->where('meetingID', MeetingInfo::activeMeeting())->first();
                        if(array_key_exists('email', $sp)){
                            if(array_key_exists('leave_time', $sp)){
                                $checkRow = DB::table('wg_'.$wg->id.'_'.MeetingInfo::activeMeeting())->where('dataTrackerID', $sp['user_id'])->where('login', $sp['join_time'])->where('logout', '')->first();
                                if($checkRow){
                                    $this->info('Updating Participant Logout Information for Participant: '.$sp['fullname']);
                                    $updateLogout = DB::table('wg_'.$wg->id.'_'.MeetingInfo::activeMeeting())->where('dataTrackerID', $sp['user_id'])->where('login', $sp['join_time'])->update([
                                        'logout' => $sp['leave_time']
                                    ]);
                                }else{
                                    $checkRow = DB::table('wg_'.$wg->id.'_'.MeetingInfo::activeMeeting())->where('dataTrackerID', $sp['user_id'])->where('login', $sp['join_time'])->where('logout', $sp['leave_time'])->first();
                                    if(!$checkRow){
                                        $addSP = DB::table('wg_'.$wg->id.'_'.MeetingInfo::activeMeeting())->insert([
                                            'wgID' => $wg->id,
                                            'wgDate' => $wg->startDate,
                                            'wgRole' => $sp['role'],
                                            'dataTrackerID' => $sp['user_id'],
                                            'login' => $sp['join_time'],
                                            'logout' => $sp['leave_time']
                                        ]);
                                        $this->info('Added Participant - '.$sp['fullname']);
                                    }
                                }
                            }else{
                                $checkRow = DB::table('wg_'.$wg->id.'_'.MeetingInfo::activeMeeting())->where('dataTrackerID', $sp['user_id'])->where('login', $sp['join_time'])->first();
                                if(!$checkRow){
                                    $addSP = DB::table('wg_'.$wg->id.'_'.MeetingInfo::activeMeeting())->insert([
                                        'wgID' => $wg->id,
                                        'wgDate' => $wg->startDate,
                                        'wgRole' => $sp['role'],
                                        'dataTrackerID' => $sp['user_id'],
                                        'login' => $sp['join_time'],
                                    ]);
                                    $this->info('Added Participant - '.$sp['fullname']);
                                }
                            }
                            if(!$mpTableEntry){
                                $this->info('Participant not in Meeting Participants Table --- Adding');
                                $addToMPTable = MeetingParticipants::create([
                                    'sessionID' => $wg->id,
                                    'participantID' => Participant::where('dataTrackerID', $sp['user_id'])->where('meetingID', MeetingInfo::activeMeeting())->first()->id,
                                    'meetingID' => MeetingInfo::activeMeeting(),
                                ]);
                                $pSessionCount = Participant::where('dataTrackerID', $sp['user_id'])->where('meetingID', MeetingInfo::activeMeeting())->first();

                                if(!$pSessionCount->sessionCount){
                                    $pSessionCount->sessionCount = 1;
                                    $pSessionCount->save();
                                }else{
                                    $pSessionCount->increment('sessionCount');
                                    $pSessionCount->save();
                                }

                                $mTotalParticipants = Session::where('id', $wg->id)->first();
                                if(!$mTotalParticipants->totalParticipantCount){
                                    $mTotalParticipants->totalParticipantCount = 1;
                                    $mTotalParticipants->save();
                                }else{
                                    $mTotalParticipants->increment('totalParticipantCount');
                                    $mTotalParticipants->save();
                                }

                                $currSessionParticipants = Session::where('id', $wg->id)->first();

                                if($currSessionParticipants->participants){
                                    $cspArray = explode(',', $currSessionParticipants->participants);
                                    $nspArray = array_push($cspArray, Participant::where('dataTrackerID', $sp['user_id'])->where('meetingID', MeetingInfo::activeMeeting())->first()->id);
                                    $nspString = implode(',', $cspArray);
                                }else{
                                    $nspString = Participant::where('dataTrackerID', $sp['user_id'])->where('meetingID', MeetingInfo::activeMeeting())->first()->id;
                                }

                                DB::table('meeting_sessions')->where('id', $wg->id)->update([
                                    'participants' => $nspString,
                                ]);
                                //break;
                            }else{
                                $this->info('Participant has already been added to Meeting Participants Table --- Skipping');
                            }
                        }
                    }
                }
                sleep(5);
                //break;
            }
        }
}
