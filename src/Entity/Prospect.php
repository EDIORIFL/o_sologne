<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prospect
 *
 * @ORM\Entity(repositoryClass="App\Repository\ProspectRepository")
 * @ORM\Table(name="prospect", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_C9CE8C7D26E94372", columns={"siret"}), @ORM\UniqueConstraint(name="UNIQ_C9CE8C7D5E237E06", columns={"name"})})
 */
class Prospect
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
     * @var int
     *
     * @ORM\Column(name="idaccount", type="integer", nullable=false, options={"default"="1"})
     */
    private $idaccount = '1';

    /**
     * @var int
     *
     * @ORM\Column(name="idactivityarea", type="integer", nullable=false, options={"default"="1"})
     */
    private $idactivityarea = '1';

    /**
     * @var int
     *
     * @ORM\Column(name="idprospectstatus", type="integer", nullable=false, options={"default"="1"})
     */
    private $idprospectstatus = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="manager", type="string", length=50, nullable=false)
     */
    private $manager = '';

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", length=0, nullable=false)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="siret", type="string", length=20, nullable=true)
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=15, nullable=false)
     */
    private $telephone = '';

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=15, nullable=false)
     */
    private $mobile = '';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email = '';

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=0, nullable=false)
     */
    private $comment;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="iscustomer", type="boolean", nullable=true)
     */
    private $iscustomer;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="isrefused", type="boolean", nullable=true)
     */
    private $isrefused;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datecreated", type="datetime", nullable=true)
     */
    private $datecreated;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datestatus", type="datetime", nullable=true)
     */
    private $datestatus;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="isactive", type="boolean", nullable=true, options={"default"="1"})
     */
    private $isactive = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="iseditable", type="boolean", nullable=false, options={"default"="1"})
     */
    private $iseditable = true;

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

    public function getIdaccount(): ?int
    {
        return $this->idaccount;
    }

    public function setIdaccount(int $idaccount): self
    {
        $this->idaccount = $idaccount;

        return $this;
    }

    public function getIdactivityarea(): ?int
    {
        return $this->idactivityarea;
    }

    public function setIdactivityarea(int $idactivityarea): self
    {
        $this->idactivityarea = $idactivityarea;

        return $this;
    }

    public function getIdprospectstatus(): ?int
    {
        return $this->idprospectstatus;
    }

    public function setIdprospectstatus(int $idprospectstatus): self
    {
        $this->idprospectstatus = $idprospectstatus;

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

    public function getManager(): ?string
    {
        return $this->manager;
    }

    public function setManager(string $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getIscustomer(): ?bool
    {
        return $this->iscustomer;
    }

    public function setIscustomer(?bool $iscustomer): self
    {
        $this->iscustomer = $iscustomer;

        return $this;
    }

    public function getIsrefused(): ?bool
    {
        return $this->isrefused;
    }

    public function setIsrefused(?bool $isrefused): self
    {
        $this->isrefused = $isrefused;

        return $this;
    }

    public function getDatecreated(): ?\DateTime
    {
        return $this->datecreated;
    }

    public function setDatecreated(?\DateTime $datecreated): self
    {
        $this->datecreated = $datecreated;

        return $this;
    }

    public function getDatestatus(): ?\DateTime
    {
        return $this->datestatus;
    }

    public function setDatestatus(?\DateTime $datestatus): self
    {
        $this->datestatus = $datestatus;

        return $this;
    }

    public function getIsactive(): ?bool
    {
        return $this->isactive;
    }

    public function setIsactive(?bool $isactive): self
    {
        $this->isactive = $isactive;

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

    public function getCreatedat(): ?\DateTime
    {
        return new \DateTime($this->createdat);
    }

    public function setCreatedat(\DateTime $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTime
    {
        return new \DateTime($this->updatedat);
    }

    public function setUpdatedat(\DateTime $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }


}
