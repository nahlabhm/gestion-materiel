<?php

namespace App\Controller\EspaceEmploye;

use App\Entity\Materiel;
use App\Entity\Personnel;
use App\Form\PersonnelType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PersonnelController
 * @package App\Controller\EspaceEmploye
 * @Route("/espace-employe/personnel")
 */
class PersonnelController extends AbstractController
{
    /**
     * @Route("/", name="espace_employe_personnel_liste")
     */
    public function liste()
    {

        $em = $this->getDoctrine()->getManager();

        $personnels = $em->getRepository(Personnel::class)->findAll();

        return $this->render('espace_employe/personnel/liste.html.twig', array(
            'personnels' => $personnels
        ));
    }

    /**
     * @Route("/ajouter", name="espace_employe_personnel_ajouter")
     */
    public function ajout(Request $request)
    {
        $personnel = new Personnel();
        $form = $this->createForm(PersonnelType::class, $personnel);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

                $em->persist($personnel);
                $em->flush();
                return $this->redirectToRoute('espace_employe_personnel_liste');
            }
        return $this->render('espace_employe/personnel/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/modifier/{id}", name="espace_employe_personnel_modifier")
     */
    public function modifier(Request $request, Personnel $personnel)
    {
        $form = $this->createForm(PersonnelType::class, $personnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('espace_employe_personnel_liste');
        }
        return $this->render('espace_employe/personnel/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="espace_employe_personnel_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $personnel = $em->getRepository(Personnel::class)->find($id);

        if ($personnel) {
            $em->remove($personnel);
            $em->flush();
        }

        return $this->redirectToRoute('espace_employe_personnel_liste');
    }


}

