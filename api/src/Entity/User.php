<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="user_identifier_uindex", columns={"identifier"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=30, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=30, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=10, nullable=false)
     */
    private $identifier;

    /**
     * @var string
     *
     * @ORM\Column(name="hash_pass", type="blob", length=65535, nullable=false)
     */
    private $hashPass;

    /**
     * @var string
     *
     * @ORM\Column(name="salt_pass", type="blob", length=65535, nullable=false)
     */
    private $saltPass;


}
