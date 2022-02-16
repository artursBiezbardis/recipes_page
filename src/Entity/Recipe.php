<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $preparationTime;

    #[ORM\Column(type: 'string', length: 255)]
    private $cookingTime;

    #[ORM\Column(type: 'json')]
    private $shortDescription;

    #[ORM\Column(type: 'json')]
    private $ingridients;

    #[ORM\Column(type: 'json')]
    private $cookingMethod;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPreparationTime(): ?string
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(?string $preparationTime): self
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    public function getCookingTime(): ?string
    {
        return $this->cookingTime;
    }

    public function setCookingTime(string $cookingTime): self
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getIngridients(): ?string
    {
        return $this->ingridients;
    }

    public function setIngridients(array $ingridients): self
    {
        $this->ingridients = $ingridients;

        return $this;
    }

    public function getCookingMethod(): ?string
    {
        return $this->cookingMethod;
    }

    public function setCookingMethod(array $cookingMethod): self
    {
        $this->cookingMethod = $cookingMethod;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
