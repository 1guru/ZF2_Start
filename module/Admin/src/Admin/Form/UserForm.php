<?php

namespace Admin\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class UserForm extends Form
{

    public function __construct(EntityManager $em)
    {
        parent::__construct('user');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'username',
            'type' => 'text',
            'options' => array('label' => 'Username'),
            'attributes' => array(
                'class' => 'input-large'
            )
        ));
        
        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array('label' => 'Email'),
            'attributes' => array(
                'class' => 'input-large'
            )
        ));
        
        $this->add(array(
            'name' => 'firstName',
            'type' => 'text',
            'options' => array('label' => 'First name'),
            'attributes' => array(
                'class' => 'input-large'
            )
        ));
        
        $this->add(array(
            'name' => 'lastName',
            'type' => 'text',
            'options' => array('label' => 'Last name'),
            'attributes' => array(
                'class' => 'input-large'
            )
        ));

//        $this->add(array(
//            'name' => 'role',
//            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
//            'options' => array(
//                'label' => 'Role',
//                'object_manager' => $em,
//                'target_class' => 'Admin\Entity\UserRole',
//                'property' => 'roleId'
//            ),
//            'attributes' => array(
//                'required' => false
//            )
//        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
    }

}