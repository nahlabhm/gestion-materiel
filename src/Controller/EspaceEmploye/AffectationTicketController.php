<?php

namespace App\Controller\EspaceEmploye;

use App\Entity\Admin;
use App\Entity\AffectationTicket;
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
 * @Route("/espace-employe/affecation-ticket")
 */
class AffectationTicketController extends AbstractController
{
    /**
     * @Route("/", name="espace_employe_affectation_ticket_liste")
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
     * @Route("/voir/{id}", name="espace_employe_affectation_ticket_voir")
     */
    public function voir(AffectationTicket $affectationTicket)
    {
        $employe = $this->getUser()->getEmploye();
        $em = $this->getDoctrine()->getManager();

        $tickets = $em->getRepository(Ticket::class)->findBy(array('employe' => $employe), array('id' => 'desc'));

        return $this->render('espace_employe/ticket/liste.html.twig', array(
            'tickets' => $tickets
        ));
    }



}

