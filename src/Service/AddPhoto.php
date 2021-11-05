<?php

namespace App\Service;

use App\Entity\Photo;

class AddPhoto
{
    public function add($form, $figure, $entityManager)
    {
        $photos = $form->get('photo');
        foreach ($photos as $photoData) {
            /** @var UploadedFile $figurePhoto */
            $figurePhoto = $photoData->get('path')->getData();
            $figurePhotoFilename = uniqid() . '.' . $figurePhoto->guessExtension();

            // Copy file to directory
            $figurePhoto->move(
                'img', //TODO:  define folder destination as parameter
                $figurePhotoFilename
            );
            $photo = new Photo();
            $photo->setPath($figurePhotoFilename);
            $photo->setAlt($photoData->get('alt')->getData());
            $photo->setFigure($figure);
            $photo->setCreationDate(new \DateTime());
            $entityManager->persist($photo);
        }
    }
}
