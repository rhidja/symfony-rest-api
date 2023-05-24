<?php

namespace App\Controller\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Form\Type\PreferenceType;
use App\Entity\Preference;

class PreferenceController extends AbstractController
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
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     *
     * @Rest\View(serializerGroups={"preference"})
     * @Rest\Get("/users/{id}/preferences")
     */
    public function getPreferencesAction(Request $request)
    {
        $user = $this->em->getRepository('UserBundle:User')
                         ->find($request->get('id'));

        if (empty($user)) {
            return $this->userNotFound();
        }

        $preferences = $this->em->getRepository(Preference::class)
                                ->findByUser($user);

        return $preferences;
    }

     /**
      * @param Request $request
      * @return Preference|\FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
      *
      * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"preference"})
      * @Rest\Post("/users/{id}/preferences")
      */
    public function postPreferencesAction(Request $request)
    {
        $user = $this->em->getRepository('UserBundle:User')
                         ->find($request->get('id'));

        if (empty($user)) {
            return $this->userNotFound();
        }

        $preference = new Preference();
        $preference->setUser($user);
        $form = $this->createForm(PreferenceType::class, $preference);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $this->em->persist($preference);
            $this->em->flush();
            return $preference;
        } else {
            return $form;
        }
    }

    private function userNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }
}
