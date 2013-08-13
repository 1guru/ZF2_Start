<?php

namespace Api\Controller;

use Zend\View\Model\JsonModel;
use Application\Services\EntitySerializer;
use Zend\Mvc\Controller\AbstractRestfulController;

class UserController extends AbstractRestfulController
{

    /**
     *
     * @var \Admin\Model\UserTable
     */
    protected $userTable;
    protected $collectionOptions = array('GET', 'POST');
    protected $resourceOptions = array('DELETE', 'GET', 'PATCH', 'PUT');

    public function getList()
    {
        $users = $this->getUserTable()->fetchAll();
        return new JsonModel(array(
            "users" => $this->serialize($users),
        ));
    }

    public function get($id)
    {
        $user = $this->getUserTable()->getUser($id);
        return new JsonModel($this->serialize($user));
    }

    public function create($data)
    {
        $resource = $this->myComposedService->create($data);
        $response = $this->getResponse();
        $response->setStatusCode(201); // Created
        $response->getHeaders()->addHeaderLine(
                'Location', $this->url('recipe', array('id', $resource->id))
        );
        return $resource; // More on this later
    }

    public function update($id, $data)
    {
        # code...
    }

    public function delete($id)
    {
        # code...
    }

    public function options()
    {
        if ($this->params('id')) {
            $options = $this->resourceOptions;
        } else {
            $options = $this->collectionOptions;
        }
        $response = $this->getResponse();
        $response->getHeaders()
                ->addHeaderLine('Allow', implode(',', $options));
    }

    /**
     * 
     * @return \Admin\Model\UserTable
     */
    protected function getUserTable()
    {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Admin\Model\UserTable');
        }
        return $this->userTable;
    }

    protected function serialize($entity)
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $serializer = new EntitySerializer($em); // Pass the EntityManager object
        return $serializer->serialize($entity);
    }

}