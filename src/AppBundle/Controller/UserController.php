<?php
# src/AppBundle/Controller/UserController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

class UserController extends Controller
{
    /**
     * @Route("/users", name="users_list")
     * @Method({"GET"})
     */
    public function getUsersAction(Request $request)
    {
        $users = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:User')
                ->findAll();
        /* @var $users User[] */

        $formatted = [];
        foreach ($users as $user) {
            $formatted[] = [
               'id' => $user->getId(),
               'firstname' => $user->getFirstname(),
               'lastname' => $user->getLastname(),
               'email' => $user->getEmail(),
            ];
        }

        return new JsonResponse($formatted);
    }


    /**
     * @Route("/users/{id}", requirements={"id" = "\d+"}, name="users_one")
     * @Method({"GET"})
     */
    public function getUserAction(Request $request)
    {
        $user = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:User')
                ->find($request->get('id'));
        /* @var $user User */

        $formatted = [
           'id' => $user->getId(),
           'firstname' => $user->getFirstname(),
           'lastname' => $user->getLastname(),
           'email' => $user->getEmail(),
        ];

        return new JsonResponse($formatted);
    }
}
