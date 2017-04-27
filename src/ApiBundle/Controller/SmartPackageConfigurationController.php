<?php
# src/ApiBundle/Controller/SmartPackageConfigurationController.php
namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Form\Type\SmartPackageConfigurationType;
use ApiBundle\Entity\SmartPackageConfiguration;

class SmartPackageConfigurationController extends Controller
{
    /**
     * @ApiDoc(
     *    description="Récupère la liste des Smart Package Configuration",
     *    output= { "class"=SmartPackageConfiguration::class, "collection"=true, "groups"={"configuration"} }
     * )
     * @Rest\View(serializerGroups={"configuration"})
     * @Rest\Get("/configurations")
     */
    public function getConfigurationsAction(Request $request)
    {
        $configurations = $this->get('doctrine.orm.entity_manager')
                ->getRepository('ApiBundle:SmartPackageConfiguration')
                ->findAll();

        return $configurations;
    }

    /**
     * @Rest\View(serializerGroups={"configuration"})
     * @Rest\Get("/configurations/{id}")
     */
    public function getConfigurationAction(Request $request)
    {
        $configuration = $this->get('doctrine.orm.entity_manager')
                ->getRepository('ApiBundle:SmartPackageConfiguration')
                ->find($request->get('id')); // L'identifiant en tant que paramétre n'est plus nécessaire

        if (empty($configuration)) {
            return $this->configurationNotFound();
        }

        return $configuration;
    }

    /**
     *
     * @ApiDoc(
     *    description="Crée un lieu dans l'application",
     *    input={"class"=SmartPackageConfigurationType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Création avec succès",
     *        400 = "Formulaire invalide"
     *    },
     *    responseMap={
     *         201 = {"class"=SmartPackageConfiguration::class, "groups"={"configuration"}},
     *         400 = { "class"=SmartPackageConfigurationType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"configuration"})
     * @Rest\Post("/configurations")
     */
    public function postConfigurationsAction(Request $request)
    {
        $configuration = new SmartPackageConfiguration();
        $form = $this->createForm(SmartPackageConfigurationType::class, $configuration);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($configuration);
            $em->flush();
            return $configuration;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT, serializerGroups={"configuration"})
     * @Rest\Delete("/configurations/{id}")
     */
    public function removeConfigurationAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $configuration = $em->getRepository('ApiBundle:SmartPackageConfiguration')
        ->find($request->get('id'));

        if (!$configuration) {
            return $this->configurationNotFound();
        }

        foreach ($configuration->getPrices() as $price) {
            $em->remove($price);
        }
        $em->remove($configuration);
        $em->flush();
    }

    /**
     * @Rest\View(serializerGroups={"configuration"})
     * @Rest\Patch("/configurations/{id}")
     */
    public function patchConfigurationAction(Request $request)
    {
        return $this->updateConfiguration($request, false);
    }

    private function updateConfiguration(Request $request, $clearMissing)
    {
        $configuration = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:SmartPackageConfiguration')
                ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire

        if (empty($configuration)) {
            return $this->configurationNotFound();
        }

        $form = $this->createForm(SmartPackageConfigurationType::class, $configuration);

        // Le paramètre false dit à Symfony de garder les valeurs dans notre
        // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($configuration);
            $em->flush();
            return $configuration;
        } else {
            return $form;
        }
    }

    private function configurationNotFound()
    {
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Configuration not found');
    }
}
