<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Photo;
use App\Entity\Video;
use App\Entity\Figure;
use App\Entity\Comment;
use App\Form\PhotoType;
use App\Form\VideoType;
use App\Form\FigureType;
use App\Form\CommentType;
use App\Service\AddPhoto;
use App\Repository\UserRepository;
use App\Repository\PhotoRepository;
use App\Repository\VideoRepository;
use App\Repository\FigureRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class FigureController extends AbstractController
{
    const MAX_FIGURE = 5;

    /**
     * @Route("/", name="index")
     */
    public function index(FigureRepository $figureRepository): Response
    {
        $figureCount = $figureRepository->count([]);
        $figures = $figureRepository->findBy([], ['creation_date' => 'DESC'], self::MAX_FIGURE, 0);

        //dump($figures);

        return $this->render('figure/index.html.twig', ['figures' => $figures, 'figureCount' => $figureCount, 'maxFigures' => self::MAX_FIGURE]);
    }
    /**
     * @Route("/loadMore/{offset}", name="loadMore")
     */
    public function loadMore(Request $request, FigureRepository $figureRepository, $offset = self::MAX_FIGURE)
    {


        if ($request->isXmlHttpRequest()) {


            $figures = $figureRepository->findBy([], ['creation_date' => 'DESC'], self::MAX_FIGURE, $offset);
        }

        return $this->render('figure/figures.html.twig', ['figures' => $figures]);
    }



    /**
     * @Route("/figure/{id}-{slug}", name="getFigure")
     */
    public function getFigure($id, FigureRepository $figureRepository, Request $request, UserRepository $userRepository, CommentRepository $commentRepository): Response
    {
        $figure = $figureRepository->find($id);

        /*$comments = $figure->getComments();
        $comments = $commentRepository->findBy([], ['creation_date' => 'DESC'], self::MAX_COMMENT, 0);
        $commentCount = $commentRepository->count([]);
        dump($comments);
        $comment = new Comment();*/
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('newComment'),
            'method' => 'POST'
        ]);

        $form->handleRequest($request);
        /*if ($form->isSubmitted() && $form->isValid()) {

            $comment = $form->getData();
            $comment->setFigure($figure);

            $comment->setCreationDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
        }*/



        return $this->render('figure/figure.html.twig', ['figure' => $figure, 'form' => $form->createView()]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(UserRepository $userRepository, EntityManagerInterface $entityManager, Request $request, AddPhoto $addPhoto): Response
    {
        $user = $userRepository->find(6);
        $figure = new Figure();

        $form = $this->createForm(FigureType::class, $figure);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // General
            $figure = $form->getData();
            $figure->setUser($user);
            $figure->setCreationDate(new \DateTime());
            $figure->setModificationDate(new \DateTime());

            // Videos
            $videos = $form->get('video')->getData();
            foreach ($videos as $video) {
                $figureVideo = new Video();
                $figureVideo->setLink($video->getLink());
                $figureVideo->setAlt($video->getAlt());
                $figureVideo->setCreationDate(new \Datetime());
                $figureVideo->setFigure($figure);
                $entityManager->persist($figureVideo);
            }

            // Photos
            /*$photos = $form->get('photo');
            foreach ($photos as $photoData) {
                /** @var UploadedFile $figurePhoto */
            /*$figurePhoto = $photoData->get('path')->getData();
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
            }*/
            $addPhoto->add($form, $figure, $entityManager);
            $entityManager->persist($figure);
            $entityManager->flush();
        }

        return $this->renderForm('figure/newFigure.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/edit/{id}-{slug}", name="edit")
     */
    public function edit($id, FigureRepository $figureRepository, Request $request): Response
    {
        $figure = $figureRepository->find($id);

        $form = $this->createForm(FigureType::class, $figure);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $figure->setModificationDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($figure);
            $entityManager->flush();
        }

        return $this->render('figure/editFigure.html.twig', ['figure' => $figure, 'form' => $form->createView()]);
    }
    /**
     * @Route("/edit_photo/{id}", name="edit_photo")
     */
    public function editPhoto($id, Request $request, PhotoRepository $photoRepository): Response
    {
        $photo = $photoRepository->find($id);
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $photoData = $form->get('path')->getData();
            $photoFilename = uniqid() . '.' . $photoData->guessExtension();
            $photoData->move(
                'img',
                $photoFilename
            );

            $photo->setPath($photoFilename);
            $photo->setAlt($form->get('alt')->getData());
            $entityManager->persist($photo);
            $entityManager->flush();
        }
        return $this->renderForm('figure/editPhoto.html.twig', [
            'form' => $form,
        ]);
    }

    public function editVideo($id, Request $request, VideoRepository $videoRepository): Response
    {
        $video = $videoRepository->find($id);
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $videoData = $form->get('link')->getData();

            $video->setLink($videoData);
            $video->setAlt($form->get('alt')->getData());
            $entityManager->persist($video);
            $entityManager->flush();
        }
        return $this->renderForm('figure/editPhoto.html.twig', [
            'form' => $form,
        ]);
    }
}
