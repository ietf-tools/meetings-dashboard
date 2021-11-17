<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Participant;

class ChangeRegionData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ChangeRegionData:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Region Data to new Format';

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
        $participants = Participant::all();
        foreach($participants as $p){
            $geo = $this->countrytocontinent($p->geoCode);
            if($geo){
                $p->geo = $geo;
                $p->save();
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
