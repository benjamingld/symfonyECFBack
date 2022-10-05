<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
    public function produit(Produit $produit): Response
    {
        return $this->render('shop/produit.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/panier', name: 'panier')]
    public function panier(): Response
    {
        return $this->render('shop/panier.html.twig', [
            
        ]);
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
