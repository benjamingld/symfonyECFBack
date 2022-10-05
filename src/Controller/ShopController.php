<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ShopController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $produits = $doctrine->getManager()->getRepository(Produit::class)->listingProduit();
        return $this->render('shop/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/produit/{id}/{slug}', name: 'produit')]
    public function produit(Produit $produit, Request $request): Response
    {
        if($request->request->get('ajout')){
            dump($request->request->get('quantité'));
            dump($request->request->get('produit'));
        }

        return $this->render('shop/produit.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/panier', name: 'panier')]
    public function panier(): Response
    {
        return $this->render('shop/panier.html.twig',[]);
    }

    #[Route('/ajout', name: 'ajout')]
    public function ajout(Produit $produit, SessionInterface $session){

        $panier = $session->get('panier', []);
        $id = $produit->getId();
 
        if(!empty ($cart[$id])) {
            $cart[$id]++;
        }else {
            $cart[$id] = 1;
        }
 
       $session->set('panier', $panier);

    }


    public function menu()
    {
        $listMenu = [
            ['title' => "Accueil", "text" => 'Accueil', "url" => $this->generateUrl('home')],
            ['title' => "Panier", "text" => 'Panier', "url" => $this->generateUrl('panier')],

        ];

        return $this->render("parts/menu.html.twig", ["listMenu" => $listMenu]);
    }
}
