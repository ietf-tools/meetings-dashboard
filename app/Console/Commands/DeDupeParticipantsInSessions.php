<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Session;
use App\Models\MeetingInfo;

class DeDupeParticipantsInSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeDupeParticipantsInSessions:cron';

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
            $plu = array_unique($pl);
            $npl = implode(',', $plu);
            $m->participants = $npl;
            $m->save();
            $this->info('Session: '.$m->title.' participants have been updated with uniques! ----');
        }
    }
}
