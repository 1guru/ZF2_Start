<?php

namespace Admin\Model;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Admin\Entity\User;

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

    public function save(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function deleteAlbum($id)
    {
        $id = (int) $id;
        $user = $this->getRepository()->find($id);
        $this->em->remove($user);
        $this->em->flush();
    }

}