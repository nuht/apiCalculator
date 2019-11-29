<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Calculation", mappedBy="user", orphanRemoval=true)
     */
    private $calculations;

    public function __construct()
    {
        parent::__construct();
        $this->calculations = new ArrayCollection();
    }

    /**
     * @return Collection|Calculation[]
     */
    public function getCalculations(): Collection
    {
        return $this->calculations;
    }

    public function addCalculation(Calculation $calculation): self
    {
        if (!$this->calculations->contains($calculation)) {
            $this->calculations[] = $calculation;
            $calculation->setUser($this);
        }

        return $this;
    }

    public function removeCalculation(Calculation $calculation): self
    {
        if ($this->calculations->contains($calculation)) {
            $this->calculations->removeElement($calculation);
            // set the owning side to null (unless already changed)
            if ($calculation->getUser() === $this) {
                $calculation->setUser(null);
            }
        }

        return $this;
    }
}