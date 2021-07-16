<?php 
namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Twig\Environment;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param MovieRepository $repo
     * @return Response
     */
    public function index(MovieRepository $repo): Response
    {
        $latestMovies = $repo->findFiveLatest();

        return $this->render('pages/home.html.twig', [
            'latestMovies' => $latestMovies
        ]);
    }
}