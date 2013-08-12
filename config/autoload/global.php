<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array(
    'service_manager' => array(
        'factories' => array(
            'doctrine.cache.my_memcache' => function ($sm) {
                $cache = new \Doctrine\Common\Cache\MemcachedCache();
                $memcache = new \Memcached();
                $memcache->connect('localhost', 11211);
                $cache->setMemcached($memcache);
                return $cache;
            },
            'bjy_my_memcache' => function ($sm) {
                $memcacheOptions = new Zend\Cache\Storage\Adapter\MemcachedOptions();
                $memcacheOptions->setServers('localhost', 11211, 1);

                $memcache = new Zend\Cache\Storage\Adapter\Memcached($memcacheOptions);
                return $memcache;
            },
            'BjyAuthorize\Cache' => 'BjyAuthorize\Service\CacheFactory',
        ),
    ),
);
