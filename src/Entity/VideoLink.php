<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VideoLinkRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=VideoLinkRepository::class)
 */
class VideoLink extends Link
{
    /**
     * @ORM\Id
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

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"main"})
     */
    private $duration;

    public function __construct(?array $data){
        parent::__construct($data);

        if(!empty($data)){
            $this->width = $data['width'];
            $this->height = $data['height'];
            $this->duration = $data['duration'] ?? null;
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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}