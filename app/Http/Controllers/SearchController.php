<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use GuzzleHttp\Cookie\CookieJar;

class SearchController extends Controller
{
    protected $endpoint = [
        'account'                         => 'https://www.instagram.com/{user}',
        'account_next_call'               => 'https://www.instagram.com/{user}/?max_id={max_id}',
        'account_json'                    => 'https://www.instagram.com/{user}/?__a=1',
        'account_json_next_call'          => 'https://www.instagram.com/{user}/?__a=1&max_id={max_id}',
        'account_media_json'              => 'https://instagram.com/graphql/query/?query_id=17888483320059182&id={user_id}&first=12',
        'account_media_json_next_call'    => 'https://instagram.com/graphql/query/?query_id=17888483320059182&id={user_id}&first=12&after={max_id}',
        'search_tags_json'                => 'https://www.instagram.com/explore/tags/{tag}/?__a=1',
        'search_tags_json_next_call'      => 'https://www.instagram.com/explore/tags/{tag}/?__a=1&max_id={max_id}',
        'search_all_tags_json'            => 'https://www.instagram.com/web/search/topsearch/?context=blended&query={keyword}&__a=1',
        'search_username_by_tagcode_json' => 'https://www.instagram.com/p/{code}/?tagged={tag}&__a=1',
    ];

    protected $custom_headers;
    protected $response;
    protected $id_next = null;


    public function __construct()
    {
        $this->cUrlOptionHandler();
    }
    public function search(Request $request)
    {
        $query = trim(request('query'));

        if (Str::startsWith($query, '@')) {
            $handle = Str::replaceFirst('@', '', $query);
            $this->fetchUser($handle);
        }
        if (Str::startsWith($query, '#')) {
            $hashtag = Str::replaceFirst('#', '', $query);
            $this->fetchHashTag($hashtag);
        }
        return $this->response;
    }
    protected function fetchUser($handle)
    {
        $url = "https://www.instagram.com/{$handle}/?__a=1";
        if ($this->id_next) {
            $url = "https://www.instagram.com/{$handle}/?__a=1&max_id={$this->id_next}";
            sleep(2);
        }
        //Log::debug("Search :: fetching {$url}");
        //$response = Http::withHeaders($this->custom_headers)->get($url);

        //$response = $response->json();

        $client = new Client();

        $dynamic_ip = '' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255);

        $cookieJar = CookieJar::fromArray([
            'sessionid' => '5403984220%3AS59ft1BZsXXvXP%3A17'
        ], '.instagram.com');

        $response = $client->get($url, [
            'cookies' => $cookieJar,
            "REMOTE_ADDR" => $dynamic_ip,
            "HTTP_X_FORWARDED_FOR" => $dynamic_ip
        ]);

        $body = $response->getBody();


        $response = json_decode($body->getContents(), true);



        $user = $response['graphql']['user'];
        $hasNext = false;

        if (!$this->id_next) {
            $this->response = [
                "type"  => "user",
                "id"    => $user["id"],
                "username" => $user["username"],
                "biography" => $user["biography"],
                "website"   => $user["external_url"],
                "name"   => $user["full_name"],
                "is_business_account"   => $user["is_business_account"],
                "is_joined_recently"    => $user["is_joined_recently"],
                "business_category_name"    => $user["business_category_name"],
                "overall_category_name"    => $user["overall_category_name"],
                "is_private" => $user['is_private'],
                "is_verified" => $user['is_verified'],
                "profile_pic_url" => $user['profile_pic_url'],
                "edge_followed_by"  => $user["edge_followed_by"]["count"],
                "edge_follow"  => $user["edge_follow"]["count"],
                "edge_owner_to_timeline_media" => $user["edge_owner_to_timeline_media"]["count"],
                "posts" => []
            ];
        }





        $this->id_next = $user["edge_owner_to_timeline_media"]['page_info']['end_cursor'];
        if (isset($user["edge_owner_to_timeline_media"]["edges"])) {
            foreach ($user["edge_owner_to_timeline_media"]["edges"] as $post) {
                $post = $post['node'];
                $instagram_post = [
                    "id"    => $post["id"],
                    "display_url"   => $post["display_url"],
                    "is_video"    => $post["is_video"],
                    "edge_media_to_caption"    => $post["edge_media_to_caption"]["edges"][0]["node"]["text"],
                    "edge_media_to_comment"    => $post["edge_media_to_comment"]["count"],
                    "comments_disabled"    => $post["comments_disabled"],
                    "edge_liked_by"    => $post["edge_liked_by"],
                    "edge_media_preview_like"    => $post["edge_media_preview_like"],
                ];
                $this->response["posts"][] = $instagram_post;
            }

            //$this->fetchUser($handle);
        }
        $this->id_next = null;
    }
    protected function fetchHashTag($keyword, $next = null)
    {
        $url = "https://www.instagram.com/explore/tags/{$keyword}/?__a=1";
        if ($next) {
            $url = "https://www.instagram.com/explore/tags/{$keyword}/?__a=1&&max_id={$next}";
        }
        // $response = Http::withHeaders($this->custom_headers)->get($url);
        // $response = $response->json();

        $client = new Client();

        $dynamic_ip = '' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255);

        $cookieJar = CookieJar::fromArray([
            'sessionid' => '5403984220%3AS59ft1BZsXXvXP%3A17'
        ], '.instagram.com');

        $response = $client->get($url, [
            'cookies' => $cookieJar,
            "REMOTE_ADDR" => $dynamic_ip,
            "HTTP_X_FORWARDED_FOR" => $dynamic_ip
        ]);

        $body = $response->getBody();


        $response = json_decode($body->getContents(), true);



        $hashtag = $response['graphql']['hashtag'];

        $this->response = [
            "type"  => "tag",
            "name" => $hashtag["name"],
            "profile_pic_url" => $hashtag["profile_pic_url"],
            "edge_hashtag_to_related_tags" => $hashtag["edge_hashtag_to_related_tags"],
            "edge_hashtag_to_media_count" => $hashtag["edge_hashtag_to_media"]["count"],
            "edge_hashtag_to_media" => $hashtag["edge_hashtag_to_media"],
            "edge_hashtag_to_top_posts" => $hashtag['edge_hashtag_to_top_posts'],

        ];
    }

    protected function cUrlOptionHandler()
    {
        $dynamic_ip = '' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255);
        $sessionid = '5403984220%3AS59ft1BZsXXvXP%3A17';
        $http_curl_headers = array("REMOTE_ADDR: {$dynamic_ip}", "HTTP_X_FORWARDED_FOR: {$dynamic_ip}", "Cookie: sessionid={$sessionid}");
        $this->custom_headers = $http_curl_headers;
    }
}
