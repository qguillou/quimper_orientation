<?php

namespace App\Service\Entry;

use App\Annotation\Entry;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class EntryDiscovery
{
    /**
     * @var string
     */
    private string $namespace;

    /**
     * @var string
     */
    private string $directory;

    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * The Kernel root directory
     * @var string
     */
    private $rootDir;

    /**
     * @var array
     */
    private $entries = [];


    /**
     * EntryDiscovery constructor.
     *
     * @param $namespace
     *   The namespace of the entries
     * @param $directory
     *   The directory of the entries
     * @param $rootDir
     * @param Reader $annotationReader
     */
    public function __construct($rootDir, Reader $annotationReader)
    {
        $this->namespace = 'App\Service\Entry';
        $this->annotationReader = $annotationReader;
        $this->directory = 'Service/Entry';
        $this->rootDir = $rootDir;
    }

    /**
     * Returns all the exports
     */
    public function getEntries() {
        if (!$this->entries) {
            $this->discoverEntries();
        }

        return $this->entries;
    }

    /**
     * Discovers exports
     */
    private function discoverEntries() {
        $path = $this->rootDir . '/src/' . $this->directory;
        $finder = new Finder();
        $finder->files()->in($path);

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $class = $this->namespace . '\\' . $file->getBasename('.php');
            $annotation = $this->annotationReader->getClassAnnotation(new \ReflectionClass($class), 'App\Annotation\Entry');
            if (!$annotation) {
                continue;
            }

            /** @var Entry $annotation */
            $this->entries[$annotation->getName()] = [
                'class' => $class,
                'annotation' => $annotation,
            ];
        }
    }
}
