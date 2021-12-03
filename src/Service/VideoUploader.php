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
        //$sources = ['youtube', 'dailtmotion', 'vimeo'];
        $patternTest = "#(?:dailymotion\.com(?:\/video|\/hub)|dai\.ly)\/([0-9a-z]+)(?:[\-_0-9a-zA-Z]+\#video=([a-z0-9]+))?#";
        $patterns = [
            'youtube' => '#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=[0-9]/)[^&\n]+|(?<=v=)[^&\n]+#', 
            'dailymotion' => '#(?:dailymotion\.com(?:\/video|\/hub)|dai\.ly)\/([0-9a-z]+)(?:[\-_0-9a-zA-Z]+\#video=([a-z0-9]+))?#', 
            //'vimeo' => 'vimeo.*?([0-9]+$)'
        ];
        foreach ($patterns as $source => $pattern) {
            //var_dump($pattern); 
            //var_dump($patternTest); die;
            preg_match($pattern, $rawLink, $matches);
            //dump($matches); 
            //dump($source);
            //dump($rawLink);
            //dump($pattern); 
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
          
            //$cleanLink = 'https://www.youtube.com/embed/' . $matches[0];
        }
        //die;
        /*$pattern = "#(?:dailymotion\.com(?:\/video|\/hub)|dai\.ly)\/([0-9a-z]+)(?:[\-_0-9a-zA-Z]+\#video=([a-z0-9]+))?#";
        preg_match($pattern, $rawLink, $matches);
        dump($matches); die;
        $cleanLink = 'https://www.dailymotion.com/embed/video/' . $matches[1];*/
        $video->setLink($cleanLink);
        $video->setAlt($videoData->get('alt')->getData());
        if (isset($figure)) {
            $video->setFigure($figure);
        }
        $video->setCreationDate(new \DateTime());
        $entityManager->persist($video);
    }
}
