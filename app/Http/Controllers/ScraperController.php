<?php

namespace App\Http\Controllers;

use App\Influencer;
use App\Services\InstagramScraper;
use Unirest\Request;
use InstagramScraper\Instagram;
use Illuminate\Support\Collection;
use InstagramScraper\Exception\InstagramNotFoundException;

class ScraperController extends Controller
{
    public function instagramByUsername($username, InstagramScraper $instagram)
    {
        try{
            $account = $instagram->byUsername($username);

            return response()->success("Account fetched successfully for Instagram account @" . $username, $account);
        }catch(InstagramNotFoundException $ex){
            return response()->error($ex->getMessage());
        }
    }

    public function instagramById(int $id)
    {

    }

    public function instagramMedias(Influencer $influencer, InstagramScraper $instagram)
    {
        // Fetch medias
        $medias = $instagram->getMedias($influencer);

        return response()->success("Medias fetched successfully for Instagram account @" . $influencer->username, $medias[12]);
    }
}
