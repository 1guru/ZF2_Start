<?php

namespace Api\Controller;

use Admin\Entity\User;
use Zend\View\Model\JsonModel;
use Application\Controller\EntityUsingRestController;
use Doctrine\ORM\Query;

class UserController extends EntityUsingRestController
{

    public function getList()
    {
        $em = $this->getEntityManager();

        $users = $em->newHydrator(Query::HYDRATE_ARRAY)->getRepository('Admin\Entity\User')->findBy(array(), array('email' => 'ASC'));

        return new JsonModel(array("users" => $users));
    }

    public function get($id)
    {
        # code...
    }

    public function create($data)
    {
        # code...
    }

    public function update($id, $data)
    {
        # code...
    }

    public function delete($id)
    {
        # code...
    }

}