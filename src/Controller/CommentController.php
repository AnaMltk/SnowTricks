<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    const MAX_COMMENT = 5;

    /**
     * @Route("/load-more-comments/{id}/{start}",name="load_more_comments")
     * @param Request $request
     * @param CommentRepository $commentRepository
     * @param  $start
     * @param int $id
     * 
     * @return [type]
     */
    public function load_more_comments(Request $request, CommentRepository $commentRepository, $start = self::MAX_COMMENT, $id = 0)
    {
        $comments = [];
        if ($request->isXmlHttpRequest()) {
            $comments = $commentRepository->findByFigure($id, $start, self::MAX_COMMENT);
            return $this->render(
                'comment/comment_more.html.twig',
                ['comments' => $comments]
            );
        }
        return $this->render(
            'empty.html.twig'
        );
    }

    /**
     * @Route("newComment/{id}", name="newComment")
     * @param Request $request
     * @param Figure $figure
     * 
     * @return Response
     */
    public function newComment(Request $request, Figure $figure): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(CommentType::class);
        $user = $this->getUser();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $comment = $form->getData();
            $comment->setFigure($figure);
            $comment->setUser($user);
            $comment->setCreationDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
        }
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
}
