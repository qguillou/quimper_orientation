<?php

namespace Services;

class DateExtension extends \Twig_Extension
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
