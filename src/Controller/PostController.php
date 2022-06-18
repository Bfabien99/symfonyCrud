<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post')]
class PostController extends AbstractController
{   

    /**
     * @param ArticleRepository $repository
     */
    private $repository;

     /**
     * @param EntityManagerInterface $em
     */
    private $em;

    public function __construct(ArticleRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    #[Route('/', name: 'post.index')]
    public function index(): Response
    {
        $articles = $this->repository->findAll();
        return $this->render('post/index.html.twig', compact('articles'));
    }

    #[Route('/add', name: 'post.add')]
    public function add(Request $request){
        $article = new Article;

        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ... perform some action, such as saving the task to the database
            $this->em->persist($article);
            $this->em->flush();

            return $this->redirectToRoute('post.index');
        }

        return $this->render('post/add.html.twig', [
            "article" => $article,
            'form' => $form->createView()
        ]);
    }

    #[Route('/show/{id}', name: 'post.show')]
    public function show(Article $article, Request $request){
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ... perform some action, such as saving the task to the database
            $this->em->flush();

            return $this->redirectToRoute('post.index');
        }

        return $this->render('post/show.html.twig', [
            "article" => $article,
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'post.delete')]
    public function delete(Article $article){
            $this->em->remove($article);
            $this->em->flush();
            return $this->redirectToRoute('post.index');
    }
}
