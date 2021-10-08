<?php

namespace App\Controller;


use App\Repository\CommentRepository;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommentController extends AbstractController
{
    const MAX_COMMENT = 1;
    /**
     * @Route("/loadMoreComments/{offset}", name="loadMoreComments")
     */
    public function loadMoreComments(Request $request, CommentRepository $commentRepository, $offset = self::MAX_COMMENT)
    {


        if ($request->isXmlHttpRequest()) {


            $comments = $commentRepository->findBy([], ['creation_date' => 'DESC'], self::MAX_COMMENT, $offset);
        }

        return $this->render('comment/comments.html.twig', ['comments' => $comments]);
    }

    /**
     * @Route("/newComment", name="newComment")
     */
    public function newComment(Request $request)
    {
        $form = $this->createForm(CommentType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $comment = $form->getData();
            //$comment->setFigure($figure);

            $comment->setCreationDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
        }
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
}
