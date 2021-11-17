<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MeetingInfo;
use App\Models\Session;


class UpdateParticipantCountInSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateParticipantCountInSessions:cron';

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
        $ms = Session::where('meetingNumber', MeetingInfo::activeMeeting())->get();
        foreach($ms as $m){
            $pl = explode(',', $m->participants);
            $pCount = count($pl);
            $m->totalParticipantCount = $pCount;
            $m->save();
            $this->info('Session: '.$m->title.' Total Participants Count has been updated with real numbers! ----');
        }
    }
}
