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

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getHashPass(): string
    {
        return $this->hashPass;
    }

    /**
     * @param string $hashPass
     */
    public function setHashPass(string $hashPass): void
    {
        $this->hashPass = $hashPass;
    }

    /**
     * @return string
     */
    public function getSaltPass(): string
    {
        return $this->saltPass;
    }

    /**
     * @param string $saltPass
     */
    public function setSaltPass(string $saltPass): void
    {
        $this->saltPass = $saltPass;
    }


}
