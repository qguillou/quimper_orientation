<?php

namespace Services;

use Symfony\Component\HttpKernel\KernelInterface;

class FileExtension extends \Twig_Extension
{

    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('file_exists', 'file_exists'),
            new \Twig_SimpleFunction('is_file', 'is_file'),
            new \Twig_SimpleFunction('basename', 'basename'),
            new \Twig_SimpleFunction("get_files", function ($id) {
                  $path = realpath($this->kernel->getRootDir() . '/../web/files/courses/'.$id.'/autres/');
                  return glob($path."/*.pdf");
                }),
            new \Twig_SimpleFunction("annonce_exists", function ($id) {
                  $path = realpath($this->kernel->getRootDir() . '/../web/files/courses/'.$id.'/annonce.pdf');
                  return file_exists($path);
                }),
        );
    }

    public function getName()
    {
        return 'app_file';
    }
}
