<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class FormatHelper
{
    /**
     * Format number to thousands
     * 
     * @param double $number
     * @return string
     */
    public static function thousands($number) : string
    {

        if($number > 1000){
            $x = round($number);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];
            
            return $x_display;
        }
    
        return $number;
    }

    /**
     * Parse array keys with ASCII code
     * 
     * @param Illuminate\Support\Collection $collection
     * @return Illuminate\Support\Collection
     */
    public static function parseArrayASCIIKey(Collection $collection) : Collection
    {
        $data = new Collection();

        // Parse Ascii code from keys
        $collection->map(function($value, $key) use ($data){
            $parsedKey = preg_replace('/[\x00-\x1F\x7F\*]/u', '', $key);
            // if($parsedKey === 'medias')
            //     return;

            $data->put($parsedKey, $value);
        });

        return $data;
    }

    /**
     * Extract short code from instagram post link
     * 
     * @param string $link
     * @return null|string
     */
    public static function extractInstagarmShortCode(string $link) : ?string
    {
        // Init 
        $match = [];

        // Extract short code
        preg_match("/^(?:https?:\/\/)?(?:www\.)?(?:instagram\.com.*\/p\/)([\d\w\-_]+)(?:\/)?(\?.*)?$/", $link, $match);

        return isset($match[1]) ? $match[1] : null;
    }
    
    /**
     * Extract all hashtags from text
     * 
     * @param string $text
     * @return array
     */
    public static function extractHashTags(string $text) : array
    {
        // Init 
        $matches = [];

        // Extract short code
        preg_match_all("/#(\\w+)/", $text, $matches);
        
        return isset($matches[1]) ? $matches[1] : [];
    }
}