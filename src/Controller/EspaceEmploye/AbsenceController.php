<?php

namespace App\Controller\EspaceEmploye;


use App\Entity\Absence;

use App\Form\AbsenceType;
use App\Form\PersonnelType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AbsenceController
 * @package App\Controller\EspaceEmploye
 * @Route("/espace-employe/absence")
 */
class AbsenceController extends AbstractController
{
    /**
     * @Route("/", name="espace_employe_absence_liste")
     */
    public function liste()
    {

        $em = $this->getDoctrine()->getManager();

        $absences = $em->getRepository(Absence::class)->findAll();

        return $this->render('espace_employe/absence/liste.html.twig', array(
            'absences' => $absences
        ));
    }

    /**
     * @Route("/ajouter", name="espace_employe_absence_ajouter")
     */
    public function ajout(Request $request)
    {
        $absence = new Absence();
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
                $em->persist($absence);
                $em->flush();
                return $this->redirectToRoute('espace_employe_absence_liste');
            }
        return $this->render('espace_employe/absence/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/modifier/{id}", name="espace_employe_absence_modifier")
     */
    public function modifier(Request $request, Absence $absence)
    {
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('espace_employe_absence_liste');
        }
        return $this->render('espace_employe/absence/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="espace_employe_absence_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $absence = $em->getRepository(Absence::class)->find($id);
        if ($absence) {
            $em->remove($absence);
            $em->flush();
        }
        return $this->redirectToRoute('espace_employe_absence_liste');
    }


}

