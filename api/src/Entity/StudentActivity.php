<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StudentActivity
 *
 * @ORM\Table(name="student_activity", indexes={@ORM\Index(name="student_activity_student_fk", columns={"student_id"}), @ORM\Index(name="student_activity_subject_fk", columns={"subject_id"})})
 * @ORM\Entity
 */
class StudentActivity
{
    /**
     * @var int
     *
     * @ORM\Column(name="student_activity_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $studentActivityId;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_active", type="date", nullable=false)
     */
    private $dateActive;

    /**
     * @var \Student
     *
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", referencedColumnName="student_id")
     * })
     */
    private $student;

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
