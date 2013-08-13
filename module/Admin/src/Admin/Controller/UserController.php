<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\UserForm;
use Admin\Entity\User;

class UserController extends AbstractActionController
{

    /**
     *
     * @var \Admin\Model\UserTable
     */
    protected $userTable;

    /**
     * Index action
     *
     */
    public function indexAction()
    {
        $paginator = $this->getUserTable()->fetchAll(true);

        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1))
                ->setItemCountPerPage(25);

        return new ViewModel(array(
            'paginator' => $paginator,
        ));
    }

    /**
     * Edit action
     *
     */
    public function editAction()
    {
        $user = new User;

        if ($this->params('id') > 0) {
            $user = $this->getUserTable()->getUser($this->params('id'));
        }

        $form = new UserForm($this->getEntityManager());
        $form->setHydrator($this->getUserTable()->getFormHydrator());
        $form->bind($user);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getUserTable()->save($user);

                $this->flashMessenger()->addSuccessMessage('User Saved');

                return $this->redirect()->toRoute('admin_user');
            }
        }

        return new ViewModel(array(
            'user' => $user,
            'form' => $form
        ));
    }

    /**
     * Delete action
     *
     */
    public function deleteAction()
    {
        if ($this->getUserTable()->delete($this->params('id'))) {
            $this->flashMessenger()->addSuccessMessage('User deleted');
        } else {
            $this->flashMessenger()->addErrorMessage('User cannot be deleted');
        }

        return $this->redirect()->toRoute('admin_user');
    }

    /**
     * 
     * @return \Admin\Model\UserTable
     */
    public function getUserTable()
    {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Admin\Model\UserTable');
        }
        return $this->userTable;
    }

}
