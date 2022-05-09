<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProviderRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProviderRepository::class)
 */
class Provider
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"main"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Link::class,mappedBy="provider")
     */
    private $links;

    public function __construct()
    {
        $this->links = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Link[]
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(?Link $link): self
    {
        if(!$this->links->contains($link)){
            $this->links[] = $link;
            $link->setProvider($this);
        }

        return $this;
    }

    public function removeLink(?Link $link): self
    {
        if($this->links->removeElement($link)){
            if($link->getProvider() === $this){
                $link->setProvider(null);
            }
        }

        return $this;
    }
}