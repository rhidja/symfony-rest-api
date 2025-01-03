<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\AuthToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthTokenController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Rest\View(statusCode: Response::HTTP_CREATED, serializerGroups: ['auth-token'])]
    #[Rest\Post('/auth-tokens', name: 'api_login')]
    public function postAuthTokensAction(Security $security): AuthToken
    {
        /** @var User $user */
        $user = $security->getUser();

        $authToken = new AuthToken();
        $authToken->setValue(base64_encode(random_bytes(50)));
        $authToken->setCreatedAt(new \DateTimeImmutable('now'));
        $authToken->setUser($user);

        $this->em->persist($authToken);
        $this->em->flush();

        return $authToken;
    }

    #[Rest\View(statusCode: Response::HTTP_NO_CONTENT)]
    #[Rest\Delete('/auth-tokens/{id}')]
    public function removeAuthTokenAction(AuthToken $authToken, Security $security): JsonResponse
    {
        /** @var User $connectedUser */
        $connectedUser = $security->getUser();

        if ($authToken->getUser()->getId() === $connectedUser->getId()) {
            $this->em->remove($authToken);
            $this->em->flush();
        } else {
            throw new BadRequestHttpException();
        }

        return $this->json([
            'message' => 'Token deleted.',
        ]);
    }
}
