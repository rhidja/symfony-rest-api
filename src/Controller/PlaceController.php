<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Place;
use App\Form\Type\PlaceType;
use App\Repository\PlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlaceController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /**
     * @return Place[]
     */
    #[Rest\View(serializerGroups: ['place'])]
    #[Rest\Get('/places')]
    public function getPlacesAction(PlaceRepository $placeRepository): array
    {
        return $placeRepository->findAll();
    }

    #[Rest\View(serializerGroups: ['place'])]
    #[Rest\Get('/places/{id}')]
    public function getPlaceAction(Place $place): Place
    {
        return $place;
    }

    #[Rest\View(statusCode: Response::HTTP_CREATED, serializerGroups: ['place'])]
    #[Rest\Post('/places')]
    public function postPlacesAction(Request $request): Place|FormInterface
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $this->em->persist($place);
            $this->em->flush();

            return $place;
        }

        return $form;
    }

    #[Rest\View(statusCode: Response::HTTP_NO_CONTENT, serializerGroups: ['place'])]
    #[Rest\Delete('/places/{id}')]
    public function removePlaceAction(Place $place): void
    {
        foreach ($place->getPrices() as $price) {
            $this->em->remove($price);
        }

        $this->em->remove($place);
        $this->em->flush();
    }

     #[Rest\View(serializerGroups: ['place'])]
     #[Rest\Patch('/places/{id}')]
    public function patchPlaceAction(Request $request, Place $place): Place|FormInterface
    {
        return $this->updatePlace($request, $place, false);
    }

    private function updatePlace(Request $request, Place $place, $clearMissing): Place|FormInterface
    {
        $form = $this->createForm(PlaceType::class, $place);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $this->em->persist($place);
            $this->em->flush();

            return $place;
        }

        return $form;
    }
}
