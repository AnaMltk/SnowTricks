<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Figure;
use App\Entity\Comment;
use App\Form\FigureType;
use App\Form\CommentType;
use App\Repository\UserRepository;
use App\Repository\PhotoRepository;
use App\Repository\VideoRepository;
use App\Repository\FigureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class FigureController extends AbstractController
{
    const MAX_FIGURE = 1;
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
    public function getFigure($id, FigureRepository $figureRepository, Request $request): Response
    {
        $figure = $figureRepository->find($id);

        $comment = new Comment();

        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $comment = $form->getData();

            $comment->setFigure($figure);

            $comment->setCreationDate(new \DateTime());
            $comment->setUserId(5);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
        }

        return $this->render('figure/figure.html.twig', ['figure' => $figure, 'form' => $form->createView()]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(UserRepository $userRepository, Request $request): Response
    {
        $user = $userRepository->find(5);
        $figure = new Figure();

        $form = $this->createForm(FigureType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photos = $form->get('photo');
            /*foreach ($photos as $photo) {
                dump($photo->get('path')->getData());
            }*/
            $videos = $form->get('video');

            $figure = $form->getData();
            dump($figure);
            $figure->setUser($user);

            $figure->setCreationDate(new \DateTime());
            $figure->setModificationDate(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($figure);
            $entityManager->flush();
        }


        return $this->renderForm('figure/newFigure.html.twig', [
            'form' => $form,
        ]);
    }
}
