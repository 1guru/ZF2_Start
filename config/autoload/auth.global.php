<?php

return array(
    'doctrine' => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                //'paths' => __DIR__ . '/../../module/UserAuth/src/UserAuth/Entity/',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Admin' => 'zfcuser_entity',
                ),
            ),
        ),
    ),
    'zfcuser' => array(
        // telling ZfcUser to use our own class
        'user_entity_class' => '\Admin\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
    ),
    'bjyauthorize' => array(
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'role_providers' => array(
            // using an object repository (entity repository) to load all roles into our ACL
            /* 'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
              'object_manager' => 'doctrine.entitymanager.orm_default',
              'role_entity_class' => '\Admin\Entity\UserRole',
              ), */
            'BjyAuthorize\Provider\Role\Config' => array(
                'guest' => array('children' =>
                    array('user' => array('children' =>
                            array('admin' => array())
                        )
                    )
                ),
            ),
        ),
        'guards' => array(
//        /* If this guard is specified here (i.e. it is enabled), it will block
//         * access to all controllers and actions unless they are specified here.
//         * You may omit the 'action' index to allow access to the entire controller
//         */
            'BjyAuthorize\Guard\Controller' => array(
                //array('controller' => 'index', 'action' => 'index', 'roles' => array('guest')),
                //array('controller' => 'index', 'action' => 'stuff', 'roles' => array('user')),
                // You can also specify an array of actions or an array of controllers (or both)
                // allow "guest" and "admin" to access actions "list" and "manage" on these "index",
                // "static" and "console" controllers
                /* array(
                  'controller' => array('index'),
                  'roles' => array('guest')
                  ), */
                array('controller' => 'DoctrineORMModule\Yuml\YumlController', 'roles' => array('admin')),
                array('controller' => 'zfcuser', 'roles' => array('guest')),
                array('controller' => 'Admin\Controller\Index', 'roles' => array('admin')),
                array('controller' => 'Admin\Controller\User', 'roles' => array('admin')),
                //array('controller' => 'zfcuser', 'roles' => array()),
                // Below is the default index action used by the ZendSkeletonApplication
                array('controller' => 'Application\Controller\Index', 'roles' => array()),
                array('controller' => 'Api\Controller\User', 'roles' => array('admin')),
            ),
//            /* If this guard is specified here (i.e. it is enabled), it will block
//             * access to all routes unless they are specified here.
//             */
//            'BjyAuthorize\Guard\Route' => array(
//                array('route' => 'zfcuser', 'roles' => array('user')),
//                array('route' => 'zfcuser/logout', 'roles' => array('user')),
//                array('route' => 'zfcuser/login', 'roles' => array('guest')),
//                array('route' => 'zfcuser/register', 'roles' => array('guest')),
//                // Below is the default index action used by the ZendSkeletonApplication
//                array('route' => 'home', 'roles' => array('admin')),
//            ),
        ),
        'cache_options' => array(
            'adapter' => array(
                'name' => 'memcached',
                'options' => array(
                    'servers' => array(
                        array(
                            'host' => 'localhost',
                            'port' => 11211
                        ),
                    ),
                ),
            ),
            'plugins' => array(
                'exception_handler' => array(
                    'throw_exceptions' => true
                ),
                'serializer',
            )
        ),
        // Key used by the cache for caching the acl
        'cache_key' => 'bjyauthorize_acl',
        'unauthorized_strategy' => 'Application\View\UnauthorizedStrategy',
    ),
);



//return array(
//    'bjyauthorize' => array(
//        // set the 'guest' role as default (must be defined in a role provider)
//        'default_role' => 'guest',
//        /* this module uses a meta-role that inherits from any roles that should
//         * be applied to the active user. the identity provider tells us which
//         * roles the "identity role" should inherit from.
//         *
//         * for ZfcUser, this will be your default identity provider
//         */
//        //'identity_provider' => 'BjyAuthorize\Provider\Identity\ZfcUserZendDb',
//        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
//        //'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
//        /* If you only have a default role and an authenticated role, you can
//         * use the 'AuthenticationIdentityProvider' to allow/restrict access
//         * with the guards based on the state 'logged in' and 'not logged in'.
//         *
//         * 'default_role'       => 'guest',         // not authenticated
//         * 'authenticated_role' => 'user',          // authenticated
//         * 'identity_provider'  => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
//         */
//
//        /* role providers simply provide a list of roles that should be inserted
//         * into the Zend\Acl instance. the module comes with two providers, one
//         * to specify roles in a config file and one to load roles using a
//         * Zend\Db adapter.
//         */
//        'role_providers' => array(
//            /* here, 'guest' and 'user are defined as top-level roles, with
//             * 'admin' inheriting from user
//             */
////            'BjyAuthorize\Provider\Role\Config' => array(
////                'guest' => array(),
////                'user' => array('children' => array(
////                        'admin' => array(),
////                    )),
////            ),
//            // this will load roles from the user_role table in a database
//            // format: user_role(role_id(varchar), parent(varchar))
////            'BjyAuthorize\Provider\Role\ZendDb' => array(
////                'table' => 'user_role',
////                'role_id_field' => 'role_id',
////                'parent_role_field' => 'parent',
////            ),
//            // this will load roles from
//            // the 'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' service
////            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
////                // class name of the entity representing the role
////                'role_entity_class' => 'SamUser\Entity\Role',
////                // service name of the object manager
////                //'object_manager' => 'Doctrine\Common\Persistence\ObjectManager',
////                'object_manager' => 'doctrine.entitymanager.orm_default',
////            //'role_entity_class' => 'Application\Entity\Role',
////            ),
//        ),
//        // resource providers provide a list of resources that will be tracked
//        // in the ACL. like roles, they can be hierarchical
////        'resource_providers' => array(
////            'BjyAuthorize\Provider\Resource\Config' => array(
////                'pants' => array(),
////            ),
////        ),
//        /* rules can be specified here with the format:
//         * array(roles (array), resource, [privilege (array|string), assertion])
//         * assertions will be loaded using the service manager and must implement
//         * Zend\Acl\Assertion\AssertionInterface.
//         * *if you use assertions, define them using the service manager!*
//         */
////        'rule_providers' => array(
////            'BjyAuthorize\Provider\Rule\Config' => array(
////                'allow' => array(
////                    // allow guests and users (and admins, through inheritance)
////                    // the "wear" privilege on the resource "pants"
////                    array(array('guest', 'user'), 'pants', 'wear')
////                ),
////                // Don't mix allow/deny rules if you are using role inheritance.
////                // There are some weird bugs.
////                'deny' => array(
////                // ...
////                ),
////            ),
////        ),
//        /* Currently, only controller and route guards exist
//         *
//         * Consider enabling either the controller or the route guard depending on your needs.
//         */
//        'guards' => array(
//            /* If this guard is specified here (i.e. it is enabled), it will block
//             * access to all controllers and actions unless they are specified here.
//             * You may omit the 'action' index to allow access to the entire controller
//             */
//            'BjyAuthorize\Guard\Controller' => array(
//                array('controller' => 'index', 'action' => 'index', 'roles' => array('guest', 'user')),
//                array('controller' => 'index', 'action' => 'stuff', 'roles' => array('user')),
//                // You can also specify an array of actions or an array of controllers (or both)
//                // allow "guest" and "admin" to access actions "list" and "manage" on these "index",
//                // "static" and "console" controllers
//                array(
//                    'controller' => array('index', 'static', 'console'),
//                    'action' => array('list', 'manage'),
//                    'roles' => array('guest', 'admin')
//                ),
//                array(
//                    'controller' => array('search', 'administration'),
//                    'roles' => array('staffer', 'admin')
//                ),
//                array('controller' => 'zfcuser', 'roles' => array()),
//            // Below is the default index action used by the ZendSkeletonApplication
//            // array('controller' => 'Application\Controller\Index', 'roles' => array('guest', 'user')),
//            ),
////            /* If this guard is specified here (i.e. it is enabled), it will block
////             * access to all routes unless they are specified here.
////             */
////            'BjyAuthorize\Guard\Route' => array(
////                array('route' => 'zfcuser', 'roles' => array('user')),
////                array('route' => 'zfcuser/logout', 'roles' => array('user')),
////                array('route' => 'zfcuser/login', 'roles' => array('guest')),
////                array('route' => 'zfcuser/register', 'roles' => array('guest')),
////                // Below is the default index action used by the ZendSkeletonApplication
////                array('route' => 'home', 'roles' => array('guest', 'user')),
////            ),
//        ),
//    ),
//);