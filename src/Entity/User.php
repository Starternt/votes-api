<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User view entity
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    const ROLE_USER = 'user';
    const STATUS_ON = 'on';
    const STATUS_OFF = 'off';
    const STATUS_DELETED = 'deleted';
    const GENDER_UNDEFINED = 'undefined';

    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=75)
     */
    protected $login;

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    protected $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=140)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", columnDefinition="enum('on','off','deleted')")
     */
    protected $status = self::STATUS_OFF;

    /**
     * @var string
     * @ORM\Column(type="string", columnDefinition="enum('male','female','undefined')")
     */
    protected $gender = self::GENDER_UNDEFINED;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime", length=36)
     */
    protected $birthday;

    /**
     * @var string
     * @ORM\Column(type="string", name="imageId", length=36)
     */
    protected $image;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime", name="createdAt")
     */
    protected $createdAt;

    /**
     * @var string
     * @ORM\Column(type="string", columnDefinition="enum('user','moderator','admin')")
     */
    protected $role = self::ROLE_USER;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return User
     */
    public function setId(string $id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     *
     * @return User
     */
    public function setLogin(string $login): User
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return User
     */
    public function setStatus(string $status): User
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return User
     */
    public function setGender(string $gender): User
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getBirthday(): ?DateTimeInterface
    {
        return $this->birthday;
    }

    /**
     * @param DateTimeInterface|null $birthday
     *
     * @return User
     */
    public function setBirthday(?DateTimeInterface $birthday): User
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     *
     * @return User
     */
    public function setImage(?string $image): User
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @return User
     */
    public function setCreatedAt(DateTimeInterface $createdAt): User
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     *
     * @return User
     */
    public function setRole(string $role): User
    {
        $this->role = $role;

        return $this;
    }

    public function getRoles()
    {
        return [];
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
        return $this->login;
    }

    public function eraseCredentials()
    {
    }
}
