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
                'get_files' => new \Twig_SimpleFunction("get_files", function ($id) {
                   $path = realpath($this->kernel->getRootDir() . '/../web/files/courses/'.$id.'/autres/');
                   return glob($path."/*.pdf");
                }),
                'has_other_file' => new \Twig_SimpleFunction("has_other_file", function ($id) {
                   $path = realpath($this->kernel->getRootDir() . '/../web/files/courses/'.$id.'/autres/');
                   return sizeof(glob($path."/*.pdf"));
                }),
                'is_file' => new \Twig_SimpleFunction("is_file", function ($path) {
                    return is_file($path);
                }),
                'basename' => new \Twig_SimpleFunction("basename", function ($path, $ext) {
                     return basename($path, $ext);
                }),
                'strftime' => new \Twig_SimpleFunction("strftime", function ($date, $format) {
                     setlocale (LC_TIME, 'fr_FR.utf8','fra');
                     return strftime($format, strtotime($date));
                }),
                'is_past' => new \Twig_SimpleFunction("is_past", function ($date) {
                     return $date < date("Y-m-d H:i:s");
                }),
        );
    }
}
