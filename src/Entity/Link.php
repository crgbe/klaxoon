<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LinkRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LinkRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"link" = "Link", "video" = "VideoLink", "image" = "ImageLink"})
 */
class Link
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=350)
     * @Groups({"main"})
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"main"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"main"})
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"main"})
     */
    private $creationDate;

    /**
     * @ORM\Column(type="datetime", length=350, nullable=true)
     * @Groups({"main"})
     */
    private $publishingDate;

    /**
     * @ORM\ManyToOne(targetEntity=LinkType::class, inversedBy="links")
     * @Groups({"main"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Provider::class, inversedBy="links")
     * @Groups({"main"})
     */
    private $provider;

    public function __construct(?array $data)
    {
        if(!empty($data)){
            $this->url = $data['original_url'];
            $this->title = $data['title'];
            $this->author = $data['author_name'];
            $this->creationDate = new \DateTimeImmutable();
            $this->publishingDate = isset($data['upload_date']) ? new \DateTime($data['upload_date']) : null;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCreationDate(): \DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getPublishingDate(): ?\DateTimeInterface
    {
        return $this->publishingDate;
    }

    public function setPublishingDate(?\DateTimeInterface $publishingDate): self
    {
        $this->publishingDate = $publishingDate;

        return $this;
    }

    public function getType(): ?LinkType
    {
        return $this->type;
    }

    public function setType(?LinkType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    public function setProvider(?Provider $provider): self
    {
        $this->provider = $provider;

        return $this;
    }
}