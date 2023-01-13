<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Entity\Repartition;
use App\Entity\CarteRepartition;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RepartitionController extends AbstractController
{
    
    // ================ Route remplissage table repartition =================
    // ====================================================================== M

    /**
     * @Route("/remplirtablerepar/{id}", name="remplirtablerepar")
     */
    public function remplirtablerepar($id)
    {   
       
        $em = $this->getDoctrine()->getManager();
        $repartition = $em->getRepository(CarteRepartition::class)->findBy(['Carte' => $id]);
        $tbody = $this->render('inc/tbodyRep.html.twig',[
            'lstRep'=>$repartition,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;
      
    }

    
    // ================ Route remplissage table popup ajouter repartition par carte ================= M
    // ======================================================================

    /**
     * @Route("/remplirpopupajouterrepar/{id}", name="remplirpopupajouterrepar")
     */
    public function remplirpopupajouterrepar($id)
    {   
       
        $em = $this->getDoctrine()->getManager();
        $repartitions = $em->getRepository(Repartition::class)->findAll();
        $tbody = $this->render('inc/popupajoutercarterepartition.html.twig',[
            'lstRep'=>$id,
            'listrepar' => $repartitions,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;
      
    }

    
     // ================ Route ajouter repartition =================
    // =============================================================== M

    /**
     * @Route("/addrapartition", name="addrapartition")
     */
    public function addrapartition(Request $request,ManagerRegistry $doctrine)
    {   
       
        $em = $this->getDoctrine()->getManager();
        $carte = $em->getRepository(Carte::class)->find($request->get('idcarte'));
        $entityManager = $doctrine->getManager();

        $carteR = new CarteRepartition();

        $carteR->setCarte($carte);
        $carteR->setRepartition($request->get('libelle'));

        
        $entityManager->persist($carteR);
        $entityManager->flush();
        $carteR->setIdRepartition('RPT'.$carteR->getId());
        $entityManager->flush();
        $carteRep = $em->getRepository(CarteRepartition::class)->findBy(['Carte' => $carte]);

        $tbody = $this->render('inc/tbodyRep.html.twig',[
            'lstRep'=>$carteRep,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;

    }


    // ================ Route remplissage table popup modifier repartition par carte ================= M
    // ======================================================================

    /**
     * @Route("/remplirpopupmodifierrepar/{id}", name="remplirpopupmodifierrepar")
     */
    public function remplirpopupmodifierrepar($id)
    {   
      
        $em = $this->getDoctrine()->getManager();
        $repartition = $em->getRepository(CarteRepartition::class)->findOneBy(['id' => $id]);
    
        $tbody = $this->render('inc/popupmodifierrepartition.html.twig',[
            'lstRep'=>$repartition,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;
      
    }

    

    // ================ Route remplissage table popup supprimer repartition par carte ================= M
    // ======================================================================

    /**
     * @Route("/remplirpopupsupprimerrepar/{id}", name="remplirpopupsupprimerrepar")
     */
    public function remplirpopupsupprimerrepar($id)
    {   
        $em = $this->getDoctrine()->getManager();
        $repartition = $em->getRepository(CarteRepartition::class)->findOneBy(['id' => $id]);
        $tbody = $this->render('inc/popupsupprimerrepartion.html.twig',[
            'lstRep'=>$repartition,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;
      
    }
    
    
     // ================ Route modifier repartition ================= M
    // ===============================================================

    /**
     * @Route("/modifierrapartition", name="modifierrapartition")
     */
    public function modifierrapartition(ManagerRegistry $doctrine,Request $request)
    {   
        $em = $this->getDoctrine()->getManager();

        $libelle = $request->get('libelle');
        $idcarte = $request->get('idcarte');
        $pax = $request->get('pax');
        $heure = $request->get('heure');
        $heure2=new DateTime($heure);
        // dd(date_format($heure2,'H:i:s'));

        $entityManager = $doctrine->getManager();
        $carteR = $em->getRepository(CarteRepartition::class)->find($request->get('id'));

        $carteR->setRepartition($libelle);
        // $carteR->setHeure(\DateTime::createFromFormat('H:i:s',$heure2));
        $carteR->setPax($pax);

        $entityManager->flush();

        $carteRep = $em->getRepository(CarteRepartition::class)->findBy(['Carte' => $idcarte]);
        // dd($carteRep);
      
        $tbody = $this->render('inc/tbodyRep.html.twig',[
            'lstRep'=>$carteRep,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;

    }

    
    
    
     // ================ Route supprimer repartition =================  M
    // ===============================================================

    /**
     * @Route("/deleterapartition", name="deleterapartition")
     */
    public function deleterapartition(ManagerRegistry $doctrine,Request $request)
    {   
        $idcarte = $request->get('idcarte');
        $em = $this->getDoctrine()->getManager();
        $entityManager = $doctrine->getManager();
        $carteR = $em->getRepository(CarteRepartition::class)->find($request->get('idrepartition'));
        $entityManager->remove($carteR);
        $entityManager->flush();

        $carteRep = $em->getRepository(CarteRepartition::class)->findBy(['Carte' => $idcarte]);
        $tbody = $this->render('inc/tbodyRep.html.twig',[
            'lstRep'=>$carteRep,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;

    }

     
     // ================ Route modifier repartition =================  M
    // ===============================================================

    /**
     * @Route("/updatepaxrep", name="updatepaxrep")
     */
    public function updatepaxrep(ManagerRegistry $doctrine,Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $qtes = $request->get('qtes');
        $idrepartition = $request->get('idrepartition');
        $idcarte = $request->get('idcarte');
        
        $entityManager = $doctrine->getManager();
        $carteR = $em->getRepository(CarteRepartition::class)->find($request->get('idrepartition'));
        $carteR->setPax($qtes);

        $entityManager->flush();

        $carteRep = $em->getRepository(CarteRepartition::class)->findBy(['Carte' => $idcarte]);
        $tbody = $this->render('inc/tbodyRep.html.twig',[
            'lstRep'=>$carteRep,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;

    }
    
    

}
