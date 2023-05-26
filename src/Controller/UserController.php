<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
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
     * @return array
     *
     * @Rest\View(serializerGroups={"users"})
     *
     * @Rest\Get("/users")
     */
    public function getUsersAction()
    {
        $users = $this->em->getRepository(User::class)
                    ->findAll();

        return $users;
    }

    /**
     * @return object|void|null
     *
     * @Rest\View(serializerGroups={"users"})
     *
     * @Rest\Get("/users/{user_id}")
     */
    public function getUserAction(Request $request)
    {
        $user = $this->em->getRepository(User::class)
                         ->find($request->get('user_id'));

        if (empty($user)) {
            return $this->userNotFound();
        }

        return $user;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"users"})
     *
     * @Rest\Post("/users")
     */
    public function postUsersAction(Request $request, UserPasswordHasherInterface $userPasswordHasher): FormInterface|User
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['validation_groups' => ['Default', 'New']]);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $encoded = $userPasswordHasher->hashPassword(
                $user,
                $user->getPlainPassword()
            );
            $user->setPassword($encoded);

            $this->em->persist($user);
            $this->em->flush();

            return $user;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT, serializerGroups={"users"})
     *
     * @Rest\Delete("/users/{id}")
     */
    public function removeUserAction(Request $request)
    {
        $user = $this->em->getRepository(User::class)
                   ->find($request->get('id'));

        if ($user) {
            $this->em->remove($user);
            $this->em->flush();
        }
    }

    /**
     * @return object|FormInterface|void|null
     *
     * @Rest\View(serializerGroups={"users"})
     *
     * @Rest\Put("/users/{id}")
     */
    public function updateUserAction(Request $request, UserPasswordHasherInterface $encoder)
    {
        return $this->updateUser($request, $encoder, true);
    }

    /**
     * @return object|FormInterface|void|null
     *
     * @Rest\View(serializerGroups={"users"})
     *
     * @Rest\Patch("/users/{id}")
     */
    public function patchUserAction(Request $request, UserPasswordHasherInterface $encoder)
    {
        return $this->updateUser($request, $encoder, false);
    }

    /**
     * @return object|FormInterface|void|null
     */
    private function updateUser(Request $request, UserPasswordHasherInterface $encoder, $clearMissing)
    {
        $user = $this->em->getRepository(User::class)->find($request->get('id'));

        if (empty($user)) {
            return $this->userNotFound();
        }

        if ($clearMissing) {
            $options = ['validation_groups' => ['Default', 'FullUpdate']];
        } else {
            $options = [];
        }

        $form = $this->createForm(UserType::class, $user, $options);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            // Si l'utilisateur veut changer son mot de passe
            if (!empty($user->getPlainPassword())) {
                $encoded = $encoder->hashPassword($user, $user->getPlainPassword());
                $user->setPassword($encoded);
            }
            $this->em->merge($user);
            $this->em->flush();

            return $user;
        } else {
            return $form;
        }
    }

    /**
     * @return array|void
     *
     * @Rest\View(serializerGroups={"users"})
     *
     * @Rest\Get("/users/{id}/suggestions")
     */
    public function getUserSuggestionsAction(Request $request)
    {
        $user = $this->em->getRepository(User::class)->find($request->get('id'));

        if (empty($user)) {
            return $this->userNotFound();
        }

        $suggestions = [];
        $places = $this->em->getRepository('AppBundle:Place')->findAll();
        $preferences = $this->em->getRepository('AppBundle:Preference')->findByUser($user);

        foreach ($places as $place) {
            if ($this->preferencesMatch($preferences, $place->getThemes())) {
                $suggestions[] = $place;
            }
        }

        return $suggestions;
    }

    /**
     * @return bool
     */
    public function preferencesMatch($preferences, $themes)
    {
        $matchValue = 0;
        foreach ($preferences as $preference) {
            foreach ($themes as $theme) {
                if ($preference->match($theme)) {
                    $matchValue += $preference->getValue() * $theme->getValue();
                }
            }
        }

        return $matchValue >= User::MATCH_VALUE_THRESHOLD;
    }

    private function userNotFound(): never
    {
        throw new NotFoundHttpException('User not found');
    }
}
