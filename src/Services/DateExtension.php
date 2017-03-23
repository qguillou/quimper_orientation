<?php

namespace Services;

use Symfony\Component\HttpKernel\KernelInterface;

class DateExtension extends \Twig_Extension
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
          new \Twig_SimpleFunction("is_past", function ($date) {
            return $date < date("Y-m-d H:i:s");
          }),
        );
    }

    public function getName()
    {
        return 'app_date';
    }
}
