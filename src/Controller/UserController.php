<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\Type\UserType;
use App\Entity\User;

class UserController extends AbstractController
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
     * @return array
     *
     * @Rest\View(serializerGroups={"users"})
     * @Rest\Get("/users")
     */
    public function getUsersAction(Request $request)
    {
        $users = $this->em->getRepository(User::class)
                    ->findAll();

        return $users;
    }

    /**
     * @param Request $request
     * @return object|void|null
     *
     * @Rest\View(serializerGroups={"users"})
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
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\Form\FormInterface|User
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"users"})
     * @Rest\Post("/users")
     */
    public function postUsersAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['validation_groups'=>['Default', 'New']]);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encoded);

            $this->em->persist($user);
            $this->em->flush();
            return $user;
        } else {
            return $form;
        }
    }

    /**
     *
     * @param Request $request
     *
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT, serializerGroups={"users"})
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
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return object|\Symfony\Component\Form\FormInterface|void|null
     *
     * @Rest\View(serializerGroups={"users"})
     * @Rest\Put("/users/{id}")
     */
    public function updateUserAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        return $this->updateUser($request, $encoder,true);
    }

    /**
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return object|\Symfony\Component\Form\FormInterface|void|null
     *
     * @Rest\View(serializerGroups={"users"})
     * @Rest\Patch("/users/{id}")
     */
    public function patchUserAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        return $this->updateUser($request, $encoder, false);
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param $clearMissing
     * @return object|\Symfony\Component\Form\FormInterface|void|null
     */
    private function updateUser(Request $request, UserPasswordEncoderInterface $encoder, $clearMissing)
    {
        $user = $this->em->getRepository(User::class)->find($request->get('id'));

        if (empty($user)) {
            return $this->userNotFound();
        }

        if ($clearMissing) {
            $options = ['validation_groups'=>['Default', 'FullUpdate']];
        } else {
            $options = [];
        }

        $form = $this->createForm(UserType::class, $user, $options);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            // Si l'utilisateur veut changer son mot de passe
            if (!empty($user->getPlainPassword())) {
                $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
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
     * @param Request $request
     * @return array|void
     *
     * @Rest\View(serializerGroups={"users"})
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
     * @param $preferences
     * @param $themes
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

    /**
     *
     */
    private function userNotFound()
    {
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('User not found');
    }
}
