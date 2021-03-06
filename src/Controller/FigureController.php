<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Video;
use App\Service\Slug;
use App\Entity\Figure;
use App\Entity\Comment;
use App\Form\PhotoType;
use App\Form\VideoType;
use App\Form\FigureType;
use App\Form\CommentType;
use App\Service\PhotoUploader;
use App\Service\VideoUploader;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use App\Repository\FigureRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class FigureController extends AbstractController
{
    const MAX_FIGURE = 5;

    /**
     * @Route("/", name="index")
     * @param FigureRepository $figureRepository
     * 
     * @return Response
     */
    public function index(FigureRepository $figureRepository): Response
    {
        $figureCount = $figureRepository->count([]);
        $figures = $figureRepository->findBy([], ['creation_date' => 'DESC'], self::MAX_FIGURE, 0);

        return $this->render('figure/index.html.twig', ['figures' => $figures, 'figureCount' => $figureCount, 'maxFigures' => self::MAX_FIGURE]);
    }

    /**
     * @Route("/loadMore/{offset}", name="loadMore")
     * @param Request $request
     * @param FigureRepository $figureRepository
     * @param  $offset
     * 
     * @return [type]
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
     * @param mixed $id
     * @param FigureRepository $figureRepository
     * @param Request $request
     * @param UserRepository $userRepository
     * @param CommentRepository $commentRepository
     * 
     * @return Response
     */
    public function getFigure($id, FigureRepository $figureRepository, Request $request, CommentRepository $commentRepository): Response
    {
        $figure = $figureRepository->find($id);

        // Les 5 premiers commentaires
        $comments = $commentRepository->findByFigure($id, 0, 5);

        // Nombre de commentaires au total
        $commentCount = count($commentRepository->findBy(['figure' => $id]));

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('newComment', ['id' => $id]),
            'method' => 'POST'
        ]);

        $form->handleRequest($request);

        return $this->render('figure/figure.html.twig', ['figure' => $figure, 'form' => $form->createView(), 'comments' => $comments, 'commentCount' => $commentCount, 'maxComments' => 5]);
    }

    /**
     * @Route("/new", name="new")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param PhotoUploader $photoUploader
     * @param VideoUploader $videoUploader
     * 
     * @return Response
     */
    public function new(EntityManagerInterface $entityManager, Request $request, PhotoUploader $photoUploader, VideoUploader $videoUploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = $this->getUser();
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
            $videos = $form->get('video');
            foreach ($videos as $videoData) {
                $video = new Video();
                $videoUploader->upload($entityManager, $videoData, $video, $figure);
            }

            // Photos
            $photos = $form->get('photo');
            foreach ($photos as $photoData) {
                $photo = new Photo();
                $photoUploader->upload($entityManager, $photoData, $photo, $figure);
            }

            $entityManager->persist($figure);
            $entityManager->flush();
            $this->addFlash('success', 'Le figure a ??t?? cre?? avec success');
            return $this->redirectToRoute('index');
        }

        return $this->renderForm('figure/newFigure.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/edit/{id}-{slug}", name="edit")
     * @param mixed $id
     * @param FigureRepository $figureRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param PhotoUploader $photoUploader
     * @param VideoUploader $videoUploader
     * 
     * @return Response
     */
    public function edit($id, FigureRepository $figureRepository, Request $request, EntityManagerInterface $entityManager, PhotoUploader $photoUploader, VideoUploader $videoUploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $figure = $figureRepository->find($id);

        $form = $this->createForm(FigureType::class, $figure);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $figure->setModificationDate(new \DateTime());
            // Videos
            $videos = $form->get('video');
            foreach ($videos as $videoData) {
                $video = new Video();
                $videoUploader->upload($entityManager, $videoData, $video, $figure);
            }
            // Photos
            $photos = $form->get('photo');
            foreach ($photos as $photoData) {
                $photo = new Photo();
                $photoUploader->upload($entityManager, $photoData, $photo, $figure);
            }

            $entityManager->persist($figure);
            $entityManager->flush();
        }

        return $this->render('figure/editFigure.html.twig', ['figure' => $figure, 'form' => $form->createView()]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Figure $figure
     * 
     * @return Response
     */
    public function delete(Figure $figure): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($figure);
        $entityManager->flush();
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/edit_photo/{id}", name="edit_photo")
     * @param Photo $photo
     * @param Request $request
     * @param PhotoUploader $photoUploader
     * @param Slug $slug
     * 
     * @return Response
     */
    public function editPhoto(Photo $photo, Request $request, PhotoUploader $photoUploader, Slug $slug): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $error = '';
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $photoUploader->upload($entityManager, $form, $photo);
            $entityManager->flush();
            $figure_id = $form->getData()->getFigure()->getId();
            $figure_name = $form->getData()->getFigure()->getName();

            return $this->redirectToRoute('edit', ['id' => $figure_id, 'slug' => $slug->slugify($figure_name)]);
        }

        return $this->renderForm('figure/editPhoto.html.twig', [
            'form' => $form,
            'error' => $error,
            'figure' => $photo->getFigure()
        ]);
    }

    /**
     * @Route("/delete_photo/{id}", name="delete_photo")
     * @param Request $request
     * @param Photo $photo
     * 
     * @return Response
     */
    public function deletePhoto(Request $request, Photo $photo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($photo);
        $entityManager->flush();
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }

    /**
     * @Route("/edit_video/{id}", name="edit_video")
     * @param mixed $id
     * @param Request $request
     * @param VideoRepository $videoRepository
     * @param VideoUploader $videoUploader
     * @param Slug $slug
     * 
     * @return Response
     */
    public function editVideo($id, Request $request, VideoRepository $videoRepository, VideoUploader $videoUploader, Slug $slug): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $video = $videoRepository->find($id);
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {

            //$videoData = $form->get('link')->getData();
            $videoUploader->upload($entityManager, $form, $video);
            //$video->setLink($videoData);
            //$video->setAlt($form->get('alt')->getData());
            //$entityManager->persist($video);
            $entityManager->flush();
            $figure_id = $form->getData()->getFigure()->getId();
            $figure_name = $form->getData()->getFigure()->getName();
            return $this->redirectToRoute('edit', ['id' => $figure_id, 'slug' => $slug->slugify($figure_name)]);
        }
        return $this->renderForm('figure/editVideo.html.twig', [
            'form' => $form,
            'figure' => $video->getFigure()
        ]);
    }

    /**
     * @Route("/delete_video/{id}", name="delete_video")
     * @param Request $request
     * @param Video $video
     * 
     * @return Response
     */
    public function deleteVideo(Request $request, Video $video): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($video);
        $entityManager->flush();
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
}
