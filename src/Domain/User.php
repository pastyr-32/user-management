<?php
declare(strict_types=1);

namespace Nerdery\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * Class User
 * @package Nerdery\Domain
 *
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User implements JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string")
     */
    private $image;

    /**
     * Constructor
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $image
     */
    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $image
    )
    {
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->email      = $email;
        $this->image      = $image;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     *
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     *
     * @return self
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get image
     *
     * @return string|null
     */
    public function getImage():? string
    {
        return $this->image;
    }

    /**
     * Set image
     *
     * @param string|null $image
     *
     * @return self
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'email' => $this->getEmail(),
            'image' => $this->getImage()
        ];
    }
}