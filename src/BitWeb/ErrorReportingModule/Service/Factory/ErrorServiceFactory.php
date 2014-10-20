<?php
/**
 * Created by PhpStorm.
 * User: tobre
 * Date: 14.04.14
 * Time: 14:20
 */

namespace BitWeb\ErrorReportingModule\Service\Factory;

use BitWeb\ErrorReporting\Service\ErrorService;
use BitWeb\ErrorReportingModule\ErrorEventManager;
use BitWeb\Mail\Configuration;
use BitWeb\Mail\Service\MailService;
use Zend\Mail\Transport\Sendmail;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ErrorServiceFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        if (!isset($config['mail']) || !isset($config['mail']['smtpOptions'])) {
            $transport = new Sendmail();
        } else {
            $transport = new Smtp(new SmtpOptions($config['mail']['smtpOptions']));
        }

        if (isset($config['mail']) && isset($config['mail']['smtpOptions'])) {
            unset($config['mail']['smtpOptions']);
        }

        $configuration = new Configuration($config['mail']);
        $mailService = new MailService($transport, $configuration);
        $errorEventManager = new ErrorEventManager();
        $mailService->setEventManager($errorEventManager);

        $service = new ErrorService(new \BitWeb\ErrorReporting\Configuration($serviceLocator->get('Config')['error_reporting']));
        $service->setEventManager($errorEventManager);
        $service->setEvent(MailService::EVENT_SEND_MAIL);
        return $service;
    }

}