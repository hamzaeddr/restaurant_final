<?php

namespace App\Controller;

use App\Entity\FamilleCarte;
use App\Entity\FamilleSousC;
use App\Entity\TypeFamille;
use App\Entity\TypeProduit; 
use App\Entity\TypeTarif;
use App\Entity\Produit;
use App\Entity\ProduitTarif;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use PDO;
use App\Entity\Borne;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
     
        $famillecarte = $this->getDoctrine()->getRepository(FamilleCarte::class)->findAll();
        $famillesousc = $this->getDoctrine()->getRepository(FamilleSousC::class)->findAll();
        $typeproduit = $this->getDoctrine()->getRepository(TypeProduit::class)->findAll();
        $typetarif = $this->getDoctrine()->getRepository(TypeTarif::class)->findAll();
        $typefamille = $this->getDoctrine()->getRepository(TypeFamille::class)->findAll();
       

      
        
        return $this->render('product/index.html.twig', [
            'famillecarte' => $famillecarte,
            'famillesousc' => $famillesousc,
          'typeproduit' => $typeproduit,
          'typetarif' => $typetarif,
          'typefamille' => $typefamille,
        ]) ;
    }

     // ================ Route remplissage navbar sous famille =================
    // ======================================================================


    /**
     * @Route("/remplirNavSousFamille/{id}", name="remplirNavSousFamille")
     */
    public function remplirNavSousFamille($id)
    {   
         $lstSousFamille = $this->getDoctrine()->getRepository(FamilleSousC::class)->findBy(["FamilleC"=>$id]);
        
        $NavSousFamille = $this->render('inc/NavSousFamille.html.twig',[
          'lstSousFamille' => $lstSousFamille
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($NavSousFamille));
        return $response;
      
    }



     /**
     * @Route("/remplirtablePP/{id}", name="remplirtablePP")
     */
    public function remplirtablePP($id)
    {   

        $con = $this->getDoctrine()->getConnection();
        $req="select * 
        from pproduits pp 
        inner join pproduits_tarif ppt on pp.ID_Produit = ppt.ID_Produit 
        where ID_FamilleSousC  ='".$id."' and ID_Tarif='1'";
        $stm=$con->prepare($req);
        $stm->execute();
        $lstProduit= $stm->fetchAll();
        // dd($lstProduit);
        $tbodyProduit = $this->render('inc/espaceproduit.html.twig',[
          'lstProduit' => $lstProduit
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbodyProduit));
        return $response;
      
    }

     // ================ Route remplissage table Produit ============x=====
    // ==================================================================


    /**
     * @Route("/remplirtableProduit/{id}", name="remplirtableProduit")
     */
    public function remplirtableProduit($id)
    {   
       
        $lstProduit = $this->getDoctrine()->getRepository(Produit::class)->findBy(["FamilleSousC"=>$id]);
       
       
        $lstSF = $this->getDoctrine()->getRepository(FamilleSousC::class)->findAll();
        
        $lstType = $this->getDoctrine()->getRepository(TypeProduit::class)->findAll();
       
        $tbodyProduit = $this->render('inc/tbodyProduit.html.twig',[
          'lstProduit' => $lstProduit,
          'lstsf' => $lstSF,
          'lsttype' => $lstType,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbodyProduit));
        return $response;
      
    }

     // ================ Route remplissage table Sous Famille =================
    // =======================================================================

    /**
     * @Route("/remplirtableSousFamille/{id}", name="remplirtableSousFamille")
     */
    public function remplirtableSousFamille($id)
    {   
        $lstProduit = $this->getDoctrine()->getRepository(FamilleSousC::class)->findBy(["FamilleC"=>$id]);
        $tbodySousFamille = $this->render('inc/tbodySousFamille.html.twig',[
          'lstSousF' => $lstProduit
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($tbodySousFamille));
        return $response;
      
    }

     // ================ Route popup supprimer sous famille =================
    // ===============================================================

    /**
     * @Route("/rempmodalsupprimerPP/{id}", name="rempmodalsupprimerPP")
     */
    public function rempmodalsupprimerPP($id): Response
    {
        $con = $this->getDoctrine()->getConnection();
        $req="select pp.ID_FamilleSousC,pp.ID_Produit,pp.Produit,ptf.Type_Famille,FamilleSousC from pproduits pp
         inner join pfamillessous_carte pfc on pp.id_famillesousc=pfc.id_famillesousc
         inner join pfamilles_carte pf on pfc.ID_FamilleC=pf.ID_FamilleC 
         inner join ptype_famille ptf on pf.Type_Famille=ptf.ID_Type_Famille
          where pp.id_produit  ='".$id."' limit 1";
        // dd($req);
        $stm=$con->prepare($req);
        $stm->execute();
        $lstF= $stm->fetch();
        // dd($lstF);
        $html = $this->render('inc/modalsupppro.html.twig', [
            'list' => $lstF,
        ])->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($html));
        return $response;
    }

    // ================ Route popup modifier famille =================
    // ===============================================================

    /**
     * @Route("/modifmodalfamille/{id}", name="modifmodalfamille")
     */
    public function modifmodalfamille($id): Response
    {

        $lstF = $this->getDoctrine()->getRepository(FamilleCarte::class)->findBy(["IdFamilleC"=>$id]);
        $lstTypeF = $this->getDoctrine()->getRepository(TypeFamille::class)->findAll();
        
    
        $html = $this->render('inc/modifmodalF.html.twig', [
            'list' => $lstF,
            'lsttypef' => $lstTypeF,
            
        ])->getContent();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($html));
        return $response;

    }


    
   


}

