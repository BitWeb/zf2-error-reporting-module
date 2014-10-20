<?php
/**
 * Created by PhpStorm.
 * User: tobre
 * Date: 14.04.14
 * Time: 13:19
 */

namespace BitWeb\ErrorReportingModule;

use BitWeb\ErrorReporting\Service\ErrorService;
use BitWeb\ErrorReportingModule\Exception\RouterNoMatchException;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\Mvc\MvcEvent;

class Module
{

    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array ($this, 'onError'), 50);
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, array ($this, 'onError'), 50);
        $eventManager->attach(MvcEvent::EVENT_FINISH, array ($this, 'onFinishAfterPostDispatch'));

        $locator = $event->getApplication()->getServiceManager();
        /* @var $errorService \BitWeb\ErrorReporting\Service\ErrorService */
        $errorService = $locator->get('BitWeb\ErrorReporting\Service\ErrorService');
        $errorService->startErrorHandling($event);
    }

    public function onError(MvcEvent $event) {
        // if error has been removed
        if ($event->isError() == false) {
            return;
        }

        $locator = $event->getApplication()->getServiceManager();
        /* @var $errorService \BitWeb\ErrorReporting\Service\ErrorService */
        $errorService = $locator->get('BitWeb\ErrorReporting\Service\ErrorService');

        $exception = $event->getParam('exception');
        $error = $event->getError();

        $stopPropagation = false;
        if ($exception instanceof \Exception) {
            $errorService->errors[] = $exception;
            if ($exception instanceof \PDOException) {
                $stopPropagation = true;
            }
        } elseif ($error != null) {
            $errorService->errors[] = new RouterNoMatchException(sprintf('%1$s, %2$s', $error, $event->getControllerClass()));
        }

        if ($stopPropagation) {
            $this->onFinishAfterPostDispatch($event);
        }

    }

    public function onFinishAfterPostDispatch(MvcEvent $event) {
        $locator = $event->getApplication()->getServiceManager();
        /* @var $errorService \BitWeb\ErrorReporting\Service\ErrorService */
        $errorService = $locator->get('BitWeb\ErrorReporting\Service\ErrorService');
        $errorService->endErrorHandling();
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../../config/module.config.php';
    }
}