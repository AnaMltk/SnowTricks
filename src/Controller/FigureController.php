<?php

namespace App\Controller;

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
}
