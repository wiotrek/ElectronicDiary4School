<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MarksType
 *
 * @ORM\Table(name="marks_type")
 * @ORM\Entity
 */
class MarksType
{
    /**
     * @var int
     *
     * @ORM\Column(name="marks_type_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $marksTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="mark_from", type="string", length=30, nullable=false)
     */
    private $markFrom;

    /**
     * @var float
     *
     * @ORM\Column(name="weights", type="float", precision=10, scale=0, nullable=false)
     */
    private $weights;


}
