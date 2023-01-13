<?php

namespace App\Controller;

use PDO;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Carte;
use App\Entity\CarteLg;
use App\Entity\Produit;
use App\Entity\Recharge;
use App\Entity\OperationO;
use Mike42\Escpos\Printer;
use App\Entity\Repartition;
use Picqer\Barcode\BarcodeGeneratorJPG;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
require '../ZK/zklibrary.php';
require __DIR__ . '../../../vendor/autoload.php';
use Mike42\Escpos\EscposImage;


class BorneController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/borne/{id}", name="borne")
     */
    public function index($id,SessionInterface $session): Response
    {

        $session->clear();
    
        return $this->render('borne/index.html.twig', [
            'controller_name' => 'BorneController',
            'borne' => $id
        ]);
    }
    

//////////////////////Menu///////////////:::
     /**
     * @Route("/menu/{qr}", name="menu")
     */
    public function menu($qr)
    {
        
        return $this->render('borne/menu.html.twig', [
            'controller_name' => 'IndexController',
            'qrcode' => $qr
            
        ]);
    }
  
    

//////////////////////Menu///////////////:::
     /**
     * @Route("/index", name=" index")
     */
    public function ind()
    {
//         $dompdf = new Dompdf();
// $dompdf->loadHtml('hello world');

// // (Optional) Setup the paper size and orientation
// $dompdf->setPaper('A4', 'landscape');

// // Render the HTML as PDF
// $dompdf->render();

// // Output the generated PDF to Browser
// $dompdf->stream();
       
   }

// ////////////////MENU{affichage}/////////
  /**
     * @Route("/menuaff/{id}/{id_repartition}/{borne}", name="menuaff")
     */
    public function menuaff($id,$id_repartition,SessionInterface $session,$borne)
    {
        // $em = $this->getDoctrine()->getManager()->getConnection();
        $em2 = $this->getDoctrine()->getManager()->getConnection();

        $Today= new \DateTime();
        $todaydate= date_format($Today, 'Y-m-d H:i:s');

        $sql = "SELECT * FROM `carte` WHERE id=$id";
        $statementatt = $em2->prepare($sql);
        $resultatt = $statementatt->executeQuery();
        $cartelog = $resultatt->fetchAll();
        $idcarte = $cartelog[0]['id'];

        $em = $this->getDoctrine()->getManager();
        $cartelogs = $em->getRepository(CarteLg::class)->findBy(['Carte' => $idcarte]);

        ///////////////////////////////////// id ticket /////////////////////////////////
            $id_1 = '';
            $ids = $session->get('iduser');
            if (str_starts_with($ids, 'CND')) {
                $id_1 = 'TCK';
                }
            else{
                $id_1 = 'EMP';
            }
            $randomid = mt_rand(10000000,99999999); 

            for ($i = 0; $i < 14; $i++) {               
                    $randomid = mt_rand(10000000,99999999); 
                    $codebar = "SELECT * FROM `operation_o` WHERE id_operation ='$id_1$randomid'";
                    $statementatt = $em2->prepare($codebar);
                    $resultatt = $statementatt->executeQuery();
                    $attlog = $resultatt->fetchAll();
                    if (empty($attlog)) {
                      $random = $id_1 . $randomid;
                    }      
            }
           
            $session->set('ticket1', $random);
            $session->set('idrepartition', $id_repartition);

        return $this->render('borne/menuaff.html.twig', [
            'controller_name' => 'IndexController',
            'cartelogs' => $cartelogs,
            'today' => $todaydate,
            'Name' => $session->get('name'),
            'Solde' => $session->get('solde'),
            'iduser' => $session->get('iduser'),
            'idcarte' => $id,
            'idrepa' => $id_repartition,
            'ticket' => $session->get('ticket1'),
        
            
        ]);
    }


////////////////Choice/////////
 /**
     * @Route("/choice/{carte}/{borne}", name="choice")
     */
    public function choice(SessionInterface $session,$carte,$borne)
    {
        
        if($session->get('name') != null) {
        ///////////////////////////////////// today repartition  /////////////////////////////////////////////////////////////////////////
        $em = $this->getDoctrine()->getManager()->getConnection();
        
        $todaydate = date('H:i:s');
          
        $requete4 = "SELECT * FROM `carte_repartition` WHERE  `carte_id`=? ";
        $statement4 = $em->prepare($requete4);
        $statement4->bindValue(1, $carte);
       
        $resultSet4 = $statement4->executeQuery();
        $repartition = $resultSet4->fetchAll();

        return $this->render('borne/choice.html.twig', [
            'controller_name' => 'IndexController',
            'carte' => $carte,
            'repartition' => $repartition,
            'borne' => $borne,
            'time' => $todaydate,
            
       ]);
    }
       
       else {
          dd('not logged');
       }
    }


////////////////////RECU////////////////////////////////

/**
 * @Route("/recu", name="recu")
   */
    public function recu()
    {
        $generator = new BarcodeGeneratorHTML();
       
        $code128 = $generator->getBarcode("test", $generator::TYPE_CODE_128);

        return $this->render('borne/recu.html.twig', [
            'controller_name' => 'IndexController',
            'code'=> $code128
        

        ]);
    }

////////////////////pdf///////////////
  /**
     * @Route("/pdf/{id}", name="pdf")
     */
    public function pdf(Request $request,$id,SessionInterface $session)
    {
        $todaydate = new \DateTime('now');
        $todaydate = $todaydate->format('d/m/Y H:i');
        $generator = new BarcodeGeneratorHTML();
        $em = $this->getDoctrine()->getManager()->getConnection();
        $em2 = $this->getDoctrine()->getManager('univ')->getConnection();

        $requete = "SELECT * FROM `operation_o` INNER JOIN operation_lg_o ON operation_lg_o.operation_id=operation_o.id
                    INNER JOIN produit ON produit.id=operation_lg_o.produit_id 
                    WHERE `id_operation`='$id'";
        $statement = $em->prepare($requete);       
        $resultSet = $statement->executeQuery();
        $produitresult = $resultSet->fetchAll();

        
        $requete2 = "SELECT * FROM `carte_repartition`WHERE id=13042";
        $statement2 = $em->prepare($requete2);
       
        $resultSet2 = $statement2->executeQuery();
        $repartition2 = $resultSet2->fetchAll();


        $requete3 = "SELECT ABS(MT_MVT) as solde FROM `interfacage_dotation` WHERE ID_MVT='$id'";

        $statement3 = $em2->prepare($requete3);
       
        $resultSet3 = $statement3->executeQuery();
        $repartition3 = $resultSet3->fetchAll();

        $requete4 = "SELECT SOLDE FROM `interfacage_dotation_solde` WHERE `ID_CONSOMMATEUR`='F11014'";
        $statement4 = $em2->prepare($requete4);
       
        $resultSet4 = $statement4->executeQuery();
        $repartition4 = $resultSet4->fetchAll();

        

        
        $html = $this->renderView('borne/recu.html.twig', [
            'controller_name' => 'IndexController',
            'code'=> $id,
            'ticket'=> $id,
            'products'=> $produitresult,
            'time'=> $todaydate,
            'repartition'=> $repartition2,
            'name'=> $session->get('name'),
            'soldecommande'=> $repartition3[0]['solde'],
            'solde_apres'=> $repartition4[0]['SOLDE'],

     

        ]);
    
$mpdf = new \Mpdf\Mpdf([
    'format' => [150, 170],
    
]);
$mpdf->AddPageByArray([ 
    'margin-top' => 3,
    'margin-bottom' => 4,
    'margin-left' => 10,
    'margin-right' => 10,
]);
$mpdf->SetJS('this.print();');
$mpdf->WriteHTML($html);
$mpdf->Output();
}


////////////////////////////:

////////////////////pdf-releve///////////////
  /**
     * @Route("/releve", name="releve")
     */
    public function releve(Request $request,SessionInterface $session)
    {
     $userid = $session->get('iduser');
     $name = $session->get('name');
     $time = new \DateTime();
     $time = $time->format('d-M-Y');
     $em = $this->getDoctrine()->getManager('univ')->getConnection();                                                                                             
      $requete = "SELECT * FROM `interfacage_dotation` WHERE `ID_CONSOMMATEUR`='$userid' AND E_S=1 ORDER BY `interfacage_dotation`.`DATE_MVT` ASC";  
      $statement = $em->prepare($requete);
      $result = $statement->executeQuery();
      $result = $result->fetchAll();
      $requete2 = "SELECT * FROM `interfacage_dotation_solde` WHERE `ID_CONSOMMATEUR`='$userid'";  
      $statement2 = $em->prepare($requete2);
      $result2 = $statement2->executeQuery();
      $result2 = $result2->fetchAll();
      $code128 = '123';
        
        $html = $this->renderView('borne/releve.html.twig', [
            'controller_name' => 'IndexController',
            'code'=> $code128,
            'data'=>$result,
            'time'=>$time,
            'name'=>$name,
            'id'=>$userid,
            'solde'=>$result2[0]['SOLDE'],

     

        ]);
    
$mpdf = new \Mpdf\Mpdf([
    'format' => [150, 170],
    
]);
$mpdf->AddPageByArray([ 
    'margin-top' => 0,
    'margin-bottom' => 4,
    'margin-left' => 10,
    'margin-right' => 50,
]);
$mpdf->use_kwt = true;
$mpdf->SetJS('this.print();');
$mpdf->WriteHTML($html);
$mpdf->Output();

}


////////////////////////////////////////////////pdf-recharge///////////////
  /**
     * @Route("/recharge/{mantant}", name="recharge")
     */
    public function recharge(Request $request,$mantant,SessionInterface $session)
    {
        $todaydate = new \DateTime('now');
        $todaydate_ = new \DateTime('now');
       
        $todaydate = $todaydate->format('d/m/Y H:i');
       
        $em2 = $this->getDoctrine()->getManager()->getConnection();
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 14; $i++) {               
            $randomString .= $characters[rand(0, $charactersLength - 1)];
           $codebar = "SELECT * FROM `recharge` WHERE `id_recharge`='$randomString'";
                $statementatt = $em2->prepare($codebar);
                $resultatt = $statementatt->executeQuery();
                $attlog = $resultatt->fetchAll();
                if (empty($attlog)) {
                   $random =  $randomString;
                }
           
        }
        $typerecharge = 'Empreinte';
        $userid = $session->get('iduser');
        $name = $session->get('name');
        $entityManager = $this->getDoctrine()->getManager();
        $recharge = new Recharge ;
        $recharge->setIdRecharge($random);
        $recharge->setTypeRecharge($typerecharge);
        $recharge->setIdConsommateur($userid);
        $recharge->setConsommateur($name);
        $recharge->setDateRecharge($todaydate_);
        $recharge->setHeureRecharge($todaydate_);
        $recharge->setMontant($mantant);
        $recharge->setStatut(0);
        $recharge->setDateSys($todaydate_);
        $entityManager->persist($recharge);
        $entityManager->flush();
      
    
        $html = $this->renderView('borne/recharge.html.twig', [
            'controller_name' => 'IndexController',
            'code'=> $random,
            'id'=> $userid,
            'name'=> $name,
            'mantant'=> $mantant,
            'time'=> $todaydate,

     

        ]);
    
$mpdf = new \Mpdf\Mpdf([
    'format' => [150, 170],
    
]);
$mpdf->AddPageByArray([ 
    'margin-top' => 3,
    'margin-bottom' => 4,
    'margin-left' => 10,
    'margin-right' => 50,
]);
$mpdf->SetJS('this.print();');
$mpdf->WriteHTML($html);
$mpdf->Output();
}


////////////////////////////recharge-validate//////////////////////////

/**
 * @Route("/validecommande", name="validecommande")
 * */ 
public function validecommande(SessionInterface $session,Request $request)
{    
    $em = $this->getDoctrine()->getManager('univ')->getConnection();
    $em2 = $this->getDoctrine()->getManager()->getConnection();
    $todaydate = new \DateTime('now');
    $idcarte = $request->request->get('idcarte');  
    $prixtotal = $request->request->get('prix_total');  
    $idrepa = $request->request->get('id_repartition');  
    $panier = $request->request->get('panier');  
    $soldeap = $request->request->get('prixapres');  
    $soldeav = $request->request->get('prixavant');  
    $random = $request->request->get('ticket');  
   
    $name  = $session->get('name');
    $useid = $session->get('iduser'); 
    $client = 'CLT4238';
    $status = 'Attente';

                $entityManager = $this->getDoctrine()->getManager();

//////  insertion operation_o///////////////////

                $requete3 = "INSERT INTO `operation_o`(`carte_id`, `repartition_id`, `id_operation`, `type_operation`, `heure_alias`, `commande_jrs`,`solde_av`, `solde_ap`, 
                            `date_operation`, `heure_operation`,`id_acheteur`, `nom_acheteur`, `id_source`, `statut`, `statut2`,`annuler`, `date_sys`, `alias_jrs`) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $statement3 = $em2->prepare($requete3);
                $statement3->bindValue(1, $idcarte);
                $statement3->bindValue(2, $idrepa);
                $statement3->bindValue(3, $random);
                $statement3->bindValue(4, 'vente');
                $statement3->bindValue(5, $todaydate->format('H:i:s'));
                $statement3->bindValue(6, 20001);
                $statement3->bindValue(7, $soldeav);
                $statement3->bindValue(8, $soldeap);
                $statement3->bindValue(9, $todaydate->format('Y-m-d'));
                $statement3->bindValue(10, $todaydate->format('H:i:s'));
                $statement3->bindValue(11, $useid);
                $statement3->bindValue(12, $name);
                $statement3->bindValue(13, $client);
                $statement3->bindValue(14, $status);
                $statement3->bindValue(15, $status);
                $statement3->bindValue(16, 0);
                $statement3->bindValue(17, $todaydate->format('Y-m-d'));
                $statement3->bindValue(18, 1878787878);
                $resultSet3 = $statement3->executeQuery();


    //////////////////////get id operation////////////////////

                $getidoperation = "SELECT * FROM `operation_o` WHERE id_operation = '$random'";
                $statementido = $em2->prepare($getidoperation);
                $resultido = $statementido->executeQuery();
                $idop = $resultido->fetchAll();


////// boucle insertion operation_lg///////////////////
                foreach ($panier as &$value) {
 
  
                $requeteproduit = "SELECT id FROM `produit` WHERE `id_produit`='".$value['idproduit']."'";

                $statementidproduit = $em2->prepare($requeteproduit);
                $produits = $statementidproduit->executeQuery();
                $resultproduits = $produits->fetchAll();
               

                
 

                $insertoplg = "INSERT INTO `operation_lg_o`( `operation_id`, `produit_id`, `ligne`, `acc`, `qte`, `prix_u`, `tconvention`, `prix_ttc`, `taux`, `prix_ht`, `npage`, `date_sys`, `heure_sys`) 
                               VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $statement = $em2->prepare($insertoplg);
                $statement->bindValue(1, $idop[0]['id']);
                $statement->bindValue(2, $resultproduits[0]['id']);
                $statement->bindValue(3, 0);
                $statement->bindValue(4, 0);
                $statement->bindValue(5, $value['count']);
                $statement->bindValue(6, $value['prix']);
                $statement->bindValue(7, 0);
                $statement->bindValue(8, $value['prix_totale']);
                $statement->bindValue(9, 0);
                $statement->bindValue(10, $value['prix_totale']);
                $statement->bindValue(11, 0);
                $statement->bindValue(12, $todaydate->format('Y-m-d'));
                $statement->bindValue(13, $todaydate->format('Y-m-d'));
                $resultSet = $statement->executeQuery();

                //////////////////// - Carte////////////////////////////////////////////////


                $qte = $value['count'];
                $productid = $value['idproduit'];
                $updatecarte = "UPDATE `carte_lg` 
                INNER JOIN produit ON produit.id=carte_lg.produit_id
                SET carte_lg.stock_cmd= `stock_cmd` + $qte where  produit.id_produit    ='$productid'and carte_lg.carte_id='$idcarte'";
                $statementupd = $em2->prepare($updatecarte);
                $resultupd = $statementupd->executeQuery();

                       }


    /////////////////////////// insertion interface dotation /////////////

                    $insertoplg = "INSERT INTO `interfacage_dotation`(`ID_CONSOMMATEUR`, `ID_MVT`, `TYPE`, `E_S`, `ID_SOURCE`, `DATE_MVT`, `HEURE_MVT`, `MT_MVT`, `FLAG`, `ACTIVE_RECHARGE`)
                    VALUES (?,?,?,?,?,?,?,?,?,?)";
                    $statement2 = $em->prepare($insertoplg);
                    $statement2->bindValue(1, $useid);
                    $statement2->bindValue(2, $random);
                    $statement2->bindValue(3, 'Dotation');
                    $statement2->bindValue(4, 2);
                    $statement2->bindValue(5, $client);
                    $statement2->bindValue(6, $todaydate->format('Y-m-d'));
                    $statement2->bindValue(7, $todaydate->format('H:i:s'));
                    $statement2->bindValue(8, -$prixtotal);
                    $statement2->bindValue(9, 1);
                    $statement2->bindValue(10, 0);
                    $result_int = $statement2->executeQuery();









///////////////////////////////////////////////////////////////:

    return new JsonResponse($random);        
    


}

////////////////////////////:

/**
 * @Route("/printer", name="printer")
 * */ 
public function printer()
{    
    
    $connector = new FilePrintConnector("php://stdout");
    $printer = new Printer($connector);
    $printer -> text("Hello World!\n");
    $printer -> cut();    
    $printer -> close();
    return new JsonResponse('ok');        


}

/////////////////////Cart////////////

/**
 * @Route("/Cart", name="Cart")
 * */ 
public function Cart($carte)
{    
    return $this->render('borne/Cart.html.twig', [
        'controller_name' => 'IndexController',
    
        
    ]);

}
/**
 * @Route("/destroy", name="destroy")
 * */ 
public function destroy(SessionInterface $session)
{    
    // $borne = $session->get('borne'); 
    $borne = 1;
    $session->clear();
    // $this->redirect('borne', array('id' => 1));
    return $this->redirectToRoute('borne', ['id' => $borne]);

}

/**
     * @Route("/bornetest", name="bornetest")
     */
    public function bornetest(Request $request,SessionInterface $session)
    {              
        $em = $this->getDoctrine()->getManager()->getConnection();
        $em2 = $this->getDoctrine()->getManager('univ')->getConnection();

                                    $bornes = $request->request->get('borne');  
                                    $borne="SELECT * FROM `borne` where id=$bornes";
                                    
                                    $statementborn = $em->prepare($borne);
                                    $resultborn = $statementborn->executeQuery();
                                    $attborn = $resultborn->fetchAll();
                                    $ip = $attborn[0]['ip'];
                                    try {
                                        $zk = new \ZKLibrary($ip, 4370, 'udp');
                                        $zk->connect();
                                        $users = $zk->getUser();
                                        $attendace = $zk->getAttendance();

                                    } catch (\Throwable $th) {
                                        
                                    }
                                   
                                       if (empty($attendace) == true) {
                                           dd('empty');
                                       }
                                       else{
                                      
                                            foreach ($attendace as $att ){  
           
                                                $sqlatt="SELECT distinct street,USERID,Name from userinfo where Badgenumber='$att[1]'";
                                    
                                                $statementatt = $em2->prepare($sqlatt);
                                                $resultatt = $statementatt->executeQuery();
                                                $attlog = $resultatt->fetchAll();
                                             foreach ($attlog as $key) {

                                                $userid = $key['street'];    
                                                $name = $key['Name'];    
                                                $iduser = $key['USERID'];    

                                             }
                                                       $req = "INSERT INTO `check_borne`(`borne_id`, `userid`, `checktime`)
                                                       VALUES ('" .$bornes. "','" .$userid. "','" .$att[3]. "')";
                                                        $insert = $em->prepare($req);
                                                        $insertsucc = $insert->executeQuery();
                                                        
                                                       
                                            
                                                      
                                    }

  /////////////////////////////////////  Get pointage /////////////////////////////////////////////////////////////////////////:

                                    $getcheck = "SELECT * FROM `check_borne` where borne_id=$bornes  ORDER BY `check_borne`.`checktime` DESC limit 1";

                                    $statementcheck = $em->prepare($getcheck);
                                    $resultcheck = $statementcheck->executeQuery();
                                    $check = $resultcheck->fetchAll();
                                    $ids = $check[0]['userid'];
                                    

  /////////////////////////////////////  /////////////////////////////////////////////////////////////////////////

                                            if (empty($check)) {
                                                $check = "no";
                                            }
                                            else {
                                                $check = "oui";
                                            }

                                            $session->set('name', $name);
                                            $session->set('iduser', $userid);
                                            $session->set('borne', $bornes);
                                            $zk->clearAttendance();
                                        }
                                        
                                       

    return new JsonResponse($check);        

}   

    /**
     * @Route("/bornevalide", name="bornevalide")
     */

    public function bornevalide(Request $request,SessionInterface $session)
    {
        if($session->get('name') != null) {
        $Today= new \DateTime();        
        $em = $this->getDoctrine()->getManager()->getConnection();
        $em2 = $this->getDoctrine()->getManager('univ')->getConnection();
        $borne = 1;
        $getcheck = "SELECT * FROM `check_borne` where borne_id=$borne  ORDER BY `check_borne`.`checktime` DESC limit 1";

        $statementcheck = $em->prepare($getcheck);
        $resultcheck = $statementcheck->executeQuery();
        $check = $resultcheck->fetchAll();

        $ids = $check[0]['userid'];
/////////////////////////////////////  /////////////////////////////////////////////////////////////////////////

///////////////////////////////////// GET user info + solde  /////////////////////////////////////////////////////////////////////////

            $requete = "SELECT * FROM `userinfo` WHERE `street`='$ids' limit 1";
                    $statement = $em2->prepare($requete);
                    $resultSet = $statement->executeQuery();
                    $data = $resultSet->fetchAll();
                    
            $requete2 = "SELECT * FROM `interfacage_dotation_solde` WHERE `ID_CONSOMMATEUR`='$ids'";
                    $statement2 = $em2->prepare($requete2);
                    $resultSet2 = $statement2->executeQuery();
                    $data2 = $resultSet2->fetchAll();
                    // dd($requete2);
///////////////////////////////////// today carte  /////////////////////////////////////////////////////////////////////////
          
            $requete3 = "SELECT * FROM `carte` where client_id=? AND beneficiaire_id=6 AND date_validite = ?";
            $statement3 = $em->prepare($requete3);
            $statement3->bindValue(1, 1);
            $statement3->bindValue(2, $Today->format('Y-m-d'));
            $resultSet3 = $statement3->executeQuery();
            $carte = $resultSet3->fetchAll();
          

            // dd($carte[0]['id']);
///////////////////////////////////// DELETE check - borne /////////////////////////////////////////////////////////////////////////

            // $requete3 = "DELETE FROM `check_borne` WHERE `borne_id`=$borne";
            // $statement3 = $em->prepare($requete3);
            // $resultSet3 = $statement3->executeQuery();
            
        //     }
        //    }





        $session->set('solde', $data2[0]['SOLDE']);
      
        return $this->render('borne/menu.html.twig', [
            'controller_name' => 'IndexController',
            "userinfo" =>$data,
            "solde" =>$data2,
            "session" =>$session,
            "carte" =>$carte[0]['id'],
            "borne" => $borne
            
        ]);
        }
       else{
           dd('not');
       }
     
    }


 //////////////////////////////////// select produit borne ////////////////////////////////////////////////////:
 
    /**
     * @Route("/borneproduit", name="borneproduit")
     */
    
    public function borneproduit(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produitid = $request->get('idproduit');

        $produit = $em->getRepository(Produit::class)->findBy(['IdProduit' =>$produitid]);
        $html = $this->render('borne/tableborn.html.twig', [
            'products' => $produit
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($html));
        return $response;
    }
 

}
