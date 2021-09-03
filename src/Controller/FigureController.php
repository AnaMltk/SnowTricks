<?php

namespace App\Controller;

use App\Repository\PhotoRepository;
use App\Repository\FigureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FigureController extends AbstractController
{
    const MAX_FIGURE = 2;
    /**
     * @Route("/", name="index")
     */
    public function index(FigureRepository $figureRepository): Response
    {
        $figures = $figureRepository->findBy([], ['creation_date' => 'DESC'], self::MAX_FIGURE, 0);

        /**/
        dump($figures);

        return $this->render('figure/index.html.twig', ['figures' => $figures]);
    }
    /**
     * @Route("/loadMore", name="loadMore")
     */
    public function loadMore(Request $request, FigureRepository $figureRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $figures = $figureRepository->findBy([], ['creation_date' => 'DESC'], self::MAX_FIGURE, self::MAX_FIGURE);
        }
        return $this->render('figure/figures.html.twig', ['figures' => $figures]);
    }
}
