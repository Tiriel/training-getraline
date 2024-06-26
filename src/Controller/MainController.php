<?php

namespace App\Controller;

use App\Dto\Contact;
use App\Form\ContactType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Clock\Clock;
use Symfony\Component\Clock\MockClock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('', name: 'app_main_index')]
    public function index(MovieRepository $repository): Response
    {
        return $this->render('main/index.html.twig', [
            'movies' => $repository->findBy([], ['id' => 'DESC'], 6),
        ]);
    }

    #[Route('/contact', name: 'app_main_contact')]
    public function contact(Request $request): Response
    {
        $dto = new Contact();
        $form = $this->createForm(ContactType::class, $dto);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dto->setCreatedAt(Clock::get()->now());
            dump($dto);

            return $this->redirectToRoute('app_main_contact');
        }

        $content = $this->renderView('main/contact.html.twig', [
            'form' => $form,
        ]);

        $hash = md5($content);
        $response = (new Response())->setEtag($hash);

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response->setContent($content);
    }
}
