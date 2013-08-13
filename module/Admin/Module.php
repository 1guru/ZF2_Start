<?php

namespace Admin;

use Admin\Model\UserTable;
use Admin\Model\UserRoleTable;

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

    public function onBootstrap($e)
    {
        $em = $e->getApplication()->getEventManager();

        $events = $em->getSharedManager();
        $events->attach('ZfcUser\Form\Register', 'init', function($e) {
                    $form = $e->getTarget();
                    $form->add(array(
                        'name' => 'first_name',
                        'options' => array(
                            'label' => 'First Name',
                        ),
                        'attributes' => array(
                            'type' => 'text'
                        ),
                    ));

                    $form->add(array(
                        'name' => 'last_name',
                        'options' => array(
                            'label' => 'Last Name',
                        ),
                        'attributes' => array(
                            'type' => 'text'
                        ),
                    ));
                });
//        $events->attach('ZfcUser\Form\RegisterFilter', 'init', function($e) {
//                    $filter = $e->getTarget();
//                    // Do what you please with the filter instance ($filter)
//                });

        $events->attach('ZfcUser\Service\User', 'register', function($e) {
                    $user = $e->getParam('user');  // User account object
                    $form = $e->getTarget();  // Form object

                    $sm = $form->getServiceManager();

                    $guestRole = $sm->get('Admin\Model\UserRoleTable')->getDefaultRole();
                    $user->addRole($guestRole);
                });

        $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER, function($e) {

                    $flashMessenger = new \Zend\Mvc\Controller\Plugin\FlashMessenger();

                    if ($flashMessenger->hasSuccessMessages()) {
                        $e->getViewModel()->setVariable('successMessages', $flashMessenger->getSuccessMessages());
                    }
                });
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
                'Admin\Model\UserRoleTable' => function($sm) {
                    $doctrineEntityManager = $sm->get('Doctrine\ORM\EntityManager');
                    $table = new UserRoleTable($doctrineEntityManager);
                    return $table;
                },
            ),
        );
    }

}
