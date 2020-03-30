<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findFiltered($values = [], $limit = null)
    {
        $query = $this->createQueryBuilder('e')
            ->orderBy('e.dateBegin', 'ASC');

        foreach ($values as $value) {
            $query
                ->andWhere('e.' . $value['name'] . ' ' . $value['operator'] . ' :' . $value['name'])
                ->setParameter($value['name'], $value['value'])
            ;
        }

        if (!empty($limit)) {
            $query->setMaxResults($limit);
        }

        return $query->getQuery()
            ->execute();
    }
}
