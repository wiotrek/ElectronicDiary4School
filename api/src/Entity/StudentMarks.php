<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StudentMarks
 *
 * @ORM\Table(name="student_marks", indexes={@ORM\Index(name="student_marks_marks_fk", columns={"marks_id"}), @ORM\Index(name="student_marks_marks_type_fk", columns={"marks_type_id"}), @ORM\Index(name="student_marks_student_fk", columns={"student_id"}), @ORM\Index(name="student_marks_subject_fk", columns={"subject_id"})})
 * @ORM\Entity
 */
class StudentMarks
{
    /**
     * @var int
     *
     * @ORM\Column(name="student_marks_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $studentMarksId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="approach_number", type="integer", nullable=true)
     */
    private $approachNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="topic", type="string", length=50, nullable=false)
     */
    private $topic;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="passing_date", type="datetime", nullable=false)
     */
    private $passingDate;

    /**
     * @var \Marks
     *
     * @ORM\ManyToOne(targetEntity="Marks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="marks_id", referencedColumnName="marks_id")
     * })
     */
    private $marks;

    /**
     * @var \MarksType
     *
     * @ORM\ManyToOne(targetEntity="MarksType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="marks_type_id", referencedColumnName="marks_type_id")
     * })
     */
    private $marksType;

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
