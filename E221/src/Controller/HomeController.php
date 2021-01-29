<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController {

    /**
     * @Route("/hello/{prenom}", name="hello")
     * Montre la page qui dit bonjour
     */
    public function hello(){
        return new Response("Bonjour ...");
    }


    /**
     * @Route("/", name="homepage")
     */
    public function home()
    {
        return $this->render('home.html.twig', [
            'title' => "Bonjour à tous",
            'age' => 12
        ]);
    }
}

?>