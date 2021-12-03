<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Figure;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    const MAX_COMMENT = 1;
    /**
     * @Route("/load-more-comments/{id}/{start}",name="load_more_comments")
     */
    public function load_more_comments(Request $request, CommentRepository $commentRepository, $start = self::MAX_COMMENT, $id = 0)
    {
        
        $comments = [];
       // if ($request->isXmlHttpRequest()) {
            $comments = $commentRepository->findByFigure($id, $start);
           // dump($comments); exit;
            return $this->render(
                'comment/comment_more.html.twig',
                ['comments' => $comments]
            );
             
            
       // }
      
        return $this->render(
            'empty.html.twig'
        );
    }
    /**
     * @Route("newComment/{id}", name="newComment")
     */
    public function newComment(Request $request, Figure $figure)
    {
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
