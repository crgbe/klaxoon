<?php

namespace App\Controller;

use App\Entity\Link;
use App\Repository\LinkRepository;
use App\Service\LinkService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class LinkController extends AbstractController
{
    private $em;
    private $linkService;
    private $linkRepository;

    public function __construct(
        EntityManagerInterface $em,
        LinkService $linkService,
        LinkRepository $linkRepository
    )
    {
        $this->em = $em;
        $this->linkService = $linkService;
        $this->linkRepository = $linkRepository;
    }

    /**
     * @Route(
     *     "/links",
     *     name="links_index",
     *     methods={"GET"}
     * )
     */
    public function index()
    {
        $links = $this->linkRepository->findAll();

        return $this->json(
            $links,
            Response::HTTP_OK,
            [],
            ['groups' => ['main']]
        );
    }

    /**
     * @Route(
     *     "/links",
     *     name="links_add",
     *     methods={"POST"}
     * )
     */
    public function add(Request $request)
    {
        $requestAsArray = $request->toArray();
        $link = $this->linkService->createLink($requestAsArray['url']);

        if(!$link){
            return $this->json([
                'customText' => "Désolé, cette URL ne correspond à aucun type pris en charge par l'application"
            ], Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }

        $this->em->persist($link);
        $this->em->flush();

        return $this->json([
            "customText" => "Le nouveau lien a bien été enregistré comme favoris"
        ], Response::HTTP_CREATED);
    }

    /**
     * @Route(
     *     "/links/{id}",
     *     name="links_delete",
     *     methods={"DELETE"},
     *     requirements={"id"="\d+"}
     * )
     */
    public function remove(Link $link)
    {
        $this->em->remove($link);
        $this->em->flush();

        return $this->json([
            'customText' => "Ce favoris a bien été retiré de la liste"
        ], Response::HTTP_NO_CONTENT);
    }
}