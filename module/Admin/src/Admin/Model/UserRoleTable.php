<?php

namespace Admin\Model;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Admin\Entity\UserRole;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;

class UserRoleTable
{

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * 
     * @return User
     */
    public function getRepository()
    {
        return $this->em->getRepository('Admin\Entity\UserRole');
    }

    /**
     * 
     * @param bool $paged
     * @return mixed
     */
    public function fetchAll($paged = false)
    {

        if ($paged === true) {
            $query = $this->getRepository()->createQueryBuilder('UserRole')->getQuery();

            $paginator = new Paginator(
                    new DoctrinePaginator(new ORMPaginator($query))
            );
            return $paginator;
        } else {
            return $this->getRepository()->findAll();
        }
    }

    /**
     * 
     * @param int $id
     * @return User
     * @throws \Exception
     */
    public function getRole($id)
    {
        $id = (int) $id;
        $result = $this->getRepository()->find($id);
        if (!$result) {
            throw new \Exception("Could not find row $id");
        }
        return $result;
    }
    
    /**
     * 
     * @param array $criteria
     * @return \Admin\Entity\UserRole
     */
    public function getRoleBy(array $criteria)
    {
        $result = $this->getRepository()->findOneBy($criteria);
        return $result;
    }
    
    /**
     * 
     * @return \Admin\Entity\UserRole
     */
    public function getDefaultRole()
    {
        return $this->getRoleBy(array('roleId' => \Admin\Entity\UserBase::DEFAULT_ROLE));
    }

    /**
     * 
     * @return \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity
     */
    public function getFormHydrator()
    {
        return new DoctrineEntity($this->em, 'Admin\Entity\UserRole');
    }

}