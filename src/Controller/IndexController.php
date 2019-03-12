<?php
/**
 * Created by PhpStorm.
 * User: chinaskijr
 * Date: 17/02/19
 * Time: 16:54
 */

namespace App\Controller;

use App\Entity\Epoch;
use App\Entity\GeographicalArea;
use App\Entity\Keyword;
use App\Form\EpochType;
use App\Form\GeographicalAreaType;
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
     * Same as the editBook method, it's just like we're editing an empty book...
     * @Route("/add", name="book_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request) {
        $book = new Book();
        $book->setEpoch(new Epoch());
        $book->setGeographicalArea(new GeographicalArea());

        return self::editBook($request, $book);
    }

    /**
     * @Route("/bookloud/{id}", name="show_bookloud")
     * @param Keyword $keyword
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showBookloud(Keyword $keyword) {
        return $this->render('bookloud.html.twig', array(
            'keyword' => $keyword,
        ));
    }

    /**
     * @param Book $book
     * @Route ("/book/{id}", name="show_book", requirements={"id":"\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showBook(Book $book) {
        return $this->render('book.html.twig', array(
            'book' => $book,
        ));
    }

    /**
     * @Route("/books", name="show_books")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showBooks() {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $books = $repository->findAll();
        return $this->render('listBooks.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @param Request $request
     * @param Book $book
     * @Route("/edit/book/{id}", name="edit_book",requirements={"id":"\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editBook(Request $request, Book $book) {
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
            // Check for existing keywords
            $repository = $this->getDoctrine()->getRepository(Keyword::class);

            foreach($book->getKeywords() as $newKeyword) {
                $databaseKeyword = $repository->findOneBy(array('name' => $newKeyword->getName()));
                if ($databaseKeyword) {
                    $book->removeKeyword($newKeyword);
                    $book->addKeyword($databaseKeyword);
                }
            }
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

    /**
     * @param Book $book
     * @Route ("/delete/book/{id}", name="delete_book", requirements={"id":"\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteBook(Book $book) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        // We don't to left any orphans behind us
        $bookKeywords = $book->getKeywords();
        foreach ($bookKeywords as $bookKeyword) {
            if (count($bookKeyword->getBooks()) <= 1) {
                $em->remove($bookKeyword);
            }
        }

        $bookRegion = $book->getGeographicalArea();
        if (count($bookRegion->getBooks()) <= 1) {
            $em->remove($bookRegion);
        }

        $bookEpoch = $book->getEpoch();
        if (count($bookEpoch->getBooks()) <= 1) {
            $em->remove($bookEpoch);
        }

        $em->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * @param Keyword $keyword
     * @Route("/delete/bookloud/{id}", name="delete_keyword",requirements={"id":"\d+"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteKeyword(Keyword $keyword) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($keyword);
        $em->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * Add a new epoch into database
     * @Route("/add-epoch", name="add_epoch")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addEpoch(Request $request) {
        $epoch = new Epoch();
        $form = $this->createForm(EpochType::class, $epoch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($epoch);
            $em->flush();
            $returnRender = $this->redirectToRoute('home');
        } else {
            $returnRender = $this->render('addEpoch.html.twig', array(
                'form' => $form->createView(),
            ));
        }

        return $returnRender;
    }

    /**
     * @Route("/epochs", name="show_epochs")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showEpochs() {
        $repository = $this->getDoctrine()->getRepository(Epoch::class);
        $epochs = $repository->findAll();
        return $this->render('listEpochs.html.twig', [
            'epochs' => $epochs
        ]);
    }

    /**
     * @param Epoch $epoch
     * @Route("/epoch/{id}", name="show_epoch", requirements={"id":"\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showEpoch(Epoch $epoch) {
        return $this->render('epoch.html.twig', array(
            'epoch' => $epoch,
        ));
    }

    /**
     * @param Epoch $epoch
     * @Route("/delete/epoch/{id}", name="delete_epoch",requirements={"id":"\d+"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteEpoch(Epoch $epoch) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($epoch);
        $em->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * Add a new Geographical Area into database
     * @Route("/add-region", name="add_region")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addGeographicalArea(Request $request) {
        $geographicalArea = new GeographicalArea();
        $form = $this->createForm(GeographicalAreaType::class, $geographicalArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($geographicalArea);
            $em->flush();
            $returnRender = $this->redirectToRoute('home');
        } else {
            $returnRender = $this->render('addGeographicalArea.html.twig', array(
                'form' => $form->createView(),
            ));
        }

        return $returnRender;
    }

    /**
     * @Route("/regions", name="show_regions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showRegions() {
        $repository = $this->getDoctrine()->getRepository(GeographicalArea::class);
        $regions = $repository->findAll();
        return $this->render('listRegions.html.twig', [
            'regions' => $regions
        ]);
    }


    /**
     * @param GeographicalArea $region
     * @Route("/region/{id}", name="show_region", requirements={"id":"\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showRegion(GeographicalArea $region) {
        return $this->render('region.html.twig', array(
            'region' => $region,
        ));
    }

    /**
     * @param GeographicalArea $region
     * @Route("/delete/region/{id}", name="delete_region",requirements={"id":"\d+"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteRegion(GeographicalArea $region) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($region);
        $em->flush();
        return $this->redirectToRoute('home');
    }
}