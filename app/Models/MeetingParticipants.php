<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingParticipants extends Model
{
    use HasFactory;
    protected $table = 'meeting_participants';
    protected $fillable = [
        'sessionID',
        'participantID',
        'meetingID',
    ];


}
