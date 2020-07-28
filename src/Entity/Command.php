<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Command
 *
 * @ORM\Entity(repositoryClass="App\Repository\CommandRepository")
 * @ORM\Table(name="command")
 */
class Command
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Prospect", inversedBy="commands")
     * @ORM\JoinColumn(name="idprospect", nullable=false)
     */
    private $idprospect;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Support", inversedBy="commands")
     * @ORM\JoinColumn(name="idsupport", nullable=false)
     */
    private $idsupport = '1';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datesigned", type="datetime", nullable=true)
     */
    private $datesigned;

    /**
     * @var float
     *
     * @ORM\Column(name="turnover", type="float", precision=10, scale=0, nullable=false)
     */
    private $turnover = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="rib", type="string", length=20, nullable=false)
     */
    private $rib = '';

    /**
     * @var string
     *
     * @ORM\Column(name="paymentmode", type="string", length=3, nullable=false)
     */
    private $paymentmode = '';

    /**
     * @var string
     *
     * @ORM\Column(name="payment", type="string", length=20, nullable=false)
     */
    private $payment = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="ismockfile", type="boolean", nullable=false)
     */
    private $ismockfile = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="insertsize", type="integer", nullable=false, options={"default"="1"})
     */
    private $insertsize = '1';

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
     * @ORM\Column(name="createdat", type="datetime", nullable=false, options={"default"="2016-01-01 00:00:00"})
     */
    private $createdat = '2016-01-01 00:00:00';


    /**
     * @var Prospect
     */
    private $prospect;

    /**
     * @var Support
     */
    private $support;

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

    public function getIdprospect()
    {
        return $this->idprospect;
    }

    public function setIdprospect($idprospect): self
    {
        $this->idprospect = $idprospect;

        return $this;
    }

    public function getIdsupport()
    {
        return $this->idsupport;
    }

    public function setIdsupport($idsupport): self
    {
        $this->idsupport = $idsupport;

        return $this;
    }

    public function getDatesigned(): ?\DateTimeInterface
    {
        return $this->datesigned;
    }

    public function setDatesigned(?\DateTimeInterface $datesigned): self
    {
        $this->datesigned = $datesigned;

        return $this;
    }

    public function getTurnover(): ?float
    {
        return $this->turnover;
    }

    public function setTurnover(float $turnover): self
    {
        $this->turnover = $turnover;

        return $this;
    }

    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function setRib(string $rib): self
    {
        $this->rib = $rib;

        return $this;
    }

    public function getPaymentmode(): ?string
    {
        return $this->paymentmode;
    }

    public function setPaymentmode(string $paymentmode): self
    {
        $this->paymentmode = $paymentmode;

        return $this;
    }

    public function getPayment(): ?string
    {
        return $this->payment;
    }

    public function setPayment(string $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getIsmockfile(): ?bool
    {
        return $this->ismockfile;
    }

    public function setIsmockfile(bool $ismockfile): self
    {
        $this->ismockfile = $ismockfile;

        return $this;
    }

    public function getInsertsize(): ?int
    {
        return $this->insertsize;
    }

    public function setInsertsize(int $insertsize): self
    {
        $this->insertsize = $insertsize;

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

    public function getProspect(): ?Prospect
    {
        return $this->prospect;
    }

    public function setProspect(Prospect $prospect)
    {
        $this->prospect = $prospect;

        return $this;
    }

    public function getSupport(): ?Support
    {
        return $this->support;
    }

    public function setSupport(Support $support)
    {
        $this->support = $support;

        return $this;
    }
}
