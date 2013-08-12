<?php

namespace Admin\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;

abstract class UserBase implements UserInterface, ProviderInterface
{
    
    const DEFAULT_ROLE = 'user';

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Get role.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->getRole()->getValues();
    }
    
    /**
     * Sets the display name
     * 
     * @param string $displayName
     * @return void
     */
    public function setDisplayName($displayName)
    {
        list($first_name, $last_name) = explode(' ', $displayName);
        $this->setFirstName($first_name);
        $this->setLasttName($last_name);
    }
    
    /**
     * Get display name, will concatenate first name and last name
     * 
     * @return string
     */
    public function getDisplayName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }
    
    /**
     * Ads default role to user when it is created
     * 
     * @return void
     */
    public function addDefaultRole()
    {
        $objectManager = \Doctrine\ORM\EntityManager::create();
        $result = $objectManager->find('\Admin\Entity\USerRole', 'guest');
        $this->addRole();
    }

}