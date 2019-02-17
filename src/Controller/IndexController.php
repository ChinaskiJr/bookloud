<?php
/**
 * Created by PhpStorm.
 * User: chinaskijr
 * Date: 17/02/19
 * Time: 16:54
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController {
    /**
     * Welcoming Page
     *
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('home.html.twig');

    }
}