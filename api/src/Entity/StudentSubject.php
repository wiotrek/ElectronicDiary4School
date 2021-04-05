<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StudentSubject
 *
 * @ORM\Table(name="student_subject", indexes={@ORM\Index(name="student_subject_student_fk", columns={"student_id"}), @ORM\Index(name="student_subject_subject_subject_id_fk", columns={"subject_id"})})
 * @ORM\Entity
 */
class StudentSubject
{
    /**
     * @var int
     *
     * @ORM\Column(name="student_subject_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $studentSubjectId;

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
