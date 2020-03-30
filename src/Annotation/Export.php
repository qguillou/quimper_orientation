<?php

namespace App\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Export
 *
 * @Annotation
 * @Target("CLASS")
 */
class Export
{
    /**
     * @Required
     *
     * @var string
     */
    public $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
