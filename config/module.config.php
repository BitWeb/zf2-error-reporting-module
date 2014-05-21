<?php
return array(
    'error_reporting' => array(
        'subject' => '[Errors][your-app-id-here]',
        'emails' => array(),
        'from_address' => 'you@domian.com',
        'ignore404' => false,
        'ignoreBot404' => false,
        'botList' => array(
            'AhrefsBot',
            'bingbot',
            'Ezooms',
            'Googlebot',
            'Mail.RU_Bot',
            'YandexBot',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'BitWeb\ErrorReporting\Service\ErrorService' => 'BitWeb\ErrorReportingModule\Service\Factory\ErrorServiceFactory',
        )
    )
);
