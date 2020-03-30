<?php

namespace App\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Entry
 *
 * @Annotation
 * @Target("CLASS")
 */
class Entry
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
