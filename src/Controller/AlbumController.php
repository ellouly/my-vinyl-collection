<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Form\RecordDealerType;
use App\Repository\AlbumRepository;
use App\Service\SpotifyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/album")
 *
 */
class AlbumController extends AbstractController
{
    /**
     * @Route("/index", name="album_index", methods={"GET"})
     * @param AlbumRepository $albumRepository
     * @return Response
     */
    public function index(AlbumRepository $albumRepository): Response
    {
        $albumsAmount = $this->getDoctrine()
            ->getRepository(Album::class)
            ->countAll();

        return $this->render('album/index.jukebox.html.twig', [
            'albums' => $albumRepository->sortByArtist(),
            'amount' => $albumsAmount
        ]);
    }

    /**
     * @Route("/record", name="album_record_dealer", methods={"GET","POST"})
     */
    public function recordDealer(Request $request, SpotifyService $spotify): Response
    {
        $countMax = $this->getDoctrine()
            ->getRepository(Album::class)
            ->countAll();

        if ($countMax >= 50) {
            $this->addFlash('Warning', "Votre jukebox est plein !!");

            return $this->redirectToRoute('album_index');
        }

        $form = $this->createForm(RecordDealerType::class);
        $form->handleRequest($request);

        $newAlbum = new Album();

        if ($form->isSubmitted() && $form->isValid()) {

            $spotify->authenticate();
            $spotify->searchAlbum();

            $newAlbum->setName($response['name'])
                ->setYear($response['release_date'])
                ->setImage($response['images'])
                ->setArtist($response['artists'])
                ->setCategory($response['genres'])
                ->setSpotifyId($response['id']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newAlbum);
            $entityManager->flush();

            return $this->redirectToRoute('album_index');
        }

        return $this->render('album/show.html.twig', [
            'album' => $newAlbum,
        ]);
    }

    /**
     * @Route("/{id}", name="album_show", methods={"GET"})
     */
    public function show(Album $album): Response
    {
        return $this->render('album/show.html.twig', [
            'album' => $album,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="album_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Album $album): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('album_index');
        }

        return $this->render('album/edit.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="album_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Album $album): Response
    {
        if ($this->isCsrfTokenValid('delete' . $album->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($album);
            $entityManager->flush();
        }

        return $this->redirectToRoute('album_index');
    }
}
