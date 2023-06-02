<?php

declare(strict_types=1);

namespace App\Controller\Place;

use App\Entity\Place;
use App\Entity\Price;
use App\Form\Type\PriceType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PriceController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Rest\View(serializerGroups: ['price'])]
    #[Rest\Get('/places/{id}/prices')]
    public function getPricesAction(Place $place)
    {
        return $place->getPrices();
    }

    #[Rest\View(statusCode: Response::HTTP_CREATED, serializerGroups: ['price'])]
    #[Rest\Post('/places/{id}/prices')]
    public function postPricesAction(Request $request, Place $place): Price|View|FormInterface
    {
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
}
