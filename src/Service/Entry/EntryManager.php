<?php

declare(strict_types=1);

namespace App\Service\Entry;

use App\Service\Model\ModelManager;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Search\QueryBuilder as EasyadminQueryBuilder;

class EntryManager
{
    /**
     * @var EntryDiscovery
     */
    private $discovery;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntryDiscovery $discovery, EntityManagerInterface $em)
    {
        $this->discovery = $discovery;
        $this->em = $em;
    }

    /**
     * Returns a list of available entry.
     *
     * @return array
     */
    public function getEntries() {
        return $this->discovery->getEntries();
    }

    /**
     * Returns one entry by name
     *
     * @param $name
     * @return array
     *
     * @throws \Exception
     */
    public function getEntry($name) {
        $entries = $this->discovery->getEntries();
        if (isset($entries[$name])) {
            return $entries[$name];
        }

        throw new \Exception('Entry not found.');
    }

    /**
     * Creates a entry
     *
     * @param $name
     * @return EntryInterface
     *
     * @throws \Exception
     */
    public function create($name) {
        $entries = $this->discovery->getEntries();
        if (array_key_exists($name, $entries)) {
            $class = $entries[$name]['class'];
            if (!class_exists($class)) {
                throw new \Exception('Entry class does not exist.');
            }
            return new $class($this->em);
        }

        throw new \Exception('Entry does not exist.');
    }
}
