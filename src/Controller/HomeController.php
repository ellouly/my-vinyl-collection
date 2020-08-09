<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home_index")
     */
    public function index() :Response
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/admin", name="home_admin")
     */
    public function homeAdmin() :Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('home.admin.html.twig');
    }
}