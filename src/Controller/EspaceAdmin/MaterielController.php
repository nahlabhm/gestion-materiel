<?php

namespace App\Controller\EspaceAdmin;

use App\Entity\Materiel;
use App\Form\MaterielType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MaterielController
 * @package App\Controller\EspaceAdmin
 * 
 * @Route("/administration/materiels")
 */
class MaterielController extends AbstractController
{
    /**
     * @Route("/", name="espace_admin_liste_materiels")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $listeMateriels = $em->getRepository(Materiel::class)->findAll();

        return $this->render('espace_admin/materiels/index.html.twig', array(
            'materiels' => $listeMateriels
        ));
    }

    /**
     * @Route("/details/{id}", name="espace_admin_materiel_details")
     */
    public function voir(Materiel $materiel)
    {
        return $this->render('espace_admin/materiels/voir.html.twig', array(
            'materiel' => $materiel
        ));
    }

    /**
     * @Route("/ajouter", name="espace_admin_materiel_ajouter")
     */
    public function ajout(Request $request)
    {
        $materiel = new Materiel();
        $form = $this->createForm(MaterielType::class, $materiel); // creer formulaire
        $form->handleRequest($request); // récuperer les données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($materiel); // informer doctrine qu'il doit ajouter un materiel dans la base
            $em->flush(); // executer tous requetes

            return $this->redirectToRoute('espace_admin_liste_materiels');
        }

        return $this->render('espace_admin/materiels/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/modifier/{id}", name="espace_admin_materiel_modifier")
     */
    public function modifier(Request $request, Materiel $materiel)
    {
        $form = $this->createForm(MaterielType::class, $materiel); // creer formulaire
        $form->handleRequest($request); // récuperer les données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush(); 
            return $this->redirectToRoute('espace_admin_liste_materiels');
        }
        return $this->render('espace_admin/materiels/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="espace_admin_materiel_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $materiel = $em->getRepository(Materiel::class)->find($id);

        if ($materiel) {
            $em->remove($materiel);
            $em->flush();
        }

        return $this->redirectToRoute('espace_admin_liste_materiels');
    }

}