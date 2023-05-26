<?php

namespace App\Controller;

use App\Entity\Place;
use App\Form\Type\PlaceType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlaceController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    /**
     * @Rest\View(serializerGroups={"place"})
     *
     * @Rest\Get("/places")
     */
    public function getPlacesAction()
    {
        $places = $this->em->getRepository(Place::class)
                           ->findAll();

        return $places;
    }

    /**
     * @return object|void|null
     *
     * @Rest\View(serializerGroups={"place"})
     *
     * @Rest\Get("/places/{id}")
     */
    public function getPlaceAction(Request $request)
    {
        $place = $this->em->getRepository(Place::class)
                          ->find($request->get('id'));

        if (empty($place)) {
            return $this->placeNotFound();
        }

        return $place;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"place"})
     *
     * @Rest\Post("/places")
     */
    public function postPlacesAction(Request $request): Place|FormInterface
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $this->em->persist($place);
            $this->em->flush();

            return $place;
        } else {
            return $form;
        }
    }

    /**
     * @return array
     *
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT, serializerGroups={"place"})
     *
     * @Rest\Delete("/places/{id}")
     */
    public function removePlaceAction(Request $request)
    {
        $place = $this->em->getRepository(Place::class)
                          ->find($request->get('id'));

        if (!$place) {
            return $this->placeNotFound();
        }

        foreach ($place->getPrices() as $price) {
            $this->em->remove($price);
        }

        $this->em->remove($place);
        $this->em->flush();
    }

    /**
     * @return object|FormInterface|void|null
     *
     * @Rest\View(serializerGroups={"place"})
     *
     * @Rest\Patch("/places/{id}")
     */
    public function patchPlaceAction(Request $request)
    {
        return $this->updatePlace($request, false);
    }

    /**
     * @return object|FormInterface|void|null
     */
    private function updatePlace(Request $request, $clearMissing)
    {
        $place = $this->em->getRepository(Place::class)
                          ->find($request->get('id'));

        if (empty($place)) {
            return $this->placeNotFound();
        }

        $form = $this->createForm(PlaceType::class, $place);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $this->em->persist($place);
            $this->em->flush();

            return $place;
        } else {
            return $form;
        }
    }

    private function placeNotFound(): never
    {
        throw new NotFoundHttpException('Place not found');
    }
}
