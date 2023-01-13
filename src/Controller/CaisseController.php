<?php

namespace App\Controller;

use DateTime;
use App\Entity\Carte;
use App\Entity\Recharge;
// use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\OperationO;
use App\Entity\OperationLgO;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CaisseController extends AbstractController
{
    /**
     * @Route("/caisse", name="caisse")
     */
    public function index(): Response
    {
        $current_day= new \DateTime('now');
        $current_day = $current_day->format('Y-m-d');
        $date2=new DateTime($current_day);
        
        $em = $this->getDoctrine()->getManager();
        // $cartes = $em->getRepository(Carte::class)->findBy(['DateValidite' => $date2 , 'Client' => 1 , 'Beneficiaire' =>6 , 'TypeClient' =>'B2C']);
        $cartes = $em->getRepository(Carte::class)->findBy(['IdCarte' => 'CRT15430' ]);
        return $this->render('caisse/index.html.twig', [
            'list' => $cartes,
            
        ]);
    }
    /**
     * @Route("/checkcommande/{id}", name="checkcommande")
     */
    public function checkcommande( $id): Response
    {
        // $idrepartition = $request->get('idrepartition');
        // dd($id);
        $em = $this->getDoctrine()->getManager();
        // $cartes = $em->getRepository(Carte::class)->findBy(['DateValidite' => $date2 , 'Client' => 1 , 'Beneficiaire' =>6 , 'TypeClient' =>'B2C']);
        $operation = $em->getRepository(OperationO::class)->findBy(['Repartition' => $id ]);
        $rep = $em->getRepository(OperationO::class)->findBy(['Repartition' => $id ],['id' => 'ASC'],1);
        // dd($operation);
        return $this->render('caisse/checkcommande.html.twig', [
           'listO'=>$operation,
           'rep'=>$rep,
        ]);
    }

     /**
     * @Route("/detailCommande/{id}", name="detailCommande")
     */
    public function detailCommande( $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $operation = $em->getRepository(OperationLgO::class)->findBy(['Operation' => $id ]);
        $operationD = $em->getRepository(OperationO::class)->findBy(['id' => $id ]);
        // dd($operationD);
        $tbody = $this->render('inc/tbodydetailcommande.html.twig',[
            'detail'=>$operation,
            'info'=>$operationD,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;
    }

     
     // ================ Route modifier carte =================
    // =============================================================== M

    /**
     * @Route("/validerRecharge/{id}", name="validerRecharge")
     */
    public function validerRecharge(ManagerRegistry $doctrine,$id): Response
    {   
        // dd($request);
        $em = $this->getDoctrine()->getManager();
        
        $entityManager = $doctrine->getManager();
        $recharge = $em->getRepository(Recharge::class)->findOneBy(['IdRecharge' => $id]);
        // dd($recharge);

        $recharge->setStatut('true');

        $con = $this->getDoctrine()->getConnection();
        $req="INSERT INTO `interfacage_dotation`(`ID_CONSOMMATEUR`, `ID_MVT`, `TYPE`, `E_S`, `ID_SOURCE`, `DATE_MVT`, `HEURE_MVT`, `MT_MVT`, `FLAG`, `ACTIVE_RECHARGE`)
              VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stm=$con->prepare($req);
        $stm->execute([ $recharge->getIdConsommateur(),'RR66', 'Dotation',1,'CLT10001', $recharge->getDateRecharge(), $recharge->getHeureRecharge(), $recharge->getMontant(),1,0]);

        $entityManager->flush();



        return die;
    }
}
