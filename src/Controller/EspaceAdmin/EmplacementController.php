<?php

namespace App\Controller\EspaceAdmin;

use App\Entity\Emplacement;
use App\Form\EmplacementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class EmplacementController extends AbstractController
{
    /**
     * @Route("/emplacements", name="liste_emplacements")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager(); // appel doctrine

        $listeEmplacements = $em->getRepository(Emplacement::class)->findAll();

        return $this->render('emplacement/index.html.twig', array(
            'emplacements' => $listeEmplacements
        ));
    }

    /**
     * @Route("/emplacements/details/{id}", name="emplacement_details")
     */
    public function voir(Emplacement $emplacement)
    {

        return $this->render('emplacement/voir.html.twig', array(
            'emplacement' => $emplacement
        ));
    }

    /**
     * @Route("/emplacements/ajouter", name="emplacement_ajouter")
     */
    public function ajout(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $emplacement = new Emplacement();
        $form = $this->createForm(EmplacementType::class, $emplacement); // creer formulaire
        $form->handleRequest($request); // récuperer les données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $emplacement->getUtilisateur();
            $utilisateur->setPassword(
                $passwordEncoder->encodePassword($utilisateur, $form->get('utilisateur')->get('plainPassword')->getData())
            );
            $utilisateur->setRoles(array($form->get('role')->getData()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($emplacement); // informer doctrine qu'il doit ajouter un emplacement dans la base
            $em->flush(); // executer tous requetes

            return $this->redirectToRoute('liste_emplacements');
        }

        return $this->render('emplacement/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/emplacements/modifier/{id}", name="emplacement_modifier")
     */
    public function modifier(Request $request, Emplacement $emplacement)
    {
        $form = $this->createForm(EmplacementType::class, $emplacement); // creer formulaire
        $form->handleRequest($request); // récuperer les données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush(); // executer tous requetes
            return $this->redirectToRoute('liste_emplacements');
        }
        return $this->render('emplacement/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/emplacements/supprimer/{id}", name="emplacement_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $emplacement = $em->getRepository(Emplacement::class)->find($id);

        if ($emplacement) {
            $em->remove($emplacement);
            $em->flush();
        }

        return $this->redirectToRoute('liste_emplacements');
    }
}

