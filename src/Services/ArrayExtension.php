<?php

namespace Services;

class ArrayExtension extends \Twig_Extension
{

    public function __construct()
    {

    }

    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
          new \Twig_SimpleFunction("sizeof", "sizeof"),
        );
    }

    public function getName()
    {
        return 'app_array';
    }
}
