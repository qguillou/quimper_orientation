<?php

namespace App\Entity;

use Owp\OwpCore\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Model\IdTrait;
use App\Model\LabelTrait;
use App\Model\AuthorTrait;
use PiWeb\PiCRUD\Annotation as PiCRUD;

/**
 * @PiCRUD\Entity(
 *      name="format"
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Format
{
    use IdTrait;
    use LabelTrait;
    use AuthorTrait;
}
