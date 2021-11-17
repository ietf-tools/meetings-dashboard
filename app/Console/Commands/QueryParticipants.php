<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Participant;
use App\Models\MeetingInfo;
use Illuminate\Support\Facades\Http;
use ipinfo\ipinfo\IPinfo;
use Illuminate\Support\Facades\Log;

class QueryParticipants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queryparticipants:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Query Full List of Participants (Unique) from MeetEcho';

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
        Log::info("Query Participants - Initiated");
        $this->info('QueryParticipants:cron Command is Initiating');
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
            foreach($users as $u => $value){
                //dd($u);
                if(count($value) <= 1){
                    $last = $value->first();
                }else{
                    $last = $value->last();
                }
                if(Participant::where('dataTrackerID', $last['user_id'])->where('meetingID', MeetingInfo::activeMeeting())->first()){
                    $this->info('User: '.$last['fullname'].' already exists');
                }else{
                    if(array_key_exists('email', $last)){
                        //dd($u);
                        $this->info('User: '.$last['fullname'].' is not in database -- Adding');
                        if(array_key_exists('email', $last)){
                            $email = $last['email'];
                        }else{
                            $email = 'Unknown Email -'.$last['user_id'];
                        }
                        $ipInfo = new IPinfo(env('IPINFO_SECRET'));
                        if(array_key_exists('ip', $last)){
                            $pIPInfo = $ipInfo->getDetails($last['ip']);
                            //dd($pIPInfo);
                            if(!$pIPInfo->country_name){
                                $city = 'Unknown City';
                                $state = 'Unknown State';
                                $pGeo = 'Unknown';
                                $country = 'UNK';
                                $geocode = 'Unknown GeoCode';
                            }else{
                                if(!$pIPInfo->city){
                                    $city = 'Unknown City';
                                }else{
                                    $city = $pIPInfo->city;
                                }
                                if($pIPInfo->region){
                                    $state = $pIPInfo->region;
                                }else{
                                    $state = 'Unknown State';
                                }
                                if($pIPInfo->country_name){
                                    $pGeo = $this->countrytocontinent($pIPInfo->country);
                                    $country = $pIPInfo->country_name;
                                }else{
                                    $country = 'UNK';
                                    $pGeo = 'Unknown';
                                }
                                if($pIPInfo->country){
                                    $geocode = $pIPInfo->country;
                                }else{
                                    $geocode = 'Unknown GeoCode';
                                }
                            }
                        }
                        $newParticipant = Participant::create([
                            'username'      => $last['fullname'],
                            'email'         => $email,
                            'dataTrackerID' => $last['user_id'],
                            'uniHash'       => $last['user_id'].'-'.MeetingInfo::activeMeeting(),
                            'ipv4Address'   => $last['ip'],
                            'meetingID'     => MeetingInfo::activeMeeting(),
                            'city'          => $city,
                            'state'         => $state,
                            'country'       => $country,
                            'geoCode'       => $geocode,
                            'geo'           => $pGeo,
                            'status'        => 1,
                        ]);
                        if(!$newParticipant){
                            $this->error('User already in Database');
                        }
                        $this->info('User: '.$last['fullname'].' added to Participants Table');
                    }else{
                        $this->info('User does not have an email address skipping');
                    }
                }
            }
            //return $response->body();
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
