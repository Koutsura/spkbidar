<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['https://ukmbidar.decadev.tech/'],

    'allowed_origins' => ['https://ukmbidar.decadev.tech/'], 

    'allowed_origins_patterns' => ['https://ukmbidar.decadev.tech/'],

    'allowed_headers' => ['https://ukmbidar.decadev.tech/'],

    'exposed_headers' => ['https://ukmbidar.decadev.tech/'],

    'max_age' => 3600,

    'supports_credentials' => true,

];
