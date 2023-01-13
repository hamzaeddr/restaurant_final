<?php

namespace App\Controller;

use DateTime;
use App\Entity\Carte;
use App\Entity\Client;
use App\Entity\TypeTarif;
use App\Entity\ClientBeneficiaire;
// use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



use Doctrine\Persistence\ManagerRegistry;


class CarteController extends AbstractController
{
    // ================= Liste des cartes par jour ================= M
    
    /**
     * @Route("/carte", name="carte")
     */
    public function index(): Response
    {
        $current_day= new \DateTime('now');
        $current_day = $current_day->format('Y-m-d');
        $date2=new DateTime($current_day);
        // dd($current_day);
        
        $em = $this->getDoctrine()->getManager();
        $cartes = $em->getRepository(Carte::class)->findBy(['DateValidite' => $date2]);
        // ======================================================

        $client = $this->getDoctrine()
        ->getRepository(Client::class)
        ->findAll();
        
        // ======================================================
        $em = $this->getDoctrine()->getManager();
        $tarif = $em->getRepository(TypeTarif::class)->findAll();

        return $this->render('home/index.html.twig', [
            'list' => $cartes,
            'listClient' => $client,
            'lsttarif' => $tarif,
        ]);
    }

    // ================= PRINCIPALE home ================= M
    
    /**
     * @Route("/principale", name="principale")
     */
    public function principale(): Response
    {
       
        return $this->render('home/principale.html.twig');
    }
    /**
     * @Route("/remptablebydate/{date}", name="remptablebydate")
     */
    public function remptablebydate($date): Response
    {
        $date2=new DateTime($date);

        $em = $this->getDoctrine()->getManager();
        $cartes = $em->getRepository(Carte::class)->findBy(['DateValidite' => $date2 ]);

        return $this->render('inc/tbodybydate.html.twig', [
            'list' => $cartes,
            
        ]);
    }

    // ================= Liste des cartes par jour non precis =================  M
    
    /**
     * @Route("/filtretablecarte/{date}", name="filtretablecarte")
     */
    public function filtretablecarte($date): Response
    {   
        $current_day= new \DateTime('now');
        $current_day = $current_day->format('Y-m-d');
        $date2=new DateTime($current_day);
        $em = $this->getDoctrine()->getManager();
        if ($date == "aujourdhui") { 
            $cartes = $em->getRepository(Carte::class)->findBy(['DateValidite' => $date2]);
        }
        else if ($date == "demain") { 
            $cartes = $em->getRepository(Carte::class)->findBy(['DateValidite' => new \DateTime('tomorrow')]);
        }
        // else if ($date == "prochainement") { 
        //     $cartes = $em->getRepository(Carte::class)->findBy(['DateValidite' > new \DateTime('tomorrow')]);
        // }
        else
         if ($date == "tous") { 
            $cartes = $em->getRepository(Carte::class)->findAll();
        }
       
        return $this->render('inc/tbodycartefiltre.html.twig', [
            'lstCarteF' => $cartes,
        ]);
    }

    // ================= Liste des Clients Beneficiaire ================= M
    
     /**
     * @Route("/rempselect/{id}", name="rempselect")
     */
    public function rempselect($id)
    {
        // $req="select * from pclients_bénéficiaire where ID_Client ='".$id."'";
        $em = $this->getDoctrine()->getManager();
        $ClientB = $em->getRepository(ClientBeneficiaire::class)->findBy(['Client' => $id]);

        $DDLbenef = $this->render('inc/DDLbenef.html.twig',[
            'lstbenef' => $ClientB,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($DDLbenef));
        return $response;
    }

    // ================= Liste des Clients Beneficiaire ================= M

     /**
     * @Route("/rempselectadd/{id}", name="rempselectadd")
     */
    public function rempselectadd($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ClientB = $em->getRepository(ClientBeneficiaire::class)->findBy(['Client' => $id]);
        $DDLbenef = $this->render('inc/DDLbenefadd.html.twig',[
            'lstbenef' => $ClientB,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($DDLbenef));
        return $response;
    }

 

    // ================= Liste des cartes filter by client et beneficiaire ================= M

     /**
     * @Route("/remptable/{id}/{id2}", name="remptable")
     */
    public function remptable($id, $id2)
    { 
          
        $em = $this->getDoctrine()->getManager();
        if($id2 == "a"){    
            $cartes = $em->getRepository(Carte::class)->findBy(['Client' => $id ]);
        }else  {
            $cartes = $em->getRepository(Carte::class)->findBy(['Client' => $id , 'Beneficiaire' => $id2 ]);
        }
       
            // ===============================
            $DDLbenef = $this->render('inc/tbodycarte.html.twig',[
              'lstCarte' => $cartes,
            ])->getContent();
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($DDLbenef));
            return $response;
    }

    // ================= Ajouter Carte ================= M

    /**
     * @Route("/addcarte", name="addcarte")
     */
    public function addcarte(Request $request,ManagerRegistry $doctrine): Response
    {   
        $em = $this->getDoctrine()->getManager();

        $idcarte = $request->get('idcarte');
        $date = $request->get('datevalidite');
        $date2=new DateTime($date);
        $obs = $request->get('obs');
       
        $client = $em->getRepository(Client::class)->find($request->get('client'));
        $beneficiaire = $em->getRepository(ClientBeneficiaire::class)->find($request->get('beneficiaire'));
        $tarif = $em->getRepository(TypeTarif::class)->find($request->get('tarif'));


        $entityManager = $doctrine->getManager();

        $carte = new Carte();
        $carte->setClient($client);
        $carte->setBeneficiaire($beneficiaire);
        $carte->setTarif($tarif);
        if($request->get('tarif') == '1'){
            $carte->setTypeClient('B2C');
        }
        else  if($request->get('tarif') == '2'){
            $carte->setTypeClient('B2B');
        }
        $carte->setDateValidite($date2);
        $carte->setObs($obs);

        $entityManager->persist($carte);

        $entityManager->flush();
        $carte->setIdCarte('CTR'.$carte->getId());
        $entityManager->flush();
        return $this->redirectToRoute('carte');;
    }
    
    // ================= Popup modifier carte ================= M

    /**
     * @Route("/modifmodalcarte/{id}", name="modifmodalcarte")
     */
    public function modifmodalcarte($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $Carte = $em->getRepository(Carte::class)->findOneBy(['id' => $id]);
    
        $Client = $em->getRepository(Client::class)->findAll();
       
        // ======================================================
        $Tarif = $em->getRepository(TypeTarif::class)->findAll();

        // dd($lstF);
        $html = $this->render('inc/popupmodifcarte.html.twig', [
            'list' => $Carte,
            'lst' => $Client,
            'lsttarif' => $Tarif,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($html));
        return $response;
    }

    // ================= DDL client beneficiaire modifier carte ================= M

     /**
     * @Route("/rempselectmodif/{id}", name="rempselectmodif")
     */
    public function rempselectmodif($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ClientB = $em->getRepository(ClientBeneficiaire::class)->findBy(['Client' => $id]);
        
        $DDLbenef = $this->render('inc/DDLbenefmodif.html.twig',[
            'lstbenef' => $ClientB,
            
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($DDLbenef));
        return $response;
    }

    
    
     // ================ Route modifier carte =================
    // =============================================================== M

    /**
     * @Route("/modifiercarte", name="modifiercarte")
     */
    public function modifiercarte(ManagerRegistry $doctrine,Request $request): Response
    {   
        // dd($request);
        $em = $this->getDoctrine()->getManager();
        $idcarte = $request->get('idcartem');
        $date = $request->get('datevaliditem');
        $date2=new DateTime($date);
        $obs = $request->get('obsm');

        $client = $em->getRepository(Client::class)->find($request->get('clientm'));
        $beneficiaire = $em->getRepository(ClientBeneficiaire::class)->find($request->get('beneficiairem'));
        $tarif = $em->getRepository(TypeTarif::class)->find($request->get('tarifm'));

        $entityManager = $doctrine->getManager();
        $carte = $em->getRepository(Carte::class)->find($request->get('id'));

      

        $carte->setClient($client);
        $carte->setBeneficiaire($beneficiaire);
        $carte->setTarif($tarif);
        $carte->setDateValidite($date2);
        $carte->setObs($obs);
        $entityManager->flush();

        return $this->redirectToRoute('carte');;
    }

    
    // ================ Route popup supprimer carte =================
    // =============================================================== M

    /**
     * @Route("/suppmodalcarte/{id}", name="suppmodalcarte")
     */
    public function suppmodalcarte($id): Response
    {
       
        $em = $this->getDoctrine()->getManager();
        $Carte = $em->getRepository(Carte::class)->findOneBy(['id' => $id]);

        
        $html = $this->render('inc/popupsuppcarte.html.twig', [
            'list' => $Carte,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($html));
        return $response;
    }
    
    // ================ Route supprimer carte =========================
    // =============================================================== M

    /**
     * @Route("/supprimercarte", name="supprimercarte")
     */
    public function supprimercarte(ManagerRegistry $doctrine,Request $request): Response
    {   
        $em = $this->getDoctrine()->getManager();
        // dd($request);
        $entityManager = $doctrine->getManager();
        $carte = $em->getRepository(Carte::class)->find($request->get('id'));
        // dd($carte);
        $entityManager->remove($carte);
        $entityManager->flush();

        return $this->redirectToRoute('carte');;
    }

    // =========================== beneficiaire facturer =================== M
    // =====================================================================


     /**
     * @Route("/rempselectbeneffact/{id}", name="rempselectbeneffact")
     */

    public function rempselectbeneffact($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ClientB = $em->getRepository(ClientBeneficiaire::class)->findBy(['Client' => $id]);
        // $req="select * from pclients_bénéficiaire where ID_Client ='".$id."'";
        $DDLbenef = $this->render('inc/ddlbeneffacturer.html.twig',[
            'lstbenef' => $ClientB,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($DDLbenef));
        return $response;
    }

    // =========================== etat sortie recharge =================== M
    // =====================================================================


     /**
     * @Route("/recharge/{DateDeut}/{Datefin}/{DateF}/{DateD}", name="recharge")
     */

    public function recharge(Request $request,$DateDeut,$Datefin,$DateF,$DateD)
    {
       
        $em = $this->getDoctrine()->getManager('univ')->getConnection();
        $requete4 = "SELECT * FROM `interfacage_dotation` 
                     WHERE interfacage_dotation.DATE_MVT BETWEEN ? AND ? AND interfacage_dotation.E_S=? AND interfacage_dotation.TYPE_CLT=?";
        $statement4 = $em->prepare($requete4);
        $statement4->bindValue(1, $DateDeut);
        $statement4->bindValue(2, $Datefin);
        $statement4->bindValue(3, 1);
        $statement4->bindValue(4, 'ETD');       
        $resultSet4 = $statement4->executeQuery();
        $RechargeETD = $resultSet4->fetchAll();

        $requeteetud = "SELECT * from x_inscription";
        $statement = $em->prepare($requeteetud);
        $resultSet = $statement->executeQuery();
        $etudiants = $resultSet->fetchAll();

        $mpdf=new \Mpdf\Mpdf();

     
        
        $html = $this->renderView('mdpf/bordoJ.html.twig', [
            'RechargeETD' => $RechargeETD,
            'etudiants' => $etudiants,
            'numerobor' => $DateF,
            'datebor' => $DateD,
        ]);
        
        $mpdf->WriteHTML($html);
        $mpdf->output('result.pdf','I');
        die; 
    }

    
    
    

}
