<?php

namespace App\Service;

use App\Entity\Interfaces\EntityImageInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FileUploader
{

    public function __construct(private string $publicPath)
    {
        
    }

    public function upload(EntityImageInterface $entity, UploadedFile $file): void
    {
        $directory = $this->publicPath.$entity->getImageDirectory();
        $fileName = sprintf("%s-%s.%s", explode(".", $file->getClientOriginalName())[0] ?? "avatar", uniqid(), $file->guessClientExtension());
        $file->move($directory, $fileName);
        $entity->setImage($fileName);
    }
}