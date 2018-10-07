<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\User;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\Facture;
use AppBundle\Entity\Customer;
use AppBundle\Entity\ListeAttente;
use AppBundle\Repository\ListeAttenteRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;



class SendEmailAdminController extends Controller
{

  /**
  * Lists all customer entities.
  *
  * @Route("/sendemail", name="send_email")
  * @Method("POST")
  */
  public function listeAttenteAction(Request $request, \Swift_Mailer $mailer)
  {

    $mailBody = $_POST['mailBody'];
    $email = $_POST['mail'];


    $message = (new \Swift_Message('Place Libre'))
    ->setFrom('send@example.com')
    ->setTo($email)
    ->setBody(
        $this->renderView(
          'email/sendEmailAdmin.html.twig',
          array(
          'mailBody' => $mailBody,
        )
      ),'text/html'
    );

    $mailer->send($message);

    return $this->redirectToRoute('admin_listeattente');

  }

  /**
  * Lists all customer entities.
  *
  * @Route("/sendemail2", name="send_email2")
  * @Method("POST")
  */
  public function sendEmailGlobalAction(Request $request, \Swift_Mailer $mailer)
  {

    $mailBody = $_POST['mailBody'];
    $em = $this->getDoctrine()->getManager();
    $tickets = $em->getRepository('AppBundle:Ticket')->findAll();

    foreach($tickets as $ticket){
      $message = (new \Swift_Message('Place Libre Test'))
      ->setFrom('send@example.com')
      ->setTo($ticket->getMailParticipant())
      ->setBody(
          $this->renderView(
            'email/sendEmailAdmin.html.twig',
            array(
            'mailBody' => $mailBody,
          )
        ),'text/html'
      );

      $mailer->send($message);

    }

    return $this->redirectToRoute('admin_page');

  }

  /**
  * Lists all customer entities.
  *
  * @Route("/sendemail3", name="send_email3")
  * @Method("POST")
  */
  public function sendEmailGlobalAttenteAction(Request $request, \Swift_Mailer $mailer)
  {

    $em = $this->getDoctrine()->getManager();
    $listes = $em->getRepository('AppBundle:ListeAttente')->findAll();

    $mailBody = $_POST['mailBody'];


    foreach($listes as $personne){
      $message = (new \Swift_Message('Place Libre Test'))
      ->setFrom('send@example.com')
      ->setTo($personne->getEmail())
      ->setBody(
          $this->renderView(
            'email/sendEmailAdmin.html.twig',
            array(
            'mailBody' => $mailBody,
          )
        ),'text/html'
      );

      $mailer->send($message);

    }

    return $this->redirectToRoute('admin_page');

  }
}
