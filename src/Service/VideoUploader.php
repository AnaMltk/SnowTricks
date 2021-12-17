<?php

namespace App\Service;

use Exception;
use App\Entity\Video;

class VideoUploader
{
    public function upload($entityManager, $videoData, $video, $figure = null)
    {
        /** @var UploadedFile $figureVideo */
       
        $rawLink = $videoData->get('link')->getData();
        $patterns = [
            'youtube' => '#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=[0-9]/)[^&\n]+|(?<=v=)[^&\n]+#', 
            'dailymotion' => '#(?:dailymotion\.com(?:\/video|\/hub)|dai\.ly)\/([0-9a-z]+)(?:[\-_0-9a-zA-Z]+\#video=([a-z0-9]+))?#', 
            //'vimeo' => 'vimeo.*?([0-9]+$)'
        ];
        foreach ($patterns as $source => $pattern) {
            preg_match($pattern, $rawLink, $matches); 
            if(isset($matches[0])){
                switch ($source) {
                    case 'youtube':
                        $cleanLink = 'https://www.youtube.com/embed/' . $matches[0];
                        break;
                    case 'dailymotion':
                        $cleanLink = 'https://www.dailymotion.com/embed/video/' . $matches[1];
                        break;
                    case 'vimeo':
                        $cleanLink = '<iframe src="https://player.vimeo.com/video/' . $matches[0];
                            break;
                }
            }
          
        }
        $video->setLink($cleanLink);
        $video->setAlt($videoData->get('alt')->getData());
        if (isset($figure)) {
            $video->setFigure($figure);
        }
        $video->setCreationDate(new \DateTime());
        $entityManager->persist($video);
    }
}
