<?php
# src/AppBundle/Controller/Place/ThemeController.php

namespace AppBundle\Controller\Place;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Form\Type\ThemeType;
use AppBundle\Entity\Theme;

class ThemeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * UserController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @ApiDoc(
     *    description="Récupère les thèmes d'une place",
     *    output= { "class"=Theme::class, "collection"=true, "groups"={"theme"} }
     * )
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     *
     * @Rest\View(serializerGroups={"theme"})
     * @Rest\Get("/places/{id}/themes")
     */
    public function getThemesAction(Request $request)
    {
        $place = $this->em->getRepository('AppBundle:Place')
                          ->find($request->get('id'));

        if (empty($place)) {
            return $this->placeNotFound();
        }

        return $place->getThemes();
    }


    /**
     * @ApiDoc(
     *    description="Récupère les thèmes d'une place",
     *    output= { "class"=Theme::class, "collection"=true, "groups"={"theme"} }
     * )
     *
     * @param Request $request
     * @return Theme|\FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"theme"})
     * @Rest\Post("/places/{id}/themes")
     */
    public function postThemesAction(Request $request)
    {
        $place = $this->em->getRepository('AppBundle:Place')
                          ->find($request->get('id'));

        if (empty($place)) {
            return $this->placeNotFound();
        }

        $theme = new Theme();
        $theme->setPlace($place);
        $form = $this->createForm(ThemeType::class, $theme);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $this->em->persist($theme);
            $this->em->flush();
            return $theme;
        } else {
            return $form;
        }
    }

    private function placeNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
    }
}
