<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use SpatieLogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'name',
        'email',
        'dtID',
        'password',
        'first',
        'last',
        'api_token',
        'avatar',
        'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get a fullname combination of first_name and last_name
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Prepare proper error handling for url attribute
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->info) {
            return $this->info->avatar_url;
        }

        return asset(theme()->getMediaUrlPath().'avatars/blank.png');
    }
    public function initials(){
        $initials = explode(' ', $this->name);
        if (count($initials) >= 2) {
            return strtoupper(substr($initials[0], 0, 1) . substr(end($initials), 0, 1));
        }
    }
    public function generateToken(){
        $this->api_token = Str::random(60);
        $this->save();
    }
    public function promote(){
        $this->admin = 1;
        $this->save();
    }
    public function delete(){
        DB::table('users')->where('id', $this->id)->delete();

        //$this->delete();
    }

    /**
     * User relation to info model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }
}
