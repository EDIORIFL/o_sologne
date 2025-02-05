<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Support
 *
 * @ORM\Table(name="support", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_8004EBA5EA750E8", columns={"label"})})
 * @ORM\Entity(repositoryClass="App\Repository\SupportRepository")
 */
class Support
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
     * @ORM\Column(name="idsupporttype", type="integer", nullable=false, options={"default"="1"})
     */
    private $idsupporttype = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=50, nullable=false)
     */
    private $label;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateedited", type="date", nullable=true)
     */
    private $dateedited;

    /**
     * @var bool
     *
     * @ORM\Column(name="isactive", type="boolean", nullable=false, options={"default"="1"})
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
     * @ORM\Column(name="createdat", type="datetime", nullable=false)
     */
    private $createdat;

    /**
     * @var SupportType
     */
    private $supportType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedat", type="datetime", nullable=false)
     */
    private $updatedat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Command", mappedBy="idsupport")
     */
    private $commands;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdsupporttype(): ?int
    {
        return $this->idsupporttype;
    }

    public function setIdsupporttype(int $idsupporttype): self
    {
        $this->idsupporttype = $idsupporttype;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDateedited(): ?\DateTime
    {
        return $this->dateedited;
    }

    public function setDateedited(?\DateTime $dateedited): self
    {
        $this->dateedited = $dateedited;

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
        return $this->createdat;
    }

    public function setCreatedat(\DateTime $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTime
    {
        return $this->updatedat;
    }

    public function setUpdatedat(\DateTime $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    public function getSupportType(): ?SupportType
    {
        return $this->supportType;
    }

    public function setSupportType(SupportType $supportType)
    {
        $this->supportType = $supportType;

        return $this;
    }
}
