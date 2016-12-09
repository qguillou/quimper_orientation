<?php

namespace AppBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;

class AssetExistsExtension extends \Twig_Extension
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getFunctions()
    {
        return array(
                'annonce_exists' => new \Twig_SimpleFunction("annonce_exists", function ($id) {
                  $path = realpath($this->kernel->getRootDir() . '/../web/files/courses/'.$id.'/annonce.pdf');
                  return file_exists($path);
                 }),
                'get_horaires' => new \Twig_SimpleFunction("get_horaires", function ($id) {
                   $path = realpath($this->kernel->getRootDir() . '/../web/files/courses/'.$id.'/horaires/');
                   return glob($path."/*.pdf");
                }),
                'is_file' => new \Twig_SimpleFunction("is_file", function ($path) {
                    return is_file($path);
                }),
                'basename' => new \Twig_SimpleFunction("basename", function ($path) {
                     return basename($path);
                }),
        );
    }
}
