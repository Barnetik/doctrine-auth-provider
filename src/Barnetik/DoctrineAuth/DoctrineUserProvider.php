<?php namespace Barnetik\DoctrineAuth;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Doctrine based user authentication provider
 * @author Arkaitz Etxeberria <arkaitz@barnetik.com>
 */
class DoctrineUserProvider implements UserProvider
{
    private $userMapper;
    
    public function __construct(EntityManagerInterface $entityManager, $model) {
        $this->userMapper = $entityManager->getRepository($model);
    }

    public function retrieveById($identifier) {
        return $this->userMapper->find($identifier);
    }
    
    public function retrieveByCredentials(array $credentials) {
        $criteria = [];
        foreach ($credentials as $key => $value) {
            if (!str_contains($key, 'password')) {
                $criteria[$key] = $value;
            }
        }
        return $this->userMapper->findOneBy($criteria);
    }
    
    public function validateCredentials(UserContract $user, array $credentials) {
        $userPass = $user->getAuthPassword();
        $pass = $credentials['password'];
        return password_verify($pass, $userPass);
    }
    
    public function retrieveByToken($identifier, $token) {
        return $this->userMapper->findOneBy([
            "id" => $identifier,
            "rememberToken" => $token
            ]);
    }
    
    public function updateRememberToken(UserContract $user, $token) {
        $user->setRememberToken($token);
        \Doctrine::persist($user);
        \Doctrine::flush();
    }
    
}