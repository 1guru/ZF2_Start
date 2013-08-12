<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRoleLinker
 *
 * @ORM\Table(name="user_role_linker")
 * @ORM\Entity
 */
class UserRoleLinker
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $userId;

    /**
     * @var \Admin\Entity\UserRole
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Admin\Entity\UserRole")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;



    /**
     * Set userId
     *
     * @param integer $userId
     * @return UserRoleLinker
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set role
     *
     * @param \Admin\Entity\UserRole $role
     * @return UserRoleLinker
     */
    public function setRole(\Admin\Entity\UserRole $role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return \Admin\Entity\UserRole 
     */
    public function getRole()
    {
        return $this->role;
    }
}