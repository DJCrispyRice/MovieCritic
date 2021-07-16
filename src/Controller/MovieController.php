<?php 
namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;

class MovieController extends AbstractController
{
    /**
     * @var MovieRepository
     */
    private $repo;

    /**
     * @var ObjectManager
     */
    private $em;
    
    public function __construct(MovieRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }
    
    /**
     * @Route("/movies", name="movie.index")
     */
    public function index(): Response
    {   
        $movie = $this->repo->find(1);
        dump($movie);
        
        return $this->render('movie/index.html.twig', [
            'current_menu' => 'movies'
        ]);
    }
}