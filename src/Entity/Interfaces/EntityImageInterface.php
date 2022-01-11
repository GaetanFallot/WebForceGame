<?php

namespace App\Entity\Interfaces;

interface EntityImageInterface{
    
    public function getImageSrc(): ?string;

    public function getImageDirectory(): string;

    public function getImage(): ?string;
    
    public function setImage(string $image): self;
}