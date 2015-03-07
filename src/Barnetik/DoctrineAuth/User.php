<?php namespace Barnetik\DoctrineAuth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * 
 * @ORM\Entity
 * @ORM\Table(options={
 *  "mari": {
 *      "displayFields": {"username"}
 *  }
 * })
 * @ORM\HasLifecycleCallbacks
 */
class User implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
    
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @var  int
     */
    private $id;
    
    /**
     *
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     * @var string 
     */
    protected $username;
    
    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Serializer\Exclude
     * 
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(name="remember_token", type="string", nullable=true)
     */
    protected $rememberToken;
    
    protected $passwordFlag = false;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        $this->passwordFlag = true;
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
 
    /**
     * @ORM\PreFlush
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function postUpdate()
    {
        if ($this->passwordFlag === true) {
            $hashedPass = password_hash($this->getPassword(), PASSWORD_DEFAULT);
            $this->setPassword($hashedPass);
            $this->passwordFlag = false;
        }
    }
}
