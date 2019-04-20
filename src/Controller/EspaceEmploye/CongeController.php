<?php

namespace App\Controller\EspaceEmploye;


use App\Entity\Conge;
use App\Form\CongeType;
use App\Form\PersonnelType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CongeController
 * @package App\Controller\EspaceEmploye
 * @Route("/espace-employe/conge")
 */
class CongeController extends AbstractController
{
    /**
     * @Route("/", name="espace_employe_conge_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();
        $conges = $em->getRepository(Conge::class)->findAll();
        return $this->render('espace_employe/conge/liste.html.twig', array(
            'conges' => $conges
        ));
    }

    /**
     * @Route("/ajouter", name="espace_employe_conge_ajouter")
     */
    public function ajout(Request $request)
    {
        $conge = new Conge();
        $form = $this->createForm(CongeType::class, $conge);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
                $em->persist($conge);
                $em->flush();
                return $this->redirectToRoute('espace_employe_conge_liste');
            }
        return $this->render('espace_employe/conge/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/modifier/{id}", name="espace_employe_conge_modifier")
     */
    public function modifier(Request $request, Conge $conge)
    {
        $form = $this->createForm(PersonnelType::class, $conge);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('espace_employe_conge_liste');
        }
        return $this->render('espace_employe/conge/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="espace_employe_conge_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $conge = $em->getRepository(Conge::class)->find($id);
        if ($conge) {
            $em->remove($conge);
            $em->flush();
        }
        return $this->redirectToRoute('espace_employe_conge_liste');
    }


}

