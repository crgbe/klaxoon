<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImageLinkRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ImageLinkRepository::class)
 */
class ImageLink extends Link
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     */
    private $height;

    public function __construct(?array $data){
        parent::__construct($data);

        if(!empty($data)){
            $this->width = $data['width'];
            $this->height = $data['height'];
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }
}