<?php

namespace App\Controller;

use App\Entity\OperationO;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FileAttendController extends AbstractController
{
    /**
     * @Route("/fileattend", name="fileattend")
     */
    public function index(): Response
    {

        $em = $this->getDoctrine()->getManager();
        $operationD = $em->getRepository(OperationO::class)->findBy(['Repartition' => 10845 , 'Statut'=>"Validé",'Statut2' => 'Attente' ]);
        return $this->render('file_attend/index.html.twig', [
            'lstoperation' => $operationD,
        ]);
    }
     /**
     * @Route("/pretecommande/{id}", name="pretecommande")
     */
    public function pretecommande(ManagerRegistry $doctrine, $id): Response
    {
      
        $entityManager = $doctrine->getManager();
        $em = $this->getDoctrine()->getManager();
        $operation = $em->getRepository(OperationO::class)->findOneBy(['id' => $id ]);
        $operation->setStatut2('Pret');
        $entityManager->flush();
        $operationS = $em->getRepository(OperationO::class)->findBy(['Statut2' => 'Pret', 'Repartition' => 10845 ]);
        // return die;
        $tbody = $this->render('file_attend/commandeprete.html.twig', [
        //    'listO'=>$operation,
           'rep'=>$operationS,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;
    }
     /**
     * @Route("/servivommande/{id}", name="servivommande")
     */
    public function servivommande(ManagerRegistry $doctrine, $id): Response
    {
      
        $entityManager = $doctrine->getManager();
        $em = $this->getDoctrine()->getManager();
        $operation = $em->getRepository(OperationO::class)->findOneBy(['id' => $id ]);
        $operation->setStatut2('Servi');
        $entityManager->flush();
        $operationS = $em->getRepository(OperationO::class)->findBy(['Statut2' => 'Pret', 'Repartition' => 10845 ]);
        // return die;
        $tbody = $this->render('file_attend/commandeprete.html.twig', [
        //    'listO'=>$operation,
           'rep'=>$operationS,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;
    }
}
