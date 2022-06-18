<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 40)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getFormatedDescription(): ?string
    {
        if (strlen($this->description) > 30){
            $str =  substr($this->description, 0, 30) . '...';
            return $str;
        }
        else{
            return $this->description;
        }
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
