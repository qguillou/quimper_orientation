<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;

/**
 * InscritRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InscritRepository extends \Doctrine\ORM\EntityRepository
{
  public function findAllByUser(User $user){
    return $this->createQueryBuilder('i')
        ->where('i.user = :user')
        ->setParameter('user', $user)
        ->orderBy('i.course', 'ASC')
        ->getQuery()
        ->getResult();
  }

  public function findInscrit(User $user, $id){
    return $this->createQueryBuilder('i')
      ->where('i.user = :user')
      ->andWhere('i.id = :id')
      ->setParameter('user', $user)
      ->setParameter('id', $id)
      ->getQuery()
      ->getOneOrNullResult();
  }
}
