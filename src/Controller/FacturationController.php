<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Entity\Client;
use App\Entity\CarteLg;
use App\Entity\TypeTarif;
use App\Entity\Facturation;
use App\Entity\CarteRepartition;
use Doctrine\DBAL\DriverManager;
use App\Entity\ClientBeneficiaire;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\OperationO;
use App\Entity\OperationLgO;

class FacturationController extends AbstractController
{
     /**
     * @Route("/valider/{id}", name="valider")
     */
    public function index(ManagerRegistry $doctrine,$id)
    {
        $mpdf=new \Mpdf\Mpdf();

        $em = $this->getDoctrine()->getManager();
        $cartes = $em->getRepository(Carte::class)->find($id);

        $repartition = $em->getRepository(CarteRepartition::class)->findBy(['Carte' => $id]);

        $produits = $em->getRepository(CarteLg::class)->findBy(['Carte' => $id]);

        
        $html = $this->renderView('mdpf/index.html.twig', [
            'detailC' => $cartes,
            'detailR' => $repartition,
            'detailP' => $produits,
        ]);
        
        
        $entityManager = $doctrine->getManager();
        $cartes->setGenerer(1);
        $cartes->setFacturer(0);
        $entityManager->flush();

        $mpdf->WriteHTML($html);
        $mpdf->output('result.pdf','D');
        die; 
    }

    /**
     * @Route("/repartition/{id}/{id2}", name="repartition")
     */
    public function repartition($id,$id2)
    {
        $mpdf=new \Mpdf\Mpdf();

        $em = $this->getDoctrine()->getManager();
        $cartes = $em->getRepository(Carte::class)->find($id);

        $repartition = $em->getRepository(CarteRepartition::class)->find( $id2);

        $produits = $em->getRepository(CarteLg::class)->findBy(['Carte' => $id,'Repartition'=>$id2]);
       
        $currentday= getdate();

        $html = $this->renderView('mdpf/repartition.html.twig', [
            'detailC' => $cartes,
            'detailR' => $repartition,
            'detailP' => $produits,
            'current' => $currentday,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->output('result.pdf','I');
        die; 
    }

    

     /**
     * @Route("/rechercheCarte", name="rechercheCarte")
     */
    public function rechercheCarte(Request $request)
    {
       
        $DateD = $request->get('DateD');
        $DateF = $request->get('DateF');
        $Client = $request->get('Client');
        $Benef = $request->get('Benef');
        $typeC = $request->get('typeC');

        $con = $this->getDoctrine()->getManager()->getConnection();
        $req="select carte.id, id_carte,client.client,client_beneficiaire.beneficiaire,client.id_client,client_beneficiaire.id_beneficiaire from carte
        inner join client on carte.client_id=client.id
        inner join client_beneficiaire on carte.beneficiaire_id = client_beneficiaire.id
        where carte.client_id = '".$Client."'  and carte.beneficiaire_id='".$Benef."' and carte.tarif_id='".$typeC."'
        and facturer != 1 and carte.generer=1 and date_validite between '".$DateD."' and '".$DateF."' ";
        
        $stm=$con->prepare($req);
        $result = $stm->executeQuery();
        $lstbenef= $result->fetchAll();

        $DDLbenef = $this->render('inc/tbodyfacturer.html.twig',[
            'lstcarte' => $lstbenef,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($DDLbenef));
        return $response;
    }

    
    

     /**
     * @Route("/ajouterfacture", name="ajouterfacture")
     */
    public function ajouterfacture(Request $request,ManagerRegistry $doctrine)
    {
        // dd($request);

        $DateD = $request->get('DateD');
        $DDA = $request->get('DDA');
        $Client = $request->get('Client');
        $Benef = $request->get('Benef');
        $typeC = $request->get('typeC');
       
        // dd($date2);
        // $current_day = $current_day->format('Y-m-d');

        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository(Client::class)->find($request->get('Client'));
        $beneficiaire = $em->getRepository(ClientBeneficiaire::class)->find($request->get('Benef'));
        $tarif = $em->getRepository(TypeTarif::class)->find($request->get('typeC'));
        $date = new \DateTime('@'.strtotime('now'));
        $DateD = new \DateTime('@'.strtotime($request->get('DateD')));

        $entityManager = $doctrine->getManager();
        $facture = new Facturation();
        $facture->setDateFact($date);
        $facture->setDemandeA($DDA);
        $facture->setDateA(new \DateTime($request->get('DateD')));
        $facture->setClient($client);
        $facture->setBeneiciaire($beneficiaire);
        $facture->setTarif($tarif);

        $entityManager->persist($facture);
        $entityManager->flush();
        $facture->setNumFact('RUR'.$facture->getId());
        $entityManager->flush();

        
        return new JsonResponse($facture->getId());
        return die; 
    }

    
     /**
     * @Route("/facturation", name="facturation")
     */
    public function facturation(Request $request,ManagerRegistry $doctrine)
    {
        // dd($request);
        $entityManager = $doctrine->getManager();
        $idfact=$request->get('idfact');
        $idcarte = $request->get('idcarte');
        $em = $this->getDoctrine()->getManager();
        $cartes = $em->getRepository(Carte::class)->find($idcarte);
        $facture = $em->getRepository(Facturation::class)->find($idfact);
        $cartes->setFacturer(1);
        $cartes->setFacture($facture);
        $entityManager->flush();

        // $con = $this->getDoctrine()->getConnection();
        // $req="update pcarte set Facturer=1 , numfact=".(int)$idfact." where ID_Carte='".$idcarte."' ";
        // $stm=$con->prepare($req);
        // $stm->execute();

        return new JsonResponse($idfact);
        return die;
    }

    /**
     * @Route("/facturer/{id}", name="facturer")
     */
    public function facturer($id)
    {
        $mpdf=new \Mpdf\Mpdf();

        
        $em = $this->getDoctrine()->getManager();
        $cartes = $em->getRepository(Facturation::class)->find($id);
        $con = $this->getDoctrine()->getConnection();
        // $req1="SELECT Client , Bénéficiaire , Tarif , numfact , datefact, dateA ,demandeA FROM `pfacturer` 
        // inner join pclients on pfacturer.ClientF=pclients.ID_Client
        // inner join pclients_bénéficiaire on pfacturer.BeneficiaireF=pclients_bénéficiaire.ID_Bénéficiaire
        // inner join ptype_tarif on pfacturer.TarifF=ptype_tarif.ID_Tarif
        // WHERE id=".$id."";
        // $stm1=$con->prepare($req1);
        // $stm1->execute();
        // $detailcarte= $stm1->fetch();


        // $datebycartelg=$em->getRepository(Carte::class)->findBy(["Facture"=>$id]);
        $req2="select distinct carte.date_validite from carte_lg
        inner join carte_repartition on carte_repartition.id=carte_lg.repartition_id
        inner join carte on carte.id=carte_repartition.carte_id
        where carte.facture_id='".$id."'  " ;
        // ptype_tarif.Tarif='Standard'  and Date_Validité BETWEEN '2018-10-03' and '2018-10-09' 
        // GROUP BY pcarte_lg.ID_Repartition order by Date_Validité ASC 
        $stm2=$con->prepare($req2);
        $resut=$stm2->executeQuery();
        $detaildate= $resut->fetchAll();

        /////////////////::
        
        $req3="select carte_lg.repartition_id,carte_lg.carte_id,carte_repartition.repartition,carte_repartition.heure,
        carte_repartition.pax, carte.date_validite,carte_lg.produit_id,SUM(carte_lg.stock_cmd*produit_tarif.tarif_ttc) montant 
        from carte_lg inner join carte_repartition on carte_repartition.id=carte_lg.repartition_id
        inner join carte on carte.id=carte_repartition.carte_id
        INNER join produit_tarif on produit_tarif.produit_id=carte_lg.produit_id
        where carte.facture_id='".$id."' and produit_tarif.tarif_id=carte.tarif_id GROUP BY carte_repartition.id_repartition";
        // dd($req3);
        $stm3=$con->prepare($req3);
        $res=$stm3->executeQuery();
        $detailrep3= $res->fetchAll();
      //  dd($detailrep);
        $html = $this->renderView('mdpf/facturer.html.twig', [
            'detailC' => $cartes,
            'detailR' => $detaildate,
            'detailP' => $detailrep3,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->output('result.pdf','I');
        die; 
    }

    
    
    /**
     * @Route("/B2C/{id}", name="B2C")
     */
    public function B2C($id)
    {
        $mpdf=new \Mpdf\Mpdf();

        $em = $this->getDoctrine()->getManager();
        $cartes = $em->getRepository(Carte::class)->find($id);
        $cartelg = $em->getRepository(CarteLg::class)->findBy(['Carte'=>$id]);
        $con = $this->getDoctrine()->getConnection();
        // $req1="SELECT `ID_Carte`,`Nom_Carte`,`Date_Validité`,`Obs`,ptt.Tarif,pcb.Bénéficiaire FROM `pcarte`
        // inner join ptype_tarif ptt on pcarte.ID_Tarif=ptt.ID_Tarif
        // inner JOIN pclients_bénéficiaire pcb on pcarte.ID_Bénéficiaire=pcb.ID_Bénéficiaire
        // WHERE  ID_Carte ='".$id."'";
        // $stm1=$con->prepare($req1);
        // $stm1->execute();
        // $detailcarte= $stm1->fetch();
        $req2="SELECT DISTINCT pfc.famille_c FROM `carte_lg` pcl 
        inner join produit pp on pcl.produit_id=pp.id 
        inner join carte pc on pcl.carte_id=pc.id 
        inner join famille_sous_c pfsc on pp.famille_sous_c_id=pfsc.id 
        INNER join famille_carte pfc on pfsc.famille_c_id=pfc.id
         WHERE pcl.carte_id ='".$id."'";
        $stm2=$con->prepare($req2);
        $res=$stm2->executeQuery();
        $detailrep= $res->fetchAll();

        /////////////////::
        
        // $req3="SELECT pcl.ID_Produit,pp.Produit,pp.Unité_Vente,pcl.Stock_Carte,pcl.Stock_Cmd,pcl.Stock_Reste,pfc.FamilleC 
        // FROM `pcarte_lg` pcl
        // inner join pproduits pp on pcl.ID_Produit=pp.ID_Produit
        // inner join pcarte pc on pcl.ID_Carte=pc.ID_Carte
        // inner join pfamillessous_carte pfsc on pp.ID_FamilleSousC=pfsc.ID_FamilleSousC
        // INNER join pfamilles_carte pfc on pfsc.ID_FamilleC=pfc.ID_FamilleC
        // WHERE pcl. ID_Carte ='".$id."'";
        // $stm3=$con->prepare($req3);
        // $stm3->execute();
        // $detailrep3= $stm3->fetchAll();
      //  dd($detailrep);
        $currentday= getdate();

        $html = $this->renderView('mdpf/B2C.html.twig', [
            'detailC' => $cartes,
            'detailR' => $detailrep,
            'detailP' => $cartelg,
            'current' => $currentday,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->output('result.pdf','I');
        die; 
    }

    /**
     * @Route("/pdfrecu/{id}", name="pdfrecu")
     */
    public function pdfrecu(ManagerRegistry $doctrine,$id)
    {
    
        $cpt=1;
        // $generator = new BarcodeGeneratorHTML();
        
        // $code128 = "78887711";
        $entityManager = $doctrine->getManager();
        $em = $this->getDoctrine()->getManager();
        $operation = $em->getRepository(OperationLgO::class)->findBy(['Operation' => $id ]);
        $operationd = $em->getRepository(OperationO::class)->findBy(['id' => $id ]);
        $operationD = $em->getRepository(OperationO::class)->findOneBy(['id' => $id ]);
        $operationD->setStatut('Validé');
        $entityManager->flush();
        $cpt = $em->getRepository(OperationO::class)->findBy([ 'Repartition' => 10845 , 'Statut' => 'Validé']);
        // dd($cpt);
        $html = $this->renderView('inc/infoticket.html.twig', [
            'controller_name' => 'IndexController',
            // 'code'=> $code128,
            'detail'=>$operation,
            'info'=>$operationd,
            'cpt'=>$cpt,
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
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
}

 /**
     * @Route("/bordoJ", name="bordoJ")
     */
    public function bordoJ(ManagerRegistry $doctrine)
    {
        $mpdf=new \Mpdf\Mpdf();

        // $em = $this->getDoctrine()->getManager();
        // $cartes = $em->getRepository(Carte::class)->find($id);

        // $repartition = $em->getRepository(CarteRepartition::class)->findBy(['Carte' => $id]);

        // $produits = $em->getRepository(CarteLg::class)->findBy(['Carte' => $id]);

        
        $html = $this->renderView('mdpf/bordoJ.html.twig', [
            // 'detailC' => $cartes,
            // 'detailR' => $repartition,
            // 'detailP' => $produits,
        ]);
        
        
        // $entityManager = $doctrine->getManager();
        // $cartes->setGenerer(1);
        // $cartes->setFacturer(0);
        // $entityManager->flush();

        $mpdf->WriteHTML($html);
        $mpdf->output('result.pdf','I');
        die; 
    }

     /**
     * @Route("/remplirtbodyrep/{id}", name="remplirtbodyrep")
     */
    public function remplirtbodyrep(ManagerRegistry $doctrine,$id)
    {
        // $mpdf=new \Mpdf\Mpdf();

        $em = $this->getDoctrine()->getManager();
        $cartes = $em->getRepository(Carte::class)->find($id);

        $repartition = $em->getRepository(CarteRepartition::class)->findBy(['Carte' => $id]);

        // $produits = $em->getRepository(CarteLg::class)->findBy(['Carte' => $id]);
        $tbody = $this->render('inc/tbodylstrep.html.twig',[
            'lstRep'=>$repartition,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;
        
        // $html = $this->renderView('mdpf/index.html.twig', [
        //     'detailC' => $cartes,
        //     'detailR' => $repartition,
        //     'detailP' => $produits,
        // ]);
        
        
        // $entityManager = $doctrine->getManager();
        // $cartes->setGenerer(1);
        // $cartes->setFacturer(0);
        // $entityManager->flush();

        // $mpdf->WriteHTML($html);
        // $mpdf->output('result.pdf','D');
        // die; 
    }
}
