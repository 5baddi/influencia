<?php

namespace App\Http\Controllers;

use App\Models\LinkVisit;
use App\Models\ShortLink;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Request;
use ipinfo\ipinfo\IPinfo;

class ShortLinkController extends Controller
{
    /**
     * Agent extrator
     *
     * @var \Jenssegers\Agent\Agent
     */
    private $agent;

    public function __construct(Agent $agent)
    {
        // Init
        $this->agent = $agent;
    }

    /**
     * Redirect from short code to original link
     *
     * @param string $code
     */
    public function shortenLink(string $code)
    {
        // Find link
        $shortedLink = ShortLink::where('code', $code)->first();
        if(is_null($shortedLink) || $this->agent->isRobot())
            abort(404);

        // Get statistics
        if(!is_null(Request::ip())){
            $shortLinkID = $shortedLink->id;
            $ip = Request::ip();
            $visit = LinkVisit::where('ip', $ip)->whereDate('created_at', Carbon::today())->latest()->first();

            // Init data
            $data = [
                'is_mobile'             =>  $this->agent->isMobile(),
                'device'                =>  $this->agent->device(),
                'os'                    =>  $this->agent->platform(),
                'os_version'            =>  $this->agent->version($this->agent->platform()),
                'browser'               =>  $this->agent->browser(),
                'browser_version'       =>  $this->agent->version($this->agent->browser()),
            ];

            // IP lookup
            if($ip !== '127.0.0.1'){
                $ipLookup = new IPinfo(env('IPINFOIO_TOKEN'));
                $ipInfo = $ipLookup->getDetails($ip);

                $data = array_merge($data, [
                    'country_code'  =>  $ipInfo->country,
                    'country_name'  =>  $ipInfo->country_name,
                    'city_name'     =>  $ipInfo->city,
                    'zip_code'      =>  $ipInfo->postal ?? null,
                    'referer'       =>  Request::server('HTTP_REFERER')
                ]);
            }

            // Create new record or update exists one
            if(is_null($visit)){
                $data = array_merge($data, [
                    'ip'            =>  $ip,
                    'short_link_id' =>  $shortLinkID,
                ]);
                LinkVisit::create($data);
            }else{
                $data = array_merge($data, [
                    'views'     =>  $visit->views + 1
                ]);
                $visit->update($data);
            }
        }

        return redirect($shortedLink->link);
    }
}
