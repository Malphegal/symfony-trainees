<?php

namespace App\Controller;

use App\Entity\Contain;
use App\Entity\Item;
use App\Entity\Session;
use App\Entity\Trainee;
use App\Form\AddItemType;
use App\Form\SessionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $sessions = $this->getDoctrine()->getRepository(Session::class)->findAll();

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    /**
     * @Route("/session/{id}", name="showSession")
     */
    public function showSession(Session $session, Request $request)
    {
        // ---- Items ----

        $contains = $session->getOrderedItems();

        $items = $this->getDoctrine()->getRepository(Item::class)->findAll();
        for ($i = count($items) - 1; $i >= 0; $i--)
            foreach ($items[$i] as $subArray)
                if (in_array($subArray, $contains))
                    unset($items[$i]);

        $arrayItems = [];
        foreach ($items as $item)
            $arrayItems[$item->getName()] = $item->getid();

        $itemsForm = $this->createForm(AddItemType::class, null, ["data" => ["items" => $arrayItems]]);
        $itemsForm->handleRequest($request);

        if ($itemsForm->isSubmitted() && $itemsForm->isValid())
        {
            $info = $request->get('add_item');
            $item = $this->getDoctrine()->getRepository(Item::class)->find($info["items"]);

            $contain = new Contain();
            $contain->setSession($session);
            $contain->setItem($item);
            $contain->setDuration($info["duration"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contain);
            $entityManager->flush();

            return $this->redirectToRoute("showSession", ["id" => $session->getId()]);
        }

        // ---- Trainees ----

        $trainees = [];
        foreach ($session->getSubscribes() as $sub)
            $trainees[] = $sub->getTrainee();

        dump($trainees);

        return $this->render('session/showSession.html.twig', [
            'session' => $session,
            'contains' => $contains,
            'itemsForm' => $itemsForm->createView(),
            'trainees' => $trainees
        ]);
    }

    /**
     * @Route("/add", name="newSession")
     */
    public function newSession(Request $request)
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();
            return $this->redirectToRoute("home");
        }

        return $this->render('session/newSession.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
