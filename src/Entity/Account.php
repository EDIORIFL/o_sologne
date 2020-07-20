<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 * @ORM\Table(name="account", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_7D3656A4AA08CB10", columns={"login"})})
 */
class Account
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="profil", type="string", length=16, nullable=false, options={"default"="commercial"})
     */
    private $profil = 'commercial';

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=false, options={"default"="_NOM_"})
     */
    private $name = '_NOM_';

    /**
     * @var bool
     *
     * @ORM\Column(name="iseditable", type="boolean", nullable=false, options={"default"="1"})
     */
    private $iseditable = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="isactive", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isactive = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdat", type="datetime", nullable=false, options={"default"="2016-01-01 00:00:00"})
     */
    private $createdat = '2016-01-01 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedat", type="datetime", nullable=false, options={"default"="2016-01-01 00:00:00"})
     */
    private $updatedat = '2016-01-01 00:00:00';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfil(): ?string
    {
        return $this->profil;
    }

    public function setProfil(string $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIseditable(): ?bool
    {
        return $this->iseditable;
    }

    public function setIseditable(bool $iseditable): self
    {
        $this->iseditable = $iseditable;

        return $this;
    }

    public function getIsactive(): ?bool
    {
        return $this->isactive;
    }

    public function setIsactive(bool $isactive): self
    {
        $this->isactive = $isactive;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(\DateTimeInterface $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }


}
