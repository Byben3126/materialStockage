<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderMaterial;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\OrderMaterialRepository;
use App\Repository\MaterialsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;

#[Route('/order')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'app_order_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, MaterialsRepository $materialsRepository): Response
    {
        $order = new Order();

        $materials = $materialsRepository->findAll();

        foreach ($materials as $material) {
            $orderMaterial = new OrderMaterial();
            $orderMaterial->setMaterial($material)->setQuantity(0);
            $order->getOrderMaterials()->add($orderMaterial);
        }


        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isValid = true;

            $order->setPrice(0)->setActive(true);

            foreach ($order->getOrderMaterials() as $key => $orderMaterial) {
                if ($orderMaterial->getQuantity() > 0) {
                    if ($orderMaterial->getMaterial()->getAmount() < $orderMaterial->getQuantity()) {
                        $form->addError(new FormError("Stock insuffisant pour l'article {$orderMaterial->getMaterial()->getName()}"));
                        $isValid = false;
                    }
                }
            }


            
            if ($isValid) {


                foreach ($order->getOrderMaterials() as $key => $orderMaterial) {
                    if ($orderMaterial->getQuantity() === 0) {
                        $order->getOrderMaterials()->removeElement($orderMaterial);
                    }else{
                        if ($orderMaterial->getMaterial()->getAmount() >= $orderMaterial->getQuantity()) {
                            $orderMaterial->setOrderRef($order);
                            $order->setPrice($order->getPrice() + $orderMaterial->getMaterial()->getPrice() * $orderMaterial->getQuantity());
                            $orderMaterial->getMaterial()->setAmount($orderMaterial->getMaterial()->getAmount() - $orderMaterial->getQuantity());
                        }
                    }
                }

                $entityManager->persist($order);
                $entityManager->flush();
                
                return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('order/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_show', methods: ['GET'])]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_order_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Order $order, EntityManagerInterface $entityManager,OrderMaterialRepository $orderMaterialRepository): Response
    // {
    //     $form = $this->createForm(OrderType::class, $order);
    //     $form->handleRequest($request);



    //     // $initialQuantities = [];
    //     // foreach ($order->getOrderMaterials() as $orderMaterial) {
    //     //     // Récupérer l'état initial du matériau depuis la base de données
    //     //     $materialFromDb = $orderMaterialRepository->find($orderMaterial->getId());
    //     //     if ($materialFromDb) {
    //     //         $initialQuantities[$orderMaterial->getId()] = $materialFromDb->getQuantity();
    //     //     }
    //     // }
    //     $orderdb = $entityManager->getRepository(Order::class)->find($order->getId());

       
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         dump('test',$orderdb);
    //         if ($order->isActive()) {
                
          
    //             foreach ($order->getOrderMaterials() as $orderMaterial) {
        
                    
                   
    //                 // if ($orderMaterialDb->getQuantity() > $orderMaterial->getQuantity()) {
    //                 //     $orderMaterial->getMaterial()->setAmount($orderMaterial->getMaterial()->getAmount() + ($orderMaterialDb->getQuantity() - $orderMaterial->getQuantity()));
    //                 // }else if($orderMaterialDb->getQuantity() < $orderMaterial->getQuantity()) {
    //                 //     $orderMaterial->getMaterial()->setAmount($orderMaterial->getMaterial()->getAmount() - ($orderMaterial->getQuantity() - $orderMaterialDb->getQuantity()));
    //                 // }
    //             }
    //         }

    //         // $entityManager->flush();
    //         // return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('order/edit.html.twig', [
    //         'order' => $order,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
     
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            if ($order->isActive()) {
                $order->setActive(false);
                foreach ($order->getOrderMaterials() as $orderMaterial) {
                    $material = $orderMaterial->getMaterial();
                    $material->setAmount($material->getAmount() + $orderMaterial->getQuantity());
                }

                $entityManager->flush();
            }
          
        }

        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }
}
