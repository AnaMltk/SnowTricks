<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="users")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Figure",inversedBy="comments")
     * @ORM\JoinColumn(name="figure_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $figure;


    /**
     * @ORM\Column(type="datetime")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getFigure()
    {
        return $this->figure;
    }
    public function setFigure($figure): self
    {
        $this->figure = $figure;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }
}
