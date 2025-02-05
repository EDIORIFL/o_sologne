<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProspectStatus
 *
 * @ORM\Table(name="prospect_status", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_3B9E10E1EA750E8", columns={"label"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProspectStatusRepository")
 */
class ProspectStatus
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
     * @ORM\Column(name="label", type="string", length=50, nullable=false)
     */
    private $label;

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
     * @var \DateTime
     *
     * @ORM\Column(name="updatedat", type="datetime", nullable=false)
     */
    private $updatedat;

    public function getId(): ?int
    {
        return $this->id;
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
        if (is_string($this->createdat)) {
            $datified = new DateTime($this->createdat);
            $this->setCreatedat($datified);
            return $datified;
        }
        return $this->createdat;
    }

    public function setCreatedat(\DateTime $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTime
    {
        if (is_string($this->updatedat)) {
            $datified = new DateTime($this->updatedat);
            $this->setUpdatedat($datified);
            return $datified;
        }
        return $this->updatedat;
    }

    public function setUpdatedat(\DateTime $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }


}
