<?php

namespace App\Entity;

use App\Interfaces\FilableInterface;
use App\Repository\PageRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Page implements FilableInterface
{
    public const DIR_NAME = '/upload/page';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $menuTitre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     */
    private $texte;

    /**
     * @ORM\Column(type="date")
     */
    private $datePublication;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    public function __construct()
    {
        $this->datePublication = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getMenuTitre(): ?string
    {
        return $this->menuTitre;
    }

    public function setMenuTitre(string $menuTitre): self
    {
        $this->menuTitre = $menuTitre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFileDirectory(): string
    {
        return self::DIR_NAME;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->slugalize();
    }
    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->slugalize();
    }

    private function slugalize(): void
    {
        $slug = strtolower($this->getTitre());
        $slug = preg_replace('/([^0-9a-z])+/', '-', $slug);

        $this->setSlug($slug.'-'.uniqid());
    }
}
