<?php

namespace App\Item;

class ItemResponse
{

    public string $category;
    public string $name;
    public string $effectText;
    public string $descriptionText;
    public string $imageUrl;

    public function __construct()
    {
        $this->name             = '';
        $this->category         = '';
        $this->effectText       = '';
        $this->descriptionText  = '';
        $this->imageUrl         = '';
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = ucwords(str_replace('-', ' ', $category));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = ucwords(str_replace('-', ' ', $name));
    }

    /**
     * @return string
     */
    public function getEffectText(): string
    {
        return $this->effectText;
    }

    /**
     * @param string $effectText
     */
    public function setEffectText(string $effectText): void
    {
        $this->effectText = $effectText;
    }

    /**
     * @return string
     */
    public function getDescriptionText(): string
    {
        return $this->descriptionText;
    }

    /**
     * @param string $descriptionText
     */
    public function setDescriptionText(string $descriptionText): void
    {
        $this->descriptionText = $descriptionText;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }
}
