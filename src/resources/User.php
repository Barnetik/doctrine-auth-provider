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
 * @ORM\Table(
 * name="User",
 * options={
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

    public function getAuthIdentifier()
    {
        return $this->getId();
    }

    public function getAuthPassword()
    {
        return $this->getPassword();
    }

    /**
    * Get the token value for the "remember me" session.
    *
    * @return string
    */
    public function getRememberToken() {
        return $this->rememberToken;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value) {
        $this->rememberToken = $value;
        return $this;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName() {
        return "rememberToken";
    }

}
