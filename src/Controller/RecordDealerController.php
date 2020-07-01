<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecordDealerController extends AbstractController
{
    /**
     * @Route("/record", name="record_dealer")
     */
    public function deal()
    {
        return $this->render('record_dealer.html.twig'
        );
    }
}