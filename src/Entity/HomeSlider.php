<?php

namespace App\Entity;

use App\Repository\HomeSliderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HomeSliderRepository::class)
 */
class HomeSlider
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $buttonMessage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $buttonURL;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isDisplayed;

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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getButtonMessage(): ?string
    {
        return $this->buttonMessage;
    }

    public function setButtonMessage(string $buttonMessage): self
    {
        $this->buttonMessage = $buttonMessage;

        return $this;
    }

    public function getButtonURL(): ?string
    {
        return $this->buttonURL;
    }

    public function setButtonURL(string $buttonURL): self
    {
        $this->buttonURL = $buttonURL;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIsDisplayed(): ?bool
    {
        return $this->isDisplayed;
    }

    public function setIsDisplayed(?bool $isDisplayed): self
    {
        $this->isDisplayed = $isDisplayed;

        return $this;
    }
}
