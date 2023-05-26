<?php

namespace App\Controller\Place;

use App\Entity\Place;
use App\Entity\Price;
use App\Form\Type\PriceType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PriceController extends AbstractController
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
     * @Rest\View(serializerGroups={"price"})
     *
     * @Rest\Get("/places/{id}/prices")
     */
    public function getPricesAction(Request $request)
    {
        $place = $this->em->getRepository(Place::class)
                          ->find($request->get('id'));

        if (empty($place)) {
            return $this->placeNotFound();
        }

        return $place->getPrices();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"price"})
     *
     * @Rest\Post("/places/{id}/prices")
     */
    public function postPricesAction(Request $request): \App\Entity\Price|\FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
    {
        $place = $this->em->getRepository(Place::class)
                          ->find($request->get('id'));

        if (empty($place)) {
            return $this->placeNotFound();
        }

        $price = new Price();
        $price->setPlace($place);
        $form = $this->createForm(PriceType::class, $price);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $this->em->persist($price);
            $this->em->flush();

            return $price;
        } else {
            return $form;
        }
    }

    private function placeNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
    }
}
