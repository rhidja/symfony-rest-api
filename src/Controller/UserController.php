<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Place;
use App\Entity\Preference;
use App\Entity\User;
use App\Form\Type\UserType;
use App\Repository\UserRepository;
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
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /**
     * @return User[]
     */
    #[Rest\View(serializerGroups: ['users'])]
    #[Rest\Get('/users')]
    public function getUsersAction(UserRepository $userRepository): array
    {
        /** @var User[] $users */
        $users = $userRepository->findAll();

        return $users;
    }

    #[Rest\View(serializerGroups: ['users'])]
    #[Rest\Get('/users/{id}')]
    public function getUserAction(User $user): User
    {
        return $user;
    }

    #[Rest\View(statusCode: Response::HTTP_CREATED, serializerGroups: ['users'])]
    #[Rest\Post('/users')]
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

    #[Rest\View(statusCode: Response::HTTP_NO_CONTENT, serializerGroups: ['users'])]
    #[Rest\Delete('/users/{id}')]
    public function removeUserAction(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    #[Rest\View(serializerGroups: ['users'])]
    #[Rest\Put('/users/{id}')]
    public function updateUserAction(Request $request, User $user, UserPasswordHasherInterface $passwordHasher)
    {
        return $this->updateUser($request, $user, $passwordHasher, true);
    }

    #[Rest\View(serializerGroups: ['users'])]
    #[Rest\Patch('/users/{id}')]
    public function patchUserAction(Request $request, User $user, UserPasswordHasherInterface $passwordHasher)
    {
        return $this->updateUser($request, $user, $passwordHasher, false);
    }

    private function updateUser(Request $request, User $user, UserPasswordHasherInterface $passwordHasher, $clearMissing)
    {
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
                $password = $passwordHasher->hashPassword($user, $user->getPlainPassword());
                $user->setPassword($password);
            }
            $this->em->flush();

            return $user;
        } else {
            return $form;
        }
    }

    #[Rest\View(serializerGroups: ['users'])]
    #[Rest\Get('/users/{id}/suggestions')]
    public function getUserSuggestionsAction(Request $request, User $user)
    {
        $suggestions = [];
        $places = $this->em->getRepository(Place::class)->findAll();
        $preferences = $this->em->getRepository(Preference::class)->findByUser($user);

        foreach ($places as $place) {
            if ($this->preferencesMatch($preferences, $place->getThemes())) {
                $suggestions[] = $place;
            }
        }

        return $suggestions;
    }

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
