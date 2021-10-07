<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application server platform
    |--------------------------------------------------------------------------
    |
    | This value is used when project installed in Shared Hosting with no access of
    | supervisor or any process monitoring tools. Installation on the cloud/vps/on-premise
    | are not required for this setting.
    |
    */
    'shared_hosting' => [
        'enabled' => env('SHARED_HOSTING_ENABLED', false),
    ],
];
