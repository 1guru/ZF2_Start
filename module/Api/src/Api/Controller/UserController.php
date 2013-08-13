<?php

namespace Api\Controller;

use Admin\Entity\User;
use Zend\View\Model\JsonModel;
use Application\Controller\EntityUsingRestController;
use Doctrine\ORM\Query;
use Application\Services\EntitySerializer;

class UserController extends EntityUsingRestController
{

    public function getList()
    {
        $em = $this->getEntityManager();
        $users = $em->getRepository('Admin\Entity\User')->findBy(array(), array('email' => 'ASC'));
        $user = $em->getRepository('Admin\Entity\User')->findOneBy(array('id' => 4));

        $serializer = new EntitySerializer($em); // Pass the EntityManager object
        $users_array = $serializer->serialize($users);

        return new JsonModel(array(
            "users" => $users_array,
            "user" => $serializer->serialize($user),
        ));
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