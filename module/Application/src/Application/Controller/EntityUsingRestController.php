<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

class EntityUsingRestController extends AbstractRestfulController
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * Sets the EntityManager
     *
     * @param EntityManager $em
     * @access protected
     * @return PostController
     */
    protected function setEntityManager(\Doctrine\ORM\EntityManager $em)
    {
        $this->entityManager = $em;
        return $this;
    }

    /**
     * Returns the EntityManager
     *
     * Fetches the EntityManager from ServiceLocator if it has not been initiated
     * and then returns it
     *
     * @access protected
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        }
        return $this->entityManager;
    }

}

