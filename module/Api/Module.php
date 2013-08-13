<?php

namespace Api;

use Admin\Model\UserTable;

class Module
{

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

}
