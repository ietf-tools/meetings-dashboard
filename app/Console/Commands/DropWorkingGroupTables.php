<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Session;
use App\Models\MeetingInfo;
use Illuminate\Support\Facades\DB;
use Schema;

class DropWorkingGroupTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DropWorkingGroupTables:cron';

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
        $currentSessions = Session::where('meetingNumber', MeetingInfo::activeMeeting())->get();
        foreach($currentSessions as $cs){
            Schema::dropIfExists('wg_'.$cs->id.'_'.MeetingInfo::activeMeeting());
            $this->info('Dropping Working Group Table for: '.$cs->title);
        }

    }
}
