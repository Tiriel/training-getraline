<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloController extends AbstractController
{
    #[Route('/hello/{name?World}', name: 'app_hello', requirements: ['name' => '(?:\p{L}|[- ])+'])]
    public function index(string $name, #[Autowire(param: 'app.sf_constraint')] $toto): Response
    {
        if ($this->isGranted('ROLE_ADMIN')
            || $this->isGranted('IS_IMPERSONATOR')
        ) {
            dump($toto);
        }

        return $this->render('hello/index.html.twig', [
            'controller_name' => $name,
        ]);
    }
}
