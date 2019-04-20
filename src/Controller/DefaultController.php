<?php

namespace App\Controller;

use App\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="page_index")
     */
    public function index()
    {
        return $this->render('default/index.html.twig');
    }


    public function header()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $notifications = $em->getRepository(Notification::class)->findBy(array('utilisateur' => $user), array('id' => 'desc'));
        $nbNotifNonVue = $em->getRepository(Notification::class)->nombreNonVue($user);

        return $this->render('includes/header.html.twig', array(
            'notifications'=> $notifications,
            'nbNotifNonVue'=> $nbNotifNonVue
        ));
    }


    /**
     * @Route("/notification/voir/{id}", name="notification_voir")
     */
    public function voirNotification(Notification $notification)
    {
        $em = $this->getDoctrine()->getManager();
        $notification->setVue(true);
        $em->flush();

        return $this->redirect($notification->getUrl());
    }

}
