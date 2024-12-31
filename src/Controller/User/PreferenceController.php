<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Entity\Preference;
use App\Entity\User;
use App\Form\Type\PreferenceType;
use App\Repository\PreferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PreferenceController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    /**
     * @return Preference[]
     */
    #[Rest\View(serializerGroups: ['preference'])]
    #[Rest\Get('/users/{id}/preferences')]
    public function getPreferencesAction(PreferenceRepository $preferenceRepository, User $user): array
    {
        $preferences = $preferenceRepository->findByUser($user);

        return $preferences;
    }

    #[Rest\View(statusCode: Response::HTTP_CREATED, serializerGroups: ['preference'])]
    #[Rest\Post('/users/{id}/preferences')]
    public function postPreferencesAction(Request $request, User $user): Preference|View|FormInterface
    {
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
}
