<?php

namespace App\Controller\EspaceEmploye;

use App\Entity\Admin;
use App\Entity\Materiel;
use App\Entity\Notification;
use App\Entity\Ticket;
use App\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TicketController
 * @package App\Controller\EspaceEmploye
 * @Route("/espace-employe/ticket")
 */
class TicketController extends AbstractController
{
    /**
     * @Route("/", name="espace_employe_ticket_liste")
     */
    public function index()
    {
        $employe = $this->getUser()->getEmploye();
        $em = $this->getDoctrine()->getManager();

        $tickets = $em->getRepository(Ticket::class)->findBy(array('employe' => $employe), array('id' => 'desc'));

        return $this->render('espace_employe/ticket/liste.html.twig', array(
            'tickets' => $tickets
        ));
    }

    /**
     * @Route("/ajouter", name="espace_employe_ticket_ajouter")
     */
    public function ajout(Request $request)
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();

            $matricule = $form->get('matricule')->getData();
            if ($matricule != '') {
                $materiel = $em->getRepository(Materiel::class)->findOneBy(array('num_id' => $matricule));
                if (!$materiel) {
                    $form->get('matricule')->addError(new FormError('Matricule n\'existe pas'));
                }
                else{
                    $ticket->setMateriel($materiel);
                }
            }

            if ($form->isValid()) {
                $ticket->setEmploye($this->getUser()->getEmploye());
                $em->persist($ticket);
                $em->flush();

                $administrateurs = $em->getRepository(Admin::class)->findAll();
                foreach ($administrateurs as $admin){
                    $notification = new Notification();
                    $notification->setMessage('Un nouveau ticket');
                    $notification->setUtilisateur($admin->getUtilisateur());
                    $notification->setUrl($this->generateUrl('espace_admin_ticket_voir', array('id'=> $ticket->getId())));
                    $em->persist($notification);
                    $em->flush();
                }

                return $this->redirectToRoute('espace_employe_ticket_liste');
            }
        }

        return $this->render('espace_employe/ticket/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/modifier/{id}", name="emplacement_modifier")
     */
    public function modifier(Request $request, Ticket $ticket)
    {
        $form = $this->createForm(TicketType::class, $ticket); // creer formulaire
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

}

