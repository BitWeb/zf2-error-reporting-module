<?php
return array(
    'error_reporting' => array(
        'errorReportingLevel' => E_ALL,
        'subject' => '[Errors][your-app-id-here]',
        'emails' => array(),
        'from_address' => 'you@domain.com',
        'ignore404' => false,
        'ignoreBot404' => false,
        'bot_list' => array(
            'AhrefsBot',
            'bingbot',
            'Ezooms',
            'Googlebot',
            'Mail.RU_Bot',
            'YandexBot',
        ),
        'ignorablePaths' => array()
    ),
    'service_manager' => array(
        'factories' => array(
            'BitWeb\ErrorReporting\Service\ErrorService' => 'BitWeb\ErrorReportingModule\Service\Factory\ErrorServiceFactory',
        )
    )
);
