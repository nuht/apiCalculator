<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CalculationRepository")
 */
class Calculation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $ParameterOne;

    /**
     * @ORM\Column(type="integer")
     */
    private $ParameterTwo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Result", inversedBy="calculation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Result;

    public function __construct(Result $result)
    {
        $this->Result = new Result();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParameterOne(): ?int
    {
        return $this->ParameterOne;
    }

    public function setParameterOne(int $ParameterOne): self
    {
        $this->ParameterOne = $ParameterOne;

        return $this;
    }

    public function getParameterTwo(): ?int
    {
        return $this->ParameterTwo;
    }

    public function setParameterTwo(int $ParameterTwo): self
    {
        $this->ParameterTwo = $ParameterTwo;

        return $this;
    }

    public function getResult(): ?Result
    {
        return $this->Result;
    }

    public function setResult(Result $Result): self
    {
        $this->Result = $Result;

        return $this;
    }
}
