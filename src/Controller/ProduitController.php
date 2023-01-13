<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Entity\CarteLg;
use App\Entity\Produit;
use App\Entity\TypeTarif;
use App\Entity\TypeFamille;
use App\Entity\TypeProduit;
use App\Entity\FamilleCarte;
use App\Entity\FamilleSousC;
use App\Entity\ProduitTarif;
use App\Entity\CarteRepartition;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
   
    

    // ================ Route remplissage table produit par repartition ================= M
    // ==================================================================================

    /**
     * @Route("/remplirtablepro/{id}", name="remplirtablepro")
     */
    public function remplirtablepro($id)
    {   
       
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository(CarteLg::class)->findBy(['Repartition' => $id]);
        // dd($produits);
        $tbody2 = $this->render('inc/tbodyPro.html.twig',[
            'lstPro'=>$produits,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody2));
        return $response;
      
    }
    

    
    // ================ Route remplissage popup calcul par repartition ================= M
    // ==================================================================================

    /**
     * @Route("/remplirpopupcalcul/{id}", name="remplirpopupcalcul")
     */
    public function remplirpopupcalcul($id)
    {   
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository(CarteLg::class)->findBy(['Repartition' => $id]);
        // dd($produits);
        $tbody2 = $this->render('inc/tbodycalcul.html.twig',[
            'lstPro'=>$produits,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody2));
        return $response;
      
    }
    
    
    // ================ Route popup ajouter produit =================  M
    // ===============================================================

    /**
     * @Route("/remplirpopupajouterprod", name="remplirpopupajouterprod")
     */
    public function remplirpopupajouterprod(Request $request): Response
    {
         $idcarte = $request->get('idcarte');
        $idrepartition = $request->get('idrepartition');
       
        $em = $this->getDoctrine()->getManager();
        $famille = $em->getRepository(FamilleCarte::class)->findAll();
        
        $html = $this->render('inc/popupajouterproduit.html.twig', [
            'lstfamille' => $famille,
            'idcarte' => $idcarte,
            'idrepartition' => $idrepartition
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($html));
        return $response;
    }
    
    
    // ================ Route remplissage table product add supprimer=================
    // =============================================================== non M

    // /**
    //  * @Route("/remplirinfoproduct/{id}", name="remplirinfoproduct")
    //  */
    // public function remplirinfoproduct($id): Response
    // {
    //     $con = $this->getDoctrine()->getConnection();
    //     $req="select * from pproduit
    //     where ID_Produit  ='".$id."' ";
    //     // dd($req);
    //     $stm=$con->prepare($req);
    //     $stm->execute();
    //     $lstF= $stm->fetch();

        
    //     $html = $this->render('inc/popupsuppcarte.html.twig', [
    //         'list' => $lstF,
    //     ])->getContent();
    //     $response = new Response();
    //     $response->headers->set('Content-Type', 'application/json');
    //     $response->setContent(json_encode($html));
    //     return $response;
    // }
    


     // ================ Route ajouter produit par reparttiton =================
    // =============================================================== non M

    /**
     * @Route("/addproduitcarte", name="addproduitcarte")
     */
    public function addproduitcarte(Request $request,ManagerRegistry $doctrine): Response
    {   
        // dd($request);
        $idproduit = $request->get('idproduit');
        $idcarte = $request->get('idcarte');
        $idrepartition = $request->get('idrepartition');
        $qtep=$request->get('qtep');
        // dd($request);
        $em = $this->getDoctrine()->getManager();
        $carte = $em->getRepository(Carte::class)->find($request->get('idcarte'));
        $repartition = $em->getRepository(CarteRepartition::class)->find($request->get('idrepartition'));
        $produit = $em->getRepository(Produit::class)->find($request->get('idproduit'));
        
        $entityManager = $doctrine->getManager();
        $cartelg = new CarteLg();

        $cartelg->setStockCarte($qtep);
        $cartelg->setUnite('U');
        $cartelg->setStockCmd(0);
        $cartelg->setStockReste($qtep);
        $cartelg->setRepartition($repartition);
        $cartelg->setCarte($carte);
        $cartelg->setProduit($produit);
        $cartelg->setIdCarteLg(0);

        
        $entityManager->persist($cartelg);
        $entityManager->flush();

        $produits = $em->getRepository(CarteLg::class)->findBy(['Repartition' => $request->get('idrepartition')]);

        // $con = $this->getDoctrine()->getConnection();
    
        // $req="insert into pcarte_lg (ID_Repartition,ID_Carte,ID_Produit,Stock_Carte,Stock_Cmd,Stock_Reste) values(?,?,?,?,?,?)";
        // $stm=$con->prepare($req);
        // $stm->execute([ $idrepartition,$idcarte, $idproduit,$qtep,'0',$qtep]);

        // $req2="select pp.ID_Produit,pp.produit,pfsc.familleSousC,pcl.Stock_Carte,pcl.ID_Repartition from pcarte_lg pcl
        // inner join pproduits pp on pcl.ID_Produit=pp.ID_Produit 
        // inner join pfamillessous_carte pfsc on pp.ID_FamilleSousC = pfsc.ID_FamilleSousC
        //  where ID_Repartition ='".$idrepartition."'";
        // $stm2=$con->prepare($req2);
        // $stm2->execute();
        // $lstFamille= $stm2->fetchAll();
        $tbody2 = $this->render('inc/tbodyPro.html.twig',[
            'lstPro'=>$produits,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody2));
        return $response;
    }
    
    
    // ================ Route supprimer produit par carte =================
    // ===============================================================  M

    /**
     * @Route("/deleteproduitrepartition/{id}", name="deleteproduitrepartition")
     */
    public function deleteproduitrepartition(ManagerRegistry $doctrine, $id,Request $request)
    {   
      

        $em = $this->getDoctrine()->getManager();
        $entityManager = $doctrine->getManager();

        $cartelg = $em->getRepository(CarteLg::class)->find($id);
        $entityManager->remove($cartelg);
        $entityManager->flush();

        $produits = $em->getRepository(CarteLg::class)->findBy(['Repartition' => $request->get('idrepartition')]);
        dd($produits);
        $tbody2 = $this->render('inc/tbodyPro.html.twig',[
            'lstPro'=>$produits,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody2));
        return $response;

    }

    

    // ================ Route remplissage table popup supprimer produit par repartition =================
    // ======================================================================  M

    /**
     * @Route("/remplirpopupsupprimerpro/{id}", name="remplirpopupsupprimerpro")
     */
    public function remplirpopupsupprimerpro( $id)
    {   
      
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository(CarteLg::class)->find($id) ;
        // dd($produits);
        $tbody = $this->render('inc/popupsuppproduit.html.twig',[
            'lstRep'=>$produits,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody));
        return $response;
      
    }
    
    
    
     // ================ Route modifier qte produit par repartition =================
    // ===============================================================  M

    /**
     * @Route("/updateqteproduit", name="updateqteproduit")
     */
    public function updateqteproduit(ManagerRegistry $doctrine,Request $request)
    {   
        // dd($request);   
        $qtec = $request->get('qtec');
        $qtes = $request->get('qtes');
        $qter = $request->get('qter');

        // $idcartelg = $request->get('idcartelg');

        $em = $this->getDoctrine()->getManager();
        $entityManager = $doctrine->getManager();

        $cartelg = $em->getRepository(CarteLg::class)->find($request->get('idcartelg'));
        $cartelg->setStockCarte($qtes);
        $cartelg->setStockCmd($qtec);
        $cartelg->setStockReste($qter);

        $entityManager->flush();
        
        $produits = $em->getRepository(CarteLg::class)->findBy(['Repartition' => $request->get('idrepartition')]);
    
        $tbody2 = $this->render('inc/tbodyPro.html.twig',[
            'lstPro'=>$produits,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbody2));
        return $response;

    }

     
    // ================ Route remplissage table Sous Famille =================
    // =======================================================================

    // /**
    //  * @Route("/remplirtableSousFamille/{id}", name="remplirtableSousFamille")
    //  */
    // public function remplirtableSousFamille($id)
    // {   
    //     $lstSousFamille = $this->getDoctrine()->getRepository(FamilleSousC::class)->findBy(["FamilleC"=>$id]);



        // $con = $this->getDoctrine()->getConnection();
        // $req="select * from pfamillessous_carte where ID_FamilleC ='".$id."'";
        // $stm=$con->prepare($req);
        // $stm->execute();
        // $lstSousFamille= $stm->fetchAll();
        // $tbodySousFamille = $this->render('inc/tbodySousFamille.html.twig',[
        //     'lstSousF' => $lstSousFamille
        //     ])->getContent();
    
        //     $response = new Response();
        //     $response->headers->set('Content-Type', 'application/json');
        //     $response->setContent(json_encode($tbodySousFamille));
        //     return $response;
        // }

    //     // $con = $this->getDoctrine()->getConnection();
    //     // $req="select * from pfamillessous_carte where ID_FamilleC ='".$id."'";
    //     // $stm=$con->prepare($req);
    //     // $stm->execute();
    //     // $lstSousFamille= $stm->fetchAll();
    //     $tbodySousFamille = $this->render('inc/tbodySousFamille.html.twig',[


    
    // // ================ Route remplissage navbar sous famille =================
    // // ====================================================================== M


    /**
     * @Route("/remplirNavSousFamille/{id}", name="remplirNavSousFamille")
     */
    public function remplirNavSousFamille($id)
    {   
        $em = $this->getDoctrine()->getManager();
        $famille= $em->getRepository(FamilleCarte::class)->find( $id);
        // dd($famille);
        $lstSousFamille = $em->getRepository(FamilleSousC::class)->findBy(['FamilleC' => $famille]);
        // dd($lstSousFamille);
        $NavSousFamille = $this->render('inc/NavSousFamille.html.twig',[

          'lstSousF' => $lstSousFamille
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        // $response->setContent(json_encode($tbodySousFamille));

        $response->setContent(json_encode($NavSousFamille));
        return $response;
      
    }



    // ================ Route ajouter produit product =================
    // ===============================================================

    /**
     * @Route("/addproduitproduct", name="addproduitproduct")
     */
    public function addproduitproduct(Request $request): Response
    {   
       
        $sousfamille = $request->get('sousfamille');
        $produit = $request->get('produit');
        $typeproduit = $request->get('typeproduit');
        $visible = $request->get('visible');
        $accomp = $request->get('accomp');
        $choix = $request->get('choix');
        $standard = $request->get('standard');
        $B2B = $request->get('B2B');
        $thospital = $request->get('thospital');
        $tarifs=array($standard,$B2B,$thospital);
    
        $entityManager = $this->getDoctrine()->getManager();
        $product = new Produit;

        $product->setProduit($produit);
        $product->setUniteVente('U');
        $product->setVisib($visible);
        $product->setAvoirAcc($accomp);
        $product->setChoix($choix);
        $product->setIdProduit('PDT');
        $product->setFamilleSousC($entityManager->getRepository(FamilleSousC::class)->find($sousfamille));
        $product->setTypeProduit($entityManager->getRepository(TypeProduit::class)->find($typeproduit));

        $entityManager->persist($product);
        $entityManager->flush();

        $product->setIdProduit('PDT'.$product->getId());
        $entityManager->persist($product);
        $entityManager->flush();

        for ($i=0; $i<3; $i++) {
            $tarif = new ProduitTarif;
            $tarif->setProduit($product);
            $tarif->setTarif($entityManager->getRepository(TypeTarif::class)->find($i+1));
            $tarif->setTarifTtc(floatval($tarifs[$i]));
            $tarif->setTarifHt(floatval($tarifs[$i]));
            $tarif->setVisib($visible);
            $tarif->setTaux(0);
            $entityManager->persist($tarif);
          

        }
       
        $entityManager->flush();

        $lstProduit = $this->getDoctrine()->getRepository(Produit::class)->findBy(["FamilleSousC"=>$sousfamille]);


        
        
       
        $tbodyProduit = $this->render('inc/tbodyProduit.html.twig',[
            'lstProduit' => $lstProduit,
          ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbodyProduit));
        
        return $response;
    }


      // ================ Route popup modifier produit =================
    // ===============================================================

    /**
     * @Route("/rempmodalmodifPP/{id}", name="rempmodalmodifPP")
     */
    public function rempmodalmodifPP($id): Response
    {
        $lstF = $this->getDoctrine()->getRepository(Produit::class)->findBy(["IdProduit"=>$id]);
        $html = $this->render('inc/modalmodpro.html.twig', [
            'list' => $lstF,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($html));
        return $response;
    }

    
       // ================ Route popup supprimer sous famille =================
    // ===============================================================

    /**
     * @Route("/rempmodalsupprimerPP/{id}", name="rempmodalsupprimerPP")
     */
    public function rempmodalsupprimerPP($id): Response
    {
        $lstF = $this->getDoctrine()->getRepository(Produit::class)->findBy(["IdProduit"=>$id]);  
        $html = $this->render('inc/modalsupppro.html.twig', [
            'list' => $lstF,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($html));
        return $response;
    }


     // ================ Route modifier produit =================
    // ===============================================================

    /**
     * @Route("/modpro/{product}", name="modpro")
     */
    public function modpro(Request $request, Produit $product): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $idsf = $request->get('idsf');
        $npro = $request->get('npro');
        $idsousf = $product->getFamilleSousC();

        $product->setProduit($npro);
        $entityManager->flush();
       
        $lstProduit = $this->getDoctrine()->getRepository(Produit::class)->findBy(["FamilleSousC"=>$idsousf]);

        $tbodyProduit = $this->render('inc/tbodyProduit.html.twig',[
            'lstProduit' => $lstProduit,
          ])->getContent();
          
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbodyProduit));
        return $response;
    }    
     // ================ Route modifier Famille =================
    // ===============================================================

    /**
     * @Route("/modfam", name="modfam")
     */
    public function modfam(Request $request): Response
    {
        $em2 = $this->getDoctrine()->getManager()->getConnection();
        $entityManager = $this->getDoctrine()->getManager();
        $idfamille = $request->get('idfamille');
        $familles = $request->get('famille');
        $tfamille = $request->get('tfamille');
        $farabe = $request->get('farabe');
        // $idsousf = $product->getFamilleSousC();

        // $famille->setFamilleC($famille);
        // $entityManager->flush();
       
        // $lstProduit = $this->getDoctrine()->getRepository(FamilleCarte::class)->findBy(["IdFamilleC"=>$idfamille]);
        // dd($lstProduit);
        $updatefamille ="UPDATE `famille_carte` SET `famille_c`='$familles',
        `farabe_c`='$farabe',`type_famille_id`=$tfamille  where id_famille_c='$idfamille'";
         $statementatt = $em2->prepare($updatefamille);
         $resultatt = $statementatt->executeQuery();

        $famille ="SELECT * FROM `famille_carte` INNER JOIN type_famille ON type_famille.id=famille_carte.type_famille_id";
         $statement = $em2->prepare($famille);
         $resultat = $statement->executeQuery();
         $lstFamille = $resultat->fetchAll();

        $tbodyProduit = $this->render('inc/tbodyFamille.html.twig',[
            'lstFamille' => $lstFamille,
          ])->getContent();
          
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbodyProduit));
        return $response;
    }    

    // ================ Route modifier Sous Famille =================
    // ===============================================================

    /**
     * @Route("/modsfam", name="modsfam")
     */
    public function modsfam(Request $request): Response
    {
        $em2 = $this->getDoctrine()->getManager()->getConnection();
        $entityManager = $this->getDoctrine()->getManager();
        $Sidfamille = $request->get('Sidfamille');
        $sousfamille = $request->get('sousfamille');
        $snarabe = $request->get('snarabe');
        $Famille = $request->get('Famille');
        $updatefamille ="UPDATE `famille_sous_c` SET `famille_sous_c`='$sousfamille',`sarabe_c`='$snarabe' WHERE idfamille_sous_c='$Sidfamille'";
         $statementatt = $em2->prepare($updatefamille);
         $resultatt = $statementatt->executeQuery();

         $lstProduit = $this->getDoctrine()->getRepository(FamilleSousC::class)->findBy(["FamilleC"=>$Famille]);
         $tbodySousFamille = $this->render('inc/tbodySousFamille.html.twig',[
           'lstSousF' => $lstProduit
         ])->getContent();
         $response = new Response();
         $response->headers->set('Content-Type', 'application/json');
         $response->setContent(json_encode($tbodySousFamille));
         return $response;
        
    }    

      // ================ Route supprimer produit =================
    // ===============================================================

    /**
     * @Route("/Supppro/{product}", name="Supppro")
     */
    public function Supppro(Request $request, Produit $product): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $producte = $entityManager->getRepository(Produit::class)->find($product);
        $produittarif = $entityManager->getRepository(ProduitTarif::class)->findBy(["Produit"=>$product]);
        $cartelg = $entityManager->getRepository(ProduitTarif::class)->findBy(["Produit"=>$product]);
        // dd($produittarif);
        for ($i=0; $i<3; $i++) {
            $entityManager->remove($produittarif[$i]);

        }
        $idsf = $request->get('idsf');
        $entityManager->remove($producte);
        $entityManager->flush();

        $lstProduit = $this->getDoctrine()->getRepository(Produit::class)->findBy(["FamilleSousC"=>$idsf]);

        $tbodyProduit = $this->render('inc/tbodyProduit.html.twig',[
            'lstProduit' => $lstProduit,
          ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbodyProduit));
        return $response;
    }   
    
       // ================ Route popup modifier sous famille =================
    // ===============================================================

    /**
     * @Route("/rempmodalmodifSF/{id}", name="rempmodalmodifSF")
     */
    public function rempmodalmodifSF($id): Response
    {

        $lstF = $this->getDoctrine()->getRepository(FamilleSousC::class)->findBy(["IDFamilleSousC"=>$id]);

      
        $html = $this->render('inc/popupmodifSF.html.twig', [
            'list' => $lstF,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($html));
        return $response;
    }

    
    // ================ Route ajouter Sous famille =================
    // ===============================================================

    /**
     * @Route("/addSousFamille", name="addSousFamille")
     */
    public function addSousFamille(Request $request): Response
    {   
        $entityManager = $this->getDoctrine()->getManager();

        // dd($request);
        // $idsousfamille = $request->get('idsousfamille');
        $sousfamill = $request->get('sousfamille');
        $famille = $request->get('idfamille');
        $farabe = $request->get('farab');
        
        $sousfamille = new FamilleSousC;
        $sousfamille->setFamilleSousC($sousfamill);
        $sousfamille->setSArabeC($farabe);
        $sousfamille->setIDFamilleSousC('SFC');
        $sousfamille->setFamilleC($entityManager->getRepository(FamilleCarte::class)->find($famille));

        $entityManager->persist($sousfamille);
        $entityManager->flush();

        $sousfamille->setIDFamilleSousC('SFC'.$sousfamille->getId());
        $entityManager->persist($sousfamille);
        $entityManager->flush();

        $lstSousFamille = $this->getDoctrine()->getRepository(FamilleSousC::class)->findBy(["IDFamilleSousC"=>$sousfamill]);
      

        $tbodySousFamille = $this->render('inc/tbodySousFamille.html.twig',[
          'lstSousF' => $lstSousFamille
        ])->getContent();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbodySousFamille));
        return $response;
    }

   // ================ Route ajouter famille =================
    // ===============================================================

    /**
     * @Route("/addfamille", name="addfamille")
     */
    public function addfamille(Request $request): Response
    {   
        $em2 = $this->getDoctrine()->getManager()->getConnection();
        $entityManager = $this->getDoctrine()->getManager();
        $famille = $request->get('famille');
        $typefamille = $request->get('typefamille');
        $famillearabe = $request->get('famillearabe');
        
        $familles = new FamilleCarte;
        $familles->setIdFamilleC('FAC');
        $familles->setFamilleC($famille);
        $familles->setFArabeC($famillearabe);
        $familles->setTypeFamille($entityManager->getRepository(TypeFamille::class)->find($typefamille));
        $entityManager->persist($familles);
        $entityManager->flush();

        $familles->setIdFamilleC('SFC'.$familles->getId());
        $entityManager->persist($familles);
        $entityManager->flush();

        $famille ="SELECT * FROM `famille_carte` INNER JOIN type_famille ON type_famille.id=famille_carte.type_famille_id";
         $statement = $em2->prepare($famille);
         $resultat = $statement->executeQuery();
         $lstFamille = $resultat->fetchAll();

        $tbodyProduit = $this->render('inc/tbodyFamille.html.twig',[
            'lstFamille' => $lstFamille,
          ])->getContent();
          
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbodyProduit));
        return $response;
    }
    


      
    // ================ Route remplissage table Produit par sous famille produit =================
    // ================================================================== M


    /**
     * @Route("/remplirtablePP/{id}", name="remplirtablePP")
     */
    public function remplirtablePP($id,Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $carte = $em->getRepository(Carte::class)->find($request->get('id'));
        $produit = $em->getRepository(Produit::class)->findBy(['FamilleSousC'=> $id]);
        $tbodyProduit = $this->render('inc/espaceproduit.html.twig',[
          'lstProduit' => $produit
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbodyProduit));
        return $response;
      
    }



}
