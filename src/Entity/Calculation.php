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
    private $parameterOne;

    /**
     * @ORM\Column(type="integer")
     */
    private $parameterTwo;

    /**
     * @ORM\Column(type="integer")
     */
    private $result;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $calculType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="calculations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParameterOne(): ?int
    {
        return $this->parameterOne;
    }

    public function setParameterOne(int $parameterOne): self
    {
        $this->parameterOne = $parameterOne;

        return $this;
    }

    public function getParameterTwo(): ?int
    {
        return $this->parameterTwo;
    }

    public function setParameterTwo(int $parameterTwo): self
    {
        $this->parameterTwo = $parameterTwo;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(int $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getCalculType(): ?string
    {
        return $this->calculType;
    }

    public function setCalculType(string $calculType): self
    {
        $this->calculType = $calculType;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
