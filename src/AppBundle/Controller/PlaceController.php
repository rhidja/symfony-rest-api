<?php
# src/AppBundle/Controller/PlaceController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use AppBundle\Form\Type\PlaceType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Entity\Place;

class PlaceController extends Controller
{
    /**
     * @ApiDoc(
     *    description="Récupère la liste des lieux",
     *    output= { "class"=Place::class, "collection"=true, "groups"={"place"} }
     * )
     * @Rest\View(serializerGroups={"place"})
     * @Rest\Get("/places")
     */
    public function getPlacesAction(Request $request)
    {
        $em = $this->getEm();
        $places = $em->getRepository('AppBundle:Place')
                     ->findAll();
        /* @var $places Place[] */

        return $places;
    }

    /**
     * @ApiDoc(
     *    description="Récupère un lieu par son Id",
     *    output= { "class"=Place::class, "collection"=true, "groups"={"place"} }
     * )
     *
     * @Rest\View(serializerGroups={"place"})
     * @Rest\Get("/places/{id}")
     */
    public function getPlaceAction(Request $request)
    {
        $em = $this->getEm();
        $place = $em->getRepository('AppBundle:Place')
                    ->find($request->get('id'));
        /* @var $place Place */

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
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"place"})
     * @Rest\Post("/places")
     */
    public function postPlacesAction(Request $request)
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {

            $em = $this->getEm();
            $em->persist($place)->flush();

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
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT, serializerGroups={"place"})
     * @Rest\Delete("/places/{id}")
     */
    public function removePlaceAction(Request $request)
    {
        $em = $this->getEm();
        $place = $em->getRepository('AppBundle:Place')
                    ->find($request->get('id'));
        /* @var $place Place */

        if (!$place) {
            return $this->placeNotFound();
        }

        foreach ($place->getPrices() as $price) {
            $em->remove($price);
        }
        $em->remove($place);
        $em->flush();
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
     * @Rest\View(serializerGroups={"place"})
     * @Rest\Patch("/places/{id}")
     */
    public function patchPlaceAction(Request $request)
    {
        return $this->updatePlace($request, false);
    }

    private function updatePlace(Request $request, $clearMissing)
    {
        $em = $this->getEm();
        $place = $em->getRepository('AppBundle:Place')
                    ->find($request->get('id'));

        if (empty($place)) {
            return $this->placeNotFound();
        }

        $form = $this->createForm(PlaceType::class, $place);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {

            $em = $this->getEm();
            $em->persist($place)->flush();

            return $place;
        } else {
            return $form;
        }
    }

    private function placeNotFound()
    {
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Place not found');
    }

    private function getEm()
    {
        return $this->get('doctrine.orm.entity_manager');
    }
}
