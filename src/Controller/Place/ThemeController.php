<?php

namespace App\Controller\Place;

use App\Entity\Place;
use App\Entity\Theme;
use App\Form\Type\ThemeType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ThemeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * UserController constructor.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \FOS\RestBundle\View\View
     *
     * @Rest\View(serializerGroups={"theme"})
     *
     * @Rest\Get("/places/{id}/themes")
     */
    public function getThemesAction(Request $request)
    {
        $place = $this->em->getRepository(Place::class)
                          ->find($request->get('id'));

        if (empty($place)) {
            return $this->placeNotFound();
        }

        return $place->getThemes();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"theme"})
     *
     * @Rest\Post("/places/{id}/themes")
     */
    public function postThemesAction(Request $request): \App\Entity\Theme|\FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
    {
        $place = $this->em->getRepository(Place::class)
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
