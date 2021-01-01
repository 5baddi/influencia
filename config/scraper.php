<?php

return [
    'version'   =>  '0.4.1',
    'support'   =>  env('SUPPORT_EMAIL'),
    'usd2eur'   =>  env('USD2EUR'),
    'fbcost_perimpressions'    =>  env('FBCOSTPERIMPRESSIONS'),
    'proxy'     =>  [
        'ip'    =>  env('MAIN_PROXY_IP'),
        'port'  =>  env('MAIN_PROXY_PORT'),
        'protocol'  =>  env('MAIN_PROXY_PROTOCOL'),
    ],
    'shortlink' =>  [
        'length'    =>  env('SHORTLINK_LENGTH')
    ],
    'youtube'   =>  [
        'key'   =>  env('YOUTUBE_KEY')
    ]
];