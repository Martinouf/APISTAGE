<?php

namespace App\Entity;

use App\Repository\InternshipRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Student;
use App\Entity\Company;

/**
 * @ORM\Entity(repositoryClass=InternshipRepository::class)
 */
class Internship
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=student::class, inversedBy="internships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idStudent;

    /**
     * @ORM\ManyToOne(targetEntity=company::class, inversedBy="internships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCompany;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdStudent(): ?student
    {
        return $this->idStudent;
    }

    public function setIdStudent(?student $idStudent): self
    {
        $this->idStudent = $idStudent;

        return $this;
    }

    public function getIdCompany(): ?company
    {
        return $this->idCompany;
    }

    public function setIdCompany(?company $idCompany): self
    {
        $this->idCompany = $idCompany;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
}
