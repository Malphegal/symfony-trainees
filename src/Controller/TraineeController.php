<?php

namespace App\Controller;

use App\Entity\Trainee;
use App\Form\TraineeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trainee")
 */
class TraineeController extends AbstractController
{
    /**
     * @Route("/", name="allTrainees")
     */
    public function trainees()
    {
        $trainees = $this->getDoctrine()->getRepository(Trainee::class)->findAll();

        return $this->render('trainee/trainees.html.twig', [
            'trainees' => $trainees
        ]);
    }

    /**
     * @Route("add", name="newTrainee")
     */
    public function newTrainee(Request $request)
    {
        $trainee = new Trainee();
        $form = $this->createForm(TraineeType::class, $trainee);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trainee);
            $entityManager->flush();
            return $this->redirectToRoute("allTrainees");
        }

        return $this->render('trainee/newTrainee.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("{id}", name="showTrainee")
     */
    public function showTrainee(Trainee $trainee)
    {
        $subscribes = [];
        foreach ($trainee->getSubscribes() as $sub)
            $subscribes[] = $sub->getSessionWithDate();
        return new JsonResponse(["subscribes" => $subscribes]);
    }
}
