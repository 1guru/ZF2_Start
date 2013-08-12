<?php

namespace Admin\Controller;

use Application\Controller\EntityUsingController;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use Zend\View\Model\ViewModel;
use Admin\Form\UserForm;
use Admin\Entity\User;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class UserController extends EntityUsingController
{

    /**
     * Index action
     *
     */
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $query = $em->getRepository('Admin\Entity\User')->createQueryBuilder('User')->getQuery();

        $paginator = new Paginator(
                new DoctrinePaginator(new ORMPaginator($query))
        );

        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1))
                ->setItemCountPerPage(2);

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
            $user = $this->getEntityManager()->getRepository('Admin\Entity\User')->find($this->params('id'));
        }

        $form = new UserForm($this->getEntityManager());
        $form->setHydrator(new DoctrineEntity($this->getEntityManager(), 'Admin\Entity\User'));
        $form->bind($user);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $em = $this->getEntityManager();

                $em->persist($user);
                $em->flush();

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
        $user = $this->getEntityManager()->getRepository('Admin\Entity\User')->find($this->params('id'));

        if ($user) {
            $em = $this->getEntityManager();
            $em->remove($user);
            $em->flush();

            $this->flashMessenger()->addSuccessMessage('User Deleted');
        }

        return $this->redirect()->toRoute('admin_user');
    }

}
