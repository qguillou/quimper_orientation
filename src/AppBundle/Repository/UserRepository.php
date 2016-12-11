<?php
namespace AppBundle\Repository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Role;
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
            ->from('AppBundle\Entity\Role', 'r')
            ->where('u.username = r.user')
            ->getQuery()
            ->getResult();
    }
}
