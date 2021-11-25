<?php

namespace App\Service;

use Exception;
use App\Entity\Video;

class VideoUploader
{
    public function upload($entityManager, $videoData, $video, $figure = null)
    {
        /** @var UploadedFile $figureVideo */
        //$figureVideo = $videoData->get('path')->getData();
        //$figurePhotoFilename = uniqid() . '.' . $figureVideo->guessExtension();
       
        // Copy file to directory
       /* $figurePhoto->move(
            'img', 
            $figurePhotoFilename
        );*/
        $rawLink = $videoData->get('link')->getData();
        $pattern = '#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=[0-9]/)[^&\n]+|(?<=v=)[^&\n]+#';
        preg_match($pattern, $rawLink, $matches);
        $cleanLink = 'https://www.youtube.com/embed/'.$matches[0];
        $video->setLink($cleanLink);
        $video->setAlt($videoData->get('alt')->getData());
        if (isset($figure)) {
            $video->setFigure($figure);
        }
        $video->setCreationDate(new \DateTime());
        $entityManager->persist($video);
    }
}