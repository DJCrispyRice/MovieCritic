<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;

class MovieController extends AbstractController
{
    /**
     * @Route("/movies", name="movie.index")
     */
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'current_menu' => 'movies'
        ]);
    }
}