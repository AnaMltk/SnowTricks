<?php

namespace App\Entity;

use App\Entity\Figure;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupRepository;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Figure",mappedBy="group")
     */
    private $figure;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFigure()
    {
        return $this->figure;
    }

    public function setFigure(Figure $figure): self
    {
        $this->figure = $figure;

        return $this;
    }
}
