<?php

namespace Api;

use Admin\Model\UserTable;
use Zend\Mvc\MvcEvent;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $sharedEvents = $e->getApplication()->getEventManager()->getSharedManager();
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractRestfulController', 'dispatch', function($e) {
                    $result = $e->getResult();
                    $result->setTerminal(true);
                    if ($result instanceof \Zend\View\Model\ViewModel) {

                        //$result->setTerminal($e->getRequest()->isXmlHttpRequest());
                    }
                });
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Admin\Model\UserTable' => function($sm) {
                    $doctrineEntityManager = $sm->get('Doctrine\ORM\EntityManager');
                    $table = new UserTable($doctrineEntityManager);
                    return $table;
                },
            ),
        );
    }

//    public function onBootstrap(MvcEvent $e)
//    {
//        $application = $e->getApplication();
//        $em = $application->getEventManager();
//        //handle the dispatch error (exception) 
//        $em->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));
//        //handle the view render error (exception) 
//        $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER_ERROR, array($this, 'handleError'));
//    }
//
//    public function handleError(MvcEvent $e)
//    {
//        $exception = $e->getParam('exception');
//
//        $e->getResponse()->setStatusCode(500);
//        $e->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'application/json');
//        $e->getResponse()->setContent(json_encode(array('error' => $exception->getMessage())));
//
//        $e->getResponse()->send();
//        die();
//    }
//    public function onBootstrap(MvcEvent $mvcEvent)
//    {
//        // under this module check for application name and api key
//        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
//        $sharedEvents = $mvcEvent->getApplication()->getEventManager()->getSharedManager();
//        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function(MvcEvent $mvcEvent) use ($serviceManager) {
//                    $em = $serviceManager->get('doctrine.entitymanager.orm_default');
//                    $key = $mvcEvent->getRouteMatch()->getParam('key', null);
//                    $app = $mvcEvent->getRouteMatch()->getParam('app', null);
//                    $response = $mvcEvent->getResponse();
//                    $response->setStatusCode(403);
//                    if (!$key || !$app)
//                        return $response;
//                    $apiKeys = $em->getRepository('Application\Entity\ApiKeys');
//                    $apiKey = $apiKeys->findOneBy(array('appName' => $app));
//                    if (!$apiKey)
//                        return $response;
//                    elseif ($apiKey->key !== $key)
//                        return $response;
//                });
//    }
}
