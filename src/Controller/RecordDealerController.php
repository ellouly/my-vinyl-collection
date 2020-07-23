<?php

namespace App\Controller;

use App\Form\RecordDealerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecordDealerController extends AbstractController
{
    /**
     * @Route("/record", name="record_dealer")
     */
    public function spotifySearch (Request $request): Response
    {
        $form = $this->createForm(RecordDealerType::class);
        $form->handleRequest($request);

        return $this->render('record_dealer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}