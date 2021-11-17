<?php

namespace App\Console\Commands;

use App\Models\MeetingParticipants;
use Illuminate\Console\Command;
use App\Models\Participant;

class UpdateMeetingParticipantsID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateMeetingParticipantsID:cron';

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
        $p = Participant::where('meetingID', 112)->get();
        $mPs = MeetingParticipants::where('meetingID', 112)->get();

        foreach($mPs as $mp){
            $pID = $p->where('dataTrackerID', $mp->participantID)->first();
            $this->info('User: '.$pID->username.' will be updated with ID: '.$pID->id.' from DataTracker ID: '.$mp->participantID);
            $mp->participantID = $pID->id;
            $mp->save();
            $this->info('User: '.$pID->username.' Participant ID was Updated');

        }
    }
}
