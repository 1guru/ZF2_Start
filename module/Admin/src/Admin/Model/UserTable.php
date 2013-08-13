<?php

namespace Admin\Model;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Admin\Entity\User;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;

class UserTable
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
        return $this->em->getRepository('Admin\Entity\User');
    }

    /**
     * 
     * @param bool $paged
     * @return mixed
     */
    public function fetchAll($paged = false)
    {

        if ($paged === true) {
            $query = $this->getRepository()->createQueryBuilder('User')->getQuery();

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
    public function getUser($id)
    {
        $id = (int) $id;
        $user = $this->getRepository()->find($id);
        if (!$user) {
            throw new \Exception("Could not find row $id");
        }
        return $user;
    }

    /**
     * 
     * @param \Admin\Entity\User $user
     */
    public function save(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * 
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        $id = (int) $id;
        $user = $this->getRepository()->find($id);
        if ($user) {
            $this->em->remove($user);
            $this->em->flush();
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @return \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity
     */
    public function getFormHydrator()
    {
        return new DoctrineEntity($this->em, 'Admin\Entity\User');
    }

}