<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Session;
use App\Models\MeetingInfo;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;


class QuerySessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'QuerySessions:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Query Sessions from MeetEcho API';

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
        $this->info('QuerySessions:cron Command is Initiating');
        $response = Http::withToken(MeetingInfo::where('active', 1)->first()->meetechoAPIToken)->
            acceptJson()->
            get(MeetingInfo::where('active', 1)->first()->meetechoAPIURL.'/rooms');

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
            $sessions = $response->collect();

            //dd($sessions);
            foreach($sessions as $s){
                $startDateCarbon = new Carbon($s['start_date']);

                $sessionPresent = Session::where('title', $s['session_name'])->where('meetingNumber', MeetingInfo::activeMeeting())->first();
                if($sessionPresent){
                    $this->info('Session for: '.$sessionPresent->parent.' -- Already Present');
                    $this->info('Checking for Participants Table --- ');
                    $sessionParticipantsTableName = 'wg_'.$sessionPresent->id.'_'.MeetingInfo::activeMeeting();
                    if(!Schema::hasTable($sessionParticipantsTableName)){
                        $this->info('Session Participant Table Not Present -- Creating Table: '.$sessionParticipantsTableName);
                        $sPT = Schema::create($sessionParticipantsTableName, function(Blueprint $table){
                            $table->increments('id');
                            $table->integer('wgID');
                            $table->date('wgDate');
                            $table->string('wgRole');
                            $table->integer('dataTrackerID');
                            $table->dateTime('login');
                            $table->dateTime('logout')->nullable();
                        });
                    }
                }
                else{
                    // Get API Response Variables as PHP Strings

                    //Get Parent
                    $p = explode('_', $s['session_name']);
                    $parent = $p[0];

                    //Get Description

                    if(array_key_exists('description', $s)){
                        $description = $s['description'];
                    }else{
                        $description = '';
                    }

                    $this->info('Session: '.$s['session_name'].' -- Not Present -- Adding');
                    $sess = Session::create([
                            'title' => $s['session_name'],
                            'parent' => $parent,
                            'startDate' => $startDateCarbon->toDateString(),
                            'endDate' => $startDateCarbon->addMinutes($s['duration'])->toDateString(),
                            'description' => $description,
                            'startTime' => $startDateCarbon->toTimeString(),
                            'endTime' => $startDateCarbon->addMinutes($s['duration'])->toTimeString(),
                            'meetingNumber' => MeetingInfo::activeMeeting(),
                            'totalParticipantCount' => 0,

                    ]);
                    $sessionParticipantsTableName = 'wg_'.$sess->id.'_'.MeetingInfo::activeMeeting();
                    if(!Schema::hasTable($sessionParticipantsTableName)){
                        $this->info('Session Participant Table Not Present -- Creating Table: '.$sessionParticipantsTableName);
                        $sPT = Schema::create($sessionParticipantsTableName, function(Blueprint $table){
                            $table->increments('id');
                            $table->integer('wgID');
                            $table->date('wgDate');
                            $table->string('wgRole');
                            $table->integer('dataTrackerID');
                            $table->dateTime('login');
                            $table->dateTime('logout')->nullable();
                        });
                    }
                    //break;
                }
            }
        }
    }
}
