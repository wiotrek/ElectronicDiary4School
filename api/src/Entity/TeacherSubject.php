<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TeacherSubject
 *
 * @ORM\Table(name="teacher_subject", indexes={@ORM\Index(name="teacher_subject_subject_fk", columns={"subject_id"}), @ORM\Index(name="teacher_subject_teacher_fk", columns={"teacher_id"})})
 * @ORM\Entity
 */
class TeacherSubject
{
    /**
     * @var int
     *
     * @ORM\Column(name="teacher_subject_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $teacherSubjectId;

    /**
     * @var \Subject
     *
     * @ORM\ManyToOne(targetEntity="Subject")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subject_id", referencedColumnName="subject_id")
     * })
     */
    private $subject;

    /**
     * @var \Teacher
     *
     * @ORM\ManyToOne(targetEntity="Teacher")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="teacher_id", referencedColumnName="teacher_id")
     * })
     */
    private $teacher;


}
