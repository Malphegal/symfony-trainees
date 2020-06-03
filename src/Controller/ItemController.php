<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/item")
 */
class ItemController extends AbstractController
{
    /**
     * @Route("/", name="allItems")
     */
    public function index()
    {
        $items = $this->getDoctrine()->getRepository(Item::class)->findAll();

        $items = $this->getOrderedItems($items);
        foreach ($items as $category => $value)
        {
            asort($value);
            $items[$category] = $value;
        }

        return $this->render('item/items.html.twig', [
            "allItems" => $items
        ]);
    }

    /**
     * @Route("/add", name="newItem")
     */
    public function newTrainee(Request $request)
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($item);
            $entityManager->flush();
            return $this->redirectToRoute("allItems");
        }

        return $this->render('item/newItem.html.twig', [
            "form" => $form->createView()
        ]);
    }

    private function getOrderedItems($items): array
    {
        $res = [];
        foreach ($items as $i)
        {
            if (!array_key_exists($i->getCategory()->getName(), $res))
                $res[$i->getCategory()->getName()] = [];
            $res[$i->getCategory()->getName()][] = $i->getName();
        }
        return $res;
    }
}
