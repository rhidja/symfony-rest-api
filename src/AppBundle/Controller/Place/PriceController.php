<?php
# src/AppBundle/Controller/Place/PriceController.php
namespace AppBundle\Controller\Place;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Form\Type\PriceType;
use AppBundle\Entity\Price;

class PriceController extends AbstractController
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
     *    description="Récupère les différents prix d'un lieu",
     *    output= { "class"=Price::class, "collection"=true, "groups"={"price"} }
     * )
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     *
     * @Rest\View(serializerGroups={"price"})
     * @Rest\Get("/places/{id}/prices")
     */
    public function getPricesAction(Request $request)
    {
        $place = $this->em->getRepository('AppBundle:Place')
                          ->find($request->get('id'));

        if (empty($place)) {
            return $this->placeNotFound();
        }

        return $place->getPrices();
    }

    /**
     * @ApiDoc(
     *    description="Ajouter un prix à un lieu",
     *    output= { "class"=Price::class, "collection"=true, "groups"={"price"} }
     * )
     *
     * @param Request $request
     * @return Price|\FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"price"})
     * @Rest\Post("/places/{id}/prices")
     */
    public function postPricesAction(Request $request)
    {
        $place = $this->em->getRepository('AppBundle:Place')
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
