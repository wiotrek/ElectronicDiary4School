<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marks
 *
 * @ORM\Table(name="marks")
 * @ORM\Entity
 */
class Marks
{
    /**
     * @var int
     *
     * @ORM\Column(name="marks_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $marksId;

    /**
     * @var string
     *
     * @ORM\Column(name="degree", type="string", length=2, nullable=false)
     */
    private $degree;


}
