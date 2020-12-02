<?php

return [
    'version'   =>  '0.3.0',
    'support'   =>  env('SUPPORT_EMAIL'),
    'usd2eur'   =>  env('USD2EUR'),
    'fbcost_perimpressions'    =>  env('FBCOSTPERIMPRESSIONS'),
    'instagram' =>  [
        'username'  =>  env('INSTAGRAM_ACCOUNT'),
        'password'  =>  env('INSTAGRAM_PASSWORD'),
    ],
    'proxy'     =>  [
        'ip'    =>  env('MAIN_PROXY_IP'),
        'port'  =>  env('MAIN_PROXY_PORT'),
        'protocol'  =>  env('MAIN_PROXY_PROTOCOL'),
    ],
    'imap'      =>  [
        'server'    =>  env('IMAP_SERVER'),
        'port'      =>  env('IMAP_PORT'),
        'email'     =>  env('IMAP_EMAIL'),
        'password'  =>  env('IMAP_PASSWORD'),
    ],
    'shortlink' =>  [
        'length'    =>  env('SHORTLINK_LENGTH')
    ]
];