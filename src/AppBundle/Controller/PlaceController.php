<?php
namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Form\Type\PlaceType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Entity\Place;

class PlaceController extends AbstractController
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
     *    description="Récupère la liste des lieux",
     *    output= { "class"=Place::class, "collection"=true, "groups"={"place"} }
     * )
     *
     * @param Request $request
     * @return array
     *
     * @Rest\View(serializerGroups={"place"})
     * @Rest\Get("/places")
     */
    public function getPlacesAction(Request $request)
    {
        $places = $this->em->getRepository('AppBundle:Place')
                     ->findAll();

        return $places;
    }

    /**
     * @ApiDoc(
     *    description="Récupère un lieu par son Id",
     *    output= { "class"=Place::class, "collection"=true, "groups"={"place"} }
     * )
     *
     * @param Request $request
     * @return object|void|null
     *
     * @Rest\View(serializerGroups={"place"})
     * @Rest\Get("/places/{id}")
     */
    public function getPlaceAction(Request $request)
    {
        $place = $this->em->getRepository('AppBundle:Place')
                          ->find($request->get('id'));

        if (empty($place)) {
            return $this->placeNotFound();
        }

        return $place;
    }

    /**
     *
     * @ApiDoc(
     *    description="Crée un lieu",
     *    input={"class"=PlaceType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Création avec succès",
     *        400 = "Formulaire invalide"
     *    },
     *    responseMap={
     *         201 = {"class"=Place::class, "groups"={"place"}},
     *         400 = { "class"=PlaceType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @param Request $request
     * @return Place|\Symfony\Component\Form\FormInterface
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"place"})
     * @Rest\Post("/places")
     */
    public function postPlacesAction(Request $request)
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {

            $this->em->persist($place);
            $this->em->flush();

            return $place;
        } else {
            return $form;
        }
    }

    /**
     * @ApiDoc(
     *    description="Supprime un lieu",
     *    input={"class"=PlaceType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Création avec succès",
     *        400 = "Formulaire invalide"
     *    },
     *    responseMap={
     *         201 = {"class"=Place::class, "groups"={"place"}},
     *         400 = { "class"=PlaceType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @param Request $request
     * @return array
     *
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT, serializerGroups={"place"})
     * @Rest\Delete("/places/{id}")
     */
    public function removePlaceAction(Request $request)
    {
        $place = $this->em->getRepository('AppBundle:Place')
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
     * @ApiDoc(
     *    description="Mis à jour un lieu",
     *    input={"class"=PlaceType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Création avec succès",
     *        400 = "Formulaire invalide"
     *    },
     *    responseMap={
     *         201 = {"class"=Place::class, "groups"={"place"}},
     *         400 = { "class"=PlaceType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @param Request $request
     * @return object|\Symfony\Component\Form\FormInterface|void|null
     *
     * @Rest\View(serializerGroups={"place"})
     * @Rest\Patch("/places/{id}")
     */
    public function patchPlaceAction(Request $request)
    {
        return $this->updatePlace($request, false);
    }

    /**
     * @param Request $request
     * @param $clearMissing
     * @return object|\Symfony\Component\Form\FormInterface|void|null
     */
    private function updatePlace(Request $request, $clearMissing)
    {
        $place = $this->em->getRepository('AppBundle:Place')
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

    private function placeNotFound()
    {
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Place not found');
    }
}
