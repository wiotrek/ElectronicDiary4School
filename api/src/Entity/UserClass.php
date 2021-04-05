<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserClass
 *
 * @ORM\Table(name="user_class")
 * @ORM\Entity
 */
class UserClass
{
    /**
     * @var int
     *
     * @ORM\Column(name="class_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $classId;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=false)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier_number", type="string", length=1, nullable=false)
     */
    private $identifierNumber;


}
