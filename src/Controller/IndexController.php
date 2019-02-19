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
     * @Route("/add", name="book_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request) {
        $book = new Book();

        // As the keywords form are made with JS, we have to count them after the request
        if ($request->isMethod('POST')) {
            $nbKeywords = $request->request->get('book')["keywords"];
            for ($i = 0 ; $i <= count($nbKeywords) ; $i++) {
                $book->addKeyword(new Keyword());
            }
        }

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($book);
            $em->flush();
            $returnRender = $this->redirectToRoute('home');
        } else {
            $returnRender = $this->render('add.html.twig', array(
                'form' => $form->createView(),
            ));
        }

        return $returnRender;
    }

}