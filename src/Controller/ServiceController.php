<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ServiceController extends AbstractController
{
    /**
     * @Route("/services", name="liste_services")
     */
    public function index()

    {
        $em = $this->getDoctrine()->getManager(); // appel doctrine

        $listeServices = $em->getRepository(Service::class)->findAll();

        return $this->render('service/index.html.twig', array(
            'services' => $listeServices
        ));
    }

    /**
     * @Route("/services/details/{id}", name="service_details")
     */
    public function voir(Service $service)
    {

        return $this->render('service/voir.html.twig', array(
            'service' => $service
        ));
    }

    /**
     * @Route("/services/ajouter", name="service_ajouter")
     */
    public function ajout(Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service); // creer formulaire
        $form->handleRequest($request); // récuperer les données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $service->getUtilisateur();
            $utilisateur->setPassword(
                $passwordEncoder->encodePassword($utilisateur, $form->get('utilisateur')->get('plainPassword')->getData())
            );
            $utilisateur->setRoles(array($form->get('role')->getData()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($service); // informer doctrine qu'il doit ajouter un service dans la base
            $em->flush(); // executer tous requetes
            return $this->redirectToRoute('liste_services');
        }
        return $this->render('service/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/services/modifier/{id}", name="service_modifier")
     */
    public function modifier(Request $request, Service $service)
    {
        $form = $this->createForm(ServiceType::class, $service); // creer formulaire
        $form->handleRequest($request); // récuperer les données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush(); // executer tous requetes
            return $this->redirectToRoute('liste_services');
        }
        return $this->render('service/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/services/supprimer/{id}", name="service_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $service = $em->getRepository(Service::class)->find($id);

        if ($service) {
            $em->remove($service);
            $em->flush();
        }

        return $this->redirectToRoute('liste_services');
    }

}

