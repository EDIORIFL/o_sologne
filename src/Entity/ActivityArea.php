<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActivityArea
 *
 * @ORM\Entity(repositoryClass="App\Repository\ActivityAreaRepository")
 * @ORM\Table(name="activity_area", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_D450E6FAEA750E8", columns={"label"})})
 */
class ActivityArea
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
            $this->setCreatedat(new \DateTime($this->createdat));
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
            $this->setUpdatedat(new \DateTime($this->updatedat));
        }
        return $this->updatedat;
    }

    public function setUpdatedat(\DateTime $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }


}
