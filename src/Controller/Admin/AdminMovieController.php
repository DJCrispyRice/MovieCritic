<?php
namespace App\Controller\Admin;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminMovieController extends AbstractController {
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
     * @Route("/admin", name="admin.movie.index")
     * @return Response
     */
    public function index(): Response
    {
        $movies = $this->repo->findAll();
        return $this->render('admin/movie/index.html.twig', compact('movies'));
    }

    /**
     * @Route("/admin/movie/create", name="admin.movie.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($movie);
            $this->em->flush();
            $this->addFlash('success', "The movie has been created");
            return $this->redirectToRoute('admin.movie.index');
        }

        return $this->render('admin/movie/new.html.twig', [
            'movie' => $movie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/movie/{id}", name="admin.movie.edit", methods="GET|POST")
     * @param Movie $movie
     * @return Response
     */
    public function edit(Movie $movie, Request $request): Response
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', "The movie has been edited");
            return $this->redirectToRoute('admin.movie.index');
        }

        return $this->render('admin/movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/movie/delete/{id}", name="admin.movie.delete", methods="POST")
     * @param Movie $movie
     * @param Request $request
     * @return Response
     */
    public function delete(Movie $movie, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$movie->getId(), $request->get('_token'))) {
            $this->em->remove($movie);
            $this->em->flush();
            $this->addFlash('success', "The movie has been deleted");
        }
        return $this->redirectToRoute('admin.movie.index');
    }
}