<?php

namespace App\Service\Export;

use App\Annotation\Export;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ExportDiscovery
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
    private $exports = [];


    /**
     * ExportDiscovery constructor.
     *
     * @param $namespace
     *   The namespace of the exports
     * @param $directory
     *   The directory of the exports
     * @param $rootDir
     * @param Reader $annotationReader
     */
    public function __construct($rootDir, Reader $annotationReader)
    {
        $this->namespace = 'App\Service\Export';
        $this->annotationReader = $annotationReader;
        $this->directory = 'Service/Export';
        $this->rootDir = $rootDir;
    }

    /**
     * Returns all the exports
     */
    public function getExports() {
        if (!$this->exports) {
            $this->discoverExports();
        }

        return $this->exports;
    }

    /**
     * Discovers exports
     */
    private function discoverExports() {
        $path = $this->rootDir . '/src/' . $this->directory;
        $finder = new Finder();
        $finder->files()->in($path);

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $class = $this->namespace . '\\' . $file->getBasename('.php');
            $annotation = $this->annotationReader->getClassAnnotation(new \ReflectionClass($class), 'App\Annotation\Export');
            if (!$annotation) {
                continue;
            }

            /** @var Export $annotation */
            $this->exports[$annotation->getName()] = [
                'class' => $class,
                'annotation' => $annotation,
            ];
        }
    }
}
