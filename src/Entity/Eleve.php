<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EleveRepository::class)
 */
class Eleve
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     message="Merci de renseigner un nom d'elève.",
     *     groups={"RegisterEleve"}
     *     )
     *
     * @Assert\Length(
     *     min="3",
     *     minMessage="Merci de renseigner un nom d'elève correct.",
     *     groups={"RegisterEleve"}
     *     )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     message="Merci de renseigner un prenom d'elève.",
     *     groups={"RegisterEleve"}
     *     )
     *
     * @Assert\Length(
     *     min="3",
     *     minMessage="Merci de renseigner un prenom d'elève correct.",
     *     groups={"RegisterEleve"}
     *     )
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank(
     *     message="Merci de renseigner un âge.",
     *     groups={"RegisterEleve"}
     *     )
     *
     */
    private $age;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="eleves")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }
}
