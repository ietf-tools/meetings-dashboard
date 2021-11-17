<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MeetingInfo;

class ParticipantCount extends Model
{
    use HasFactory;
    protected $table;
        public function __construct()
        {
            $m = MeetingInfo::activeMeeting();
            $t = "pct" . $m;
            $this->table = $t;
        }
    protected $fillable = ['pCount', 'check_time'];
}
