<?php
namespace Repository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAdminUser(){
      return $this->createQueryBuilder('u')
            ->select('u.prenom, u.nom, r.role')
            ->from('Entity\Role', 'r')
            ->where('u.id = r.user')
            ->getQuery()
            ->getResult();
    }
}
