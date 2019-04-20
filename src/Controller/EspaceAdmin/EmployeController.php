<?php

namespace App\Controller\EspaceAdmin;

use App\Entity\Employe;
use App\Form\EmployeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class EmployeController
 * @package App\Controller\EspaceAdmin
 * 
 * @Route("/administration/employes")
 */
class EmployeController extends AbstractController
{
    /**
     * @Route("/", name="espace_admin_liste_employes")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $listeEmployes = $em->getRepository(Employe::class)->findAll();

        return $this->render('espace_admin/employes/index.html.twig', array(
            'employes' => $listeEmployes
        ));
    }

    /**
     * @Route("/details/{id}", name="espace_admin_employe_details")
     */
    public function voir(Employe $employe)
    {

        return $this->render('espace_admin/employes/voir.html.twig', array(
            'employe' => $employe
        ));
    }

    /**
     * @Route("/ajouter", name="espace_admin_employe_ajouter")
     */
    public function ajout(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $employe = new Employe();
        $form = $this->createForm(EmployeType::class, $employe); // creer formulaire
        $form->handleRequest($request); // récuperer les données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $employe->getUtilisateur();
            $utilisateur->setPassword(
                $passwordEncoder->encodePassword($utilisateur, $form->get('utilisateur')->get('plainPassword')->getData())
            );
            $utilisateur->setRoles(array($form->get('role')->getData()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($employe); // informer doctrine qu'il doit ajouter un employe dans la base
            $em->flush(); // executer tous requetes

            return $this->redirectToRoute('espace_admin_liste_employes');
        }

        return $this->render('espace_admin/employes/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/modifier/{id}", name="espace_admin_employe_modifier")
     */
    public function modifier(Request $request, Employe $employe)
    {
        $form = $this->createForm(EmployeType::class, $employe); // creer formulaire
        $form->handleRequest($request); // récuperer les données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush(); // executer tous requetes
            return $this->redirectToRoute('espace_admin_liste_employes');
        }
        return $this->render('espace_admin/employes/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="espace_admin_employe_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $employe = $em->getRepository(Employe::class)->find($id);

        if ($employe) {
            $em->remove($employe);
            $em->flush();
        }

        return $this->redirectToRoute('espace_admin_liste_employes');
    }


    /**
     * @Route("/search/{id}", name="espace_admin_employe_search")
     */
    public function search(Employe $employe)
    {


        return $this->render('espace_admin/employes/search.html.twig', array(
            'employe' => $employe
        ));
    }

}