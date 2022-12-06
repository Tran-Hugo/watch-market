<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nom = null;

    #[ORM\Column(length: 150)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    #[ORM\OneToMany(mappedBy: 'fournisseur', targetEntity: Article::class, orphanRemoval: true)]
    private Collection $Article;

    public function __construct()
    {
        $this->Article = new ArrayCollection();
    }

    public function __toString(){
        return $this->nom;
    }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->Article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->Article->contains($article)) {
            $this->Article->add($article);
            $article->setFournisseur($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->Article->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getFournisseur() === $this) {
                $article->setFournisseur(null);
            }
        }

        return $this;
    }
}
