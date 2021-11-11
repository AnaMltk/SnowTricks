<?php

namespace App\Service;

use Exception;
use App\Entity\Photo;

class PhotoUploader
{
    public function upload($entityManager, $photoData, $photo, $figure = null)
    {
        /** @var UploadedFile $figurePhoto */
        $figurePhoto = $photoData->get('path')->getData();
        $figurePhotoFilename = uniqid() . '.' . $figurePhoto->guessExtension();
       
        // Copy file to directory
        $figurePhoto->move(
            'img', 
            $figurePhotoFilename
        );
        $size = getimagesize('img/'.$figurePhotoFilename);
        return false;
        dump($size); exit;
        $photo->setPath($figurePhotoFilename);
        $photo->setAlt($photoData->get('alt')->getData());
        if (isset($figure)) {
            $photo->setFigure($figure);
        }
        $photo->setCreationDate(new \DateTime());
        $entityManager->persist($photo);
    }
}
