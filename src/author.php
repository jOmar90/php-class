<?php

namespace Mjoma\PhpClass;

use DateTimeImmutable;

class Author
{
    private int $id;
    private $firstName;
    private $lastName;
    private $dateOfBirth;
    public function __construct($id, $firstName, $lastName, $dateOfBirth)
    {
        $firstName = trim(ucfirst($firstName));
        $lastName = trim(ucfirst($lastName));

        if (empty($firstName) || empty($lastName)) {
            throw new \InvalidArgumentException("First name and last name cannot be empty.");
        }
        if (!preg_match("/^[a-zA-Z.\s]+$/", $firstName) || !preg_match("/^[a-zA-Z.\s]+$/", $lastName)) {
            throw new \InvalidArgumentException("Names can only contain letters, spaces, and periods.");
        }
        if (!($dateOfBirth instanceof DateTimeImmutable)) {
            throw new \InvalidArgumentException("Date of birth must be a DateTimeImmutable object.");
        }
        if ($dateOfBirth > new DateTimeImmutable()) {
            throw new \InvalidArgumentException("Date of birth cannot be in the future.");
        }
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dateOfBirth = $dateOfBirth;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
    public function getDateOfBirth(): DateTimeImmutable
    {
        return $this->dateOfBirth;
    }
    public function getDateOfBirthAsString(): string
    {
        return $this->dateOfBirth->format('Y-m-d');
    }
}
