<?php
/**
 * Created by PhpStorm.
 * User: chinaskijr
 * Date: 17/02/19
 * Time: 16:54
 */

namespace App\Controller;

use App\Entity\Keyword;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Book;
use App\Form\BookType;

class IndexController extends AbstractController {
    /**
     * Welcoming Page
     *
     * @Route("/", name="home")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home() {
        $repository = $this->getDoctrine()->getRepository(Keyword::class);
        $keywords = $repository->findAll();
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $books = $repository->findAll();
        return $this->render('home.html.twig', array(
            'keywords' => $keywords,
            'books' => $books,
        ));
    }

    /**
     * Add a new book into database
     * @Route("/add", name="add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request) {
        $book = new Book();
        // At least one empty textarea will be display for keywords
        $book->setKeywords([new Keyword()]);

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        $returnRender = $this->render('add.html.twig', array(
            'form' => $form->createView(),
        ));

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            $returnRender = $this->home();
        }

        return $returnRender;
    }
}