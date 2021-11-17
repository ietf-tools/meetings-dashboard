<?php

namespace App\Console\Commands;

use App\Models\MeetingInfo;
use Illuminate\Console\Command;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;

class ParticipantCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ParticipantCount:cron';

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
        // Get Online Participants
        $onlineParticipants = Participant::where('status', 1)->where('hide', 0)->where('meetingID', MeetingInfo::activeMeeting())->get();
        $this->info('Participants Online: '.count($onlineParticipants));

        // Update Participant Count Table

        $pct = DB::table('pct'.MeetingInfo::activeMeeting());
        $pct->insert([
            'pCount' => count($onlineParticipants),
        ]);

    }
}
