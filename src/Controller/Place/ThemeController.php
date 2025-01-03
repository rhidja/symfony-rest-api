<?php

declare(strict_types=1);

namespace App\Controller\Place;

use App\Entity\Place;
use App\Entity\Theme;
use App\Form\Type\ThemeType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ThemeController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Rest\View(serializerGroups: ['theme'])]
    #[Rest\Get('/places/{id}/themes')]
    public function getThemesAction(Place $place)
    {
        return $place->getThemes();
    }

    #[Rest\View(statusCode: Response::HTTP_CREATED, serializerGroups: ['theme'])]
    #[Rest\Post('/places/{id}/themes')]
    public function postThemesAction(Request $request, Place $place): Theme|View|FormInterface
    {
        $theme = new Theme();
        $place->addTheme($theme);
        $form = $this->createForm(ThemeType::class, $theme);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $this->em->persist($theme);
            $this->em->flush();

            return $theme;
        } else {
            return $form;
        }
    }
}
