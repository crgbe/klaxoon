<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LinkTypeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LinkTypeRepository::class)
 */
class LinkType
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
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=Link::class,mappedBy="type")
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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

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
            $link->setType($this);
        }

        return $this;
    }

    public function removeLink(?Link $link): self
    {
        if($this->links->removeElement($link)){
            if($link->getType() === $this){
                $link->setType(null);
            }
        }

        return $this;
    }
}