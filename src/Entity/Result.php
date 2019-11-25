<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultRepository")
 */
class Result
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ResultNumber;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Calculation", mappedBy="Result", cascade={"persist", "remove"})
     */
    private $calculation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResultNumber(): ?int
    {
        return $this->ResultNumber;
    }

    public function setResultNumber(?int $ResultNumber): self
    {
        $this->ResultNumber = $ResultNumber;

        return $this;
    }

    public function getCalculation(): ?Calculation
    {
        return $this->calculation;
    }

    public function setCalculation(Calculation $calculation): self
    {
        $this->calculation = $calculation;

        // set the owning side of the relation if necessary
        if ($calculation->getResult() !== $this) {
            $calculation->setResult($this);
        }

        return $this;
    }
}
