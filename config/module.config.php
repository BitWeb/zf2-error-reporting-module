<?php
return [
    'error_reporting' => [
        'errorReportingLevel' => E_ALL,
        'subject' => '[Errors][your-app-id-here]',
        'emails' => [],
        'from_address' => 'you@domain.com',
        'ignore404' => false,
        'ignoreBot404' => false,
        'bot_list' => [
            'AhrefsBot',
            'bingbot',
            'Ezooms',
            'Googlebot',
            'Mail.RU_Bot',
            'YandexBot',
        ],
        'ignorablePaths' => []
    ],
    'service_manager' => [
        'factories' => [
            'BitWeb\ErrorReporting\Service\ErrorService' => 'BitWeb\ErrorReportingModule\Service\Factory\ErrorServiceFactory',
        ]
    ]
];
