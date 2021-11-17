<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Participant;
use App\Models\MeetingInfo;
use Illuminate\Support\Facades\Http;
use ipinfo\ipinfo\IPinfo;

class UpdateParticipants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateParticipants:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the Participants from MeetEcho API';

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
        \Log::info("Update Participants - Initiated");
        $this->info('UpdateParticipants:cron Command is Initiating');
        $response = Http::withToken(MeetingInfo::where('active', 1)->first()->meetechoAPIToken)->
            acceptJson()->
            get(MeetingInfo::where('active', 1)->first()->meetechoAPIURL.'/accesses');

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
            $users = $response->collect()->groupBy('user_id');
            //dd($users);
            foreach($users as $u => $value){

                //dd($value);
                if(count($value) <= 1){
                    $last = $value->first();
                }else{
                    $last = $value->last();
                }
                $this->info('######----- Processing User: '.$last['fullname'].' -----######');
                $p = Participant::where('dataTrackerID', $last['user_id'])->
                        where('meetingID', MeetingInfo::activeMeeting())->
                        where('hide', 0)->first();
                if(!$p){
                    $mP = Participant::where('dataTrackerID', $last['user_id'])->where('meetingID', MeetingInfo::activeMeeting())->first();
                    if(!$mP){
                        $this->error("\t".'User '.$last['fullname'].' not in the Database');
                    }elseif($mP->hide == 1){
                        $this->error("\t".'User '.$last['fullname']. 'is hidden');
                    }
                }else{
                    $this->info("\t".'User '.$p->username.' is in the Database');
                    $this->info("\t".'DataTrackerID: '.$last['user_id']);
                    $this->info("\t".'DataTrackerID in DB: '.$p->dataTrackerID);
                    if(empty($p->login)){
                        $this->alert('Login for '.$p->username.' is Empty -- Updating');
                        $p->login = $last['join_time'];
                        $p->status = 1;
                        if(array_key_exists('leave_time', $last)){
                            $p->logout = $last['leave_time'];
                            $p->status = 0;
                        }
                        $p->ipv4Address = $last['ip'];
                        $ipInfo = new IPinfo(env('IPINFO_SECRET'));
                        $pIPInfo = $ipInfo->getDetails($last['ip']);
                        if(!$pIPInfo->country_name){
                            $p->city = 'Unknown City';
                            $p->state = 'Unknown State';
                            $p->country = 'UNK';
                            $p->geoCode = 'Unknown Country';
                            $pGeo = 'Unknown';
                            $p->geo = $pGeo;
                        }else{
                            if($pIPInfo->country_name){
                                $pGeo = $this->countrytocontinent($pIPInfo->country);
                            }else{
                                $pGeo = 'Unknown';
                            }
                            $p->city = $pIPInfo->city;
                            $p->state = $pIPInfo->region;
                            $p->country = $pIPInfo->country_name;
                            $p->geoCode = $pIPInfo->country;
                            $p->geo = $pGeo;
                        }
                        $p->save();
                    }else{
                        if($last['join_time'] > $p->login){
                            $this->alert("\t".'User has logged in again -- Updating');
                            $p->login = $last['join_time'];
                            $p->status = 1;
                            if($last['ip'] != $p->ipv4Address){
                                $p->ipv4Address = $last['ip'];
                                $ipInfo = new IPinfo(env('IPINFO_SECRET'));
                                $pIPInfo = $ipInfo->getDetails($last['ip']);
                                if(!$pIPInfo->country_name){
                                    $p->city = 'Unknown City';
                                    $p->state = 'Unknown State';
                                    $p->country = 'UNK';
                                    $p->geoCode = 'Unknown Country';
                                    $pGeo = 'Unknown';
                                    $p->geo = $pGeo;
                                }else{
                                    if($pIPInfo->country_name){
                                        $pGeo = $this->countrytocontinent($pIPInfo->country);
                                    }else{
                                        $pGeo = 'Unknown';
                                    }
                                    $p->city = $pIPInfo->city;
                                    $p->state = $pIPInfo->region;
                                    $p->country = $pIPInfo->country_name;
                                    $p->geoCode = $pIPInfo->country;
                                    $p->geo = $pGeo;
                                }
                            }
                            $p->save();
                            $this->info("\t".'User: '.$p->username.' Recently Logged On - Updated');
                        }
                        //-- Check for Leave Time in User Response and Process
                        if(array_key_exists('leave_time', $last)){
                            //-- Check if Leave Time is more recent than what's in DataBase
                            if($last['leave_time'] > $p->logout){
                                //-- If it is, update the time, and set `status` to 0 (Offline)
                                $p->logout = $last['leave_time'];
                                $p->status = 0;
                                $p->save();
                                $this->info("\t".'User '.$p->username.' -- Logged Off and Updated');
                            }elseif($last['leave_time'] == $p->logout){
                                //-- If it matches what's in Database skip to next User
                                if($p->status == 1){
                                    $p->status = 0;
                                    $p->save();
                                    $this->alert("\t".'User '.$p->username.' not marked as Logged Out -- Updating');
                                }elseif($p->status == 0){
                                    $p->status = 0;
                                    $p->save();
                                    $this->info("\t".'User '.$p->username.' already logged out. -- Not Updated');
                                    $this->info("\t".'User '.$p->username.' Last Login: '.$p->login);
                                    $this->info("\t".'User '.$p->username.' Last Logout: '.$p->logout);
                                    $this->info("\t".'User '.$p->username.' Current Status: '.$p->status);

                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function countrytocontinent($country){
        $continent = '';
        switch ($country){
            case 'DE':
            case 'GG':
            case 'VA':
            case 'HU':
            case 'IS':
            case 'IE':
            case 'IM':
            case 'IT':
            case 'JE':
            case 'LV':
            case 'LI':
            case 'LT':
            case 'LU':
            case 'MK':
            case 'MT':
            case 'MD':
            case 'MC':
            case 'ME':
            case 'NL':
            case 'NO':
            case 'RO':
            case 'RU':
            case 'RS':
            case 'SK':
            case 'SI':
            case 'ES':
            case 'SJ':
            case 'SE':
            case 'CH':
            case 'UA':
            case 'GB':
            case 'GI':
            case 'GR':
            case 'AX':
            case 'AL':
            case 'AD':
            case 'AT':
            case 'BA':
            case 'BY':
            case 'BE':
            case 'BG':
            case 'CZ':
            case 'DK':
            case 'EE':
            case 'HR':
            case 'FI':
            case 'FR':
            case 'FO':
            case 'PL':
            case 'PT':
            case 'SM':
            $continent = 'Europe';
            break;

            case 'GH':
            case 'DZ':
            case 'AO':
            case 'BJ':
            case 'BW':
            case 'BF':
            case 'BI':
            case 'CM':
            case 'CV':
            case 'CF':
            case 'TD':
            case 'KM':
            case 'CD':
            case 'CG':
            case 'CI':
            case 'DJ':
            case 'EG':
            case 'GQ':
            case 'ER':
            case 'ET':
            case 'GA':
            case 'GM':
            case 'GN':
            case 'GW':
            case 'KE':
            case 'LS':
            case 'LR':
            case 'LY':
            case 'MG':
            case 'MW':
            case 'ML':
            case 'MR':
            case 'MU':
            case 'YT':
            case 'MA':
            case 'MZ':
            case 'NA':
            case 'NE':
            case 'NG':
            case 'RE':
            case 'RW':
            case 'SH':
            case 'ST':
            case 'SN':
            case 'SC':
            case 'SL':
            case 'SO':
            case 'ZA':
            case 'SD':
            case 'SZ':
            case 'TZ':
            case 'TG':
            case 'TN':
            case 'UG':
            case 'EH':
            case 'ZM':
            case 'ZW':
            $continent = 'Africa';
            break;

            case 'AF':
            case 'AM':
            case 'AZ':
            case 'BH':
            case 'BD':
            case 'BT':
            case 'IO':
            case 'BN':
            case 'KH':
            case 'CN':
            case 'CX':
            case 'CC':
            case 'CY':
            case 'GE':
            case 'HK':
            case 'IN':
            case 'ID':
            case 'IR':
            case 'IQ':
            case 'IL':
            case 'JP':
            case 'JO':
            case 'KZ':
            case 'KP':
            case 'KR':
            case 'KW':
            case 'KG':
            case 'LA':
            case 'LB':
            case 'MO':
            case 'MY':
            case 'MV':
            case 'MN':
            case 'MM':
            case 'NP':
            case 'OM':
            case 'PK':
            case 'PS':
            case 'PH':
            case 'QA':
            case 'SA':
            case 'SG':
            case 'LK':
            case 'SY':
            case 'TW':
            case 'TJ':
            case 'TH':
            case 'TL':
            case 'TR':
            case 'TM':
            case 'AE':
            case 'UZ':
            case 'VN':
            case 'YE':
            $continent = 'Asia';
            break;

            case 'AU':
            case 'AS':
            case 'CK':
            case 'FJ':
            case 'PF':
            case 'GU':
            case 'KI':
            case 'MH':
            case 'FM':
            case 'NR':
            case 'NC':
            case 'NZ':
            case 'NU':
            case 'NF':
            case 'MP':
            case 'PW':
            case 'PG':
            case 'PN':
            case 'WS':
            case 'SB':
            case 'TK':
            case 'TO':
            case 'TV':
            case 'UM':
            case 'VU':
            case 'WF':
            $continent = 'Oceania';
            break;

            case 'AQ':
            case 'BV':
            case 'TF':
            case 'HM':
            case 'GS':
            $continent = 'Antarctica';
            break;

            case 'AI':
            case 'AW':
            case 'AG':
            case 'BS':
            case 'BB':
            case 'BZ':
            case 'BM':
            case 'CA':
            case 'KY':
            case 'VG':
            case 'CR':
            case 'CU':
            case 'DM':
            case 'DO':
            case 'SV':
            case 'GL':
            case 'GD':
            case 'GP':
            case 'GT':
            case 'HT':
            case 'HN':
            case 'JM':
            case 'MQ':
            case 'MX':
            case 'MS':
            case 'NI':
            case 'PA':
            case 'PR':
            case 'BL':
            case 'KN':
            case 'LC':
            case 'MF':
            case 'PM':
            case 'VC':
            case 'AN':
            case 'TT':
            case 'TC':
            case 'US':
            case 'VI':
            $continent = 'North America';
            break;

            case 'AR':
            case 'BO':
            case 'CL':
            case 'CO':
            case 'BR':
            case 'EC':
            case 'FK':
            case 'GF':
            case 'GY':
            case 'PY':
            case 'PE':
            case 'SR':
            case 'UY':
            case 'VE':
            $continent = 'South America';
            break;
        }
        return $continent;
    }
}
