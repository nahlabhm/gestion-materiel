<?php

namespace App\Controller\EspaceAdmin;

use App\Entity\Admin;
use App\Form\AdminType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdminController
 * @package App\Controller\EspaceAdmin
 * 
 * @Route("/administration/administrateurs")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="espace_admin_liste_admins")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager(); // appel doctrine

        $listeAdmins = $em->getRepository(Admin::class)->findAll();

        return $this->render('espace_admin/administrateurs/index.html.twig', array(
            'admins' => $listeAdmins
        ));
    }

    /**
     * @Route("/details/{id}", name="espace_admin_admin_details")
     */
    public function voir(Admin $admin)
    {
        return $this->render('espace_admin/administrateurs/voir.html.twig', array(
            'admin' => $admin
        ));
    }

    /**
     * @Route("/ajouter", name="espace_admin_admin_ajouter")
     */
    public function ajout(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin); // creer formulaire
        $form->handleRequest($request); // récuperer les données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $admin->getUtilisateur();
            $utilisateur->setPassword(
                $passwordEncoder->encodePassword($utilisateur, $form->get('utilisateur')->get('plainPassword')->getData())
            );
            $utilisateur->setRoles(array('ROLE_ADMIN'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($admin); // informer doctrine qu'il doit ajouter un admin dans la base
            $em->flush(); // executer tous requetes

            return $this->redirectToRoute('espace_admin_liste_admins');
        }

        return $this->render('espace_admin/administrateurs/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/modifier/{id}", name="espace_admin_admin_modifier")
     */
    public function modifier(Request $request, Admin $admin)
    {
        $form = $this->createForm(AdminType::class, $admin); // creer formulaire
        $form->handleRequest($request); // récuperer les données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush(); // executer tous requetes
            return $this->redirectToRoute('espace_admin_liste_admins');
        }
        return $this->render('espace_admin/administrateurs/modifier.html.twig', array(
            'form' => $form->createView()
        ));

    }


    /**
     * @Route("/supprimer/{id}", name="espace_admin_admin_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $admin = $em->getRepository(Admin::class)->find($id);

        if ($admin) {
            $em->remove($admin);
            $em->flush();
        }

        return $this->redirectToRoute('espace_admin_liste_admins');
    }
}

