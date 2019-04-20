<?php

namespace App\Controller\EspaceAdmin;

use App\Entity\AffectationTicket;
use App\Entity\Materiel;
use App\Entity\Ticket;
use App\Form\AffectationtType;
use App\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TicketController
 * @package App\Controller\Administration
 * @Route("/administration/tickets")
 */
class TicketController extends AbstractController
{
    /**
     * @Route("/", name="espace_admin_ticket_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $tickets = $em->getRepository(Ticket::class)->findBy(array(), array('id' => 'desc'));

        return $this->render('espace_admin/ticket/liste.html.twig', array(
            'tickets' => $tickets
        ));
    }


    /**
     * @Route("/ticket/details/{id}", name="espace_admin_ticket_voir")
     */
    public function voir(Ticket $ticket)
    {

        return $this->render('espace_admin/ticket/voir.html.twig', array(
            'emplacement' => $ticket
        ));
    }

    /**
     * @Route("/ticket/affecter/{id}", name="espace_admin_ticket_affecter")
     */
    public function affecter(Request $request, Ticket $ticket)
    {
        $affectation = new AffectationTicket();
        $form = $this->createForm(AffectationtType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $affectation->setTicket($ticket);
            $em->persist($affectation);
            $em->flush();
            return $this->redirectToRoute('espace_admin_ticket_liste');

        }

        return $this->render('espace_admin/ticket/affecter.html.twig', array(
            'form' => $form->createView()
        ));
    }


}

