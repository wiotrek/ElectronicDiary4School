<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        // create a new user
        $user = new User();
        $user->setFirstName('Testowy');
        $user->setLastName('Uczeń');
        $user->setIdentifier('152432');
        $user->setHashPass('hash');
        $user->setSaltPass('salt');


        // entity manager
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();


        // return a response
        return new Response(content: 'User was created');
    }
}
