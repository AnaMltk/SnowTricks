<?php

namespace App\Entity;

use App\Repository\FigureRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FigureRepository::class)
 */
class Figure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="figures")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo",mappedBy="figure")
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video",mappedBy="figure")
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment",mappedBy="figure")
     */
    private $comments;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;


    /**
     * @ORM\Column(type="datetime")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modification_date;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Collection | photos[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function setPhotos($photos)
    {
        $this->photos = $photos;

        return $this;
    }

    public function setVideos($videos)
    {
        $this->videos = $videos;

        return $this;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getModificationDate(): ?\DateTimeInterface
    {
        return $this->modification_date;
    }

    public function setModificationDate(?\DateTimeInterface $modification_date): self
    {
        $this->modification_date = $modification_date;

        return $this;
    }
}
