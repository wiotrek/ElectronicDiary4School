<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassHarmonogram
 *
 * @ORM\Table(name="class_harmonogram", indexes={@ORM\Index(name="class_harmonogram_class_fk", columns={"class_id"}), @ORM\Index(name="class_harmonogram_subject_fk", columns={"subject_id"})})
 * @ORM\Entity
 */
class ClassHarmonogram
{
    /**
     * @var int
     *
     * @ORM\Column(name="class_harmonogram_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $classHarmonogramId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_meeting", type="date", nullable=false)
     */
    private $dateMeeting;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetime", nullable=false)
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime", nullable=false)
     */
    private $endTime;

    /**
     * @var \UserClass
     *
     * @ORM\ManyToOne(targetEntity="UserClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="class_id", referencedColumnName="class_id")
     * })
     */
    private $class;

    /**
     * @var \Subject
     *
     * @ORM\ManyToOne(targetEntity="Subject")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subject_id", referencedColumnName="subject_id")
     * })
     */
    private $subject;


}
