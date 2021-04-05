<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TeacherClass
 *
 * @ORM\Table(name="teacher_class", indexes={@ORM\Index(name="teacher_class_class_fk", columns={"class_id"}), @ORM\Index(name="teacher_class_teacher_fk", columns={"teacher_id"})})
 * @ORM\Entity
 */
class TeacherClass
{
    /**
     * @var int
     *
     * @ORM\Column(name="teacher_class_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $teacherClassId;

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
     * @var \Teacher
     *
     * @ORM\ManyToOne(targetEntity="Teacher")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="teacher_id", referencedColumnName="teacher_id")
     * })
     */
    private $teacher;


}
