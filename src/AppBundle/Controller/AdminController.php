<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Common\Collections;
use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\TicketRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Doctrine\Common\Collections\ArrayCollection;

class AdminController extends Controller
{

  /**
  * @Route("/admin/utilisateurs", name="admin_utilisateurs")
  */
  public function utilisateursAction()
  {


    $em = $this->getDoctrine()->getManager();
    $customers = $em->getRepository('AppBundle:Customer')->findAll();

    return $this->render('admin/adminUtilisateurs.html.twig', array(
      'customers' => $customers,

    ));
  }

  /**
  * @Route("/admin/paiement", name="admin_paiement")
  */
  public function paiementAction(Request $request, \Swift_Mailer $mailer)
  {
    $user = $this->getUser();
    $em = $this->getDoctrine()->getManager();
    $customers = $em->getRepository('AppBundle:Customer')->findAll();
    $factures  =  $em->getRepository('AppBundle:Facture')->findAll();


    date_default_timezone_set('Europe/Paris');
    $date = date('d-m-Y');

    if ($request->request->has('voirfacture')) {

      $id = $_POST['factureid'];
      $facture = $em->getRepository('AppBundle:Facture')->findOneById($id);
      $tickets = $em->getRepository('AppBundle:Ticket')->findByFacture($facture);

      $pdf = $this->get('knp_snappy.pdf');
      $pdf->setOption('footer-html', 'http://colloque.euralens.org/files/footer.html');
      $pdf->setOption('header-html', 'http://colloque.euralens.org/files/footer.html');
      $pdf->setOption('header-spacing', 12);

      $html = $this->renderView('factures/facture.html.twig', array(
        'date' => $date,
        'customers' => $customers,
        'facture' => $facture,
        'tickets' => $tickets,
      ));

      return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );
    }

    if ($request->request->has('validerfacture')) {

      $id = $_POST['factureid'];
      $facture = $em->getRepository('AppBundle:Facture')->findOneById($id);
      $tickets = $em->getRepository('AppBundle:Ticket')->findByFacture($facture);
      $mail = $facture->getCustomer()->getUser()->getEmail();


      $facture->setStatus(2);
      $em->persist($facture);
      $em->flush();

      $request->getSession()
      ->getFlashBag()
      ->add('validationfacture', 'La facture n° '.$facture->getNumber().' est validée');


      $message = (new \Swift_Message('Validation Paiement'))
      ->setFrom('send@example.com')
      ->setTo($mail)
      ->attach(\Swift_Attachment::fromPath('files/Facture-'.$facture->getNumber().'.pdf'))
      ->attach(\Swift_Attachment::fromPath('files/LivretA5.pdf'))
      ->setBody(
          $this->renderView(
            'email/validationpaiement.html.twig',
            array('facture' => $facture,
          )
        ),'text/html'
      );


      foreach($tickets as $ticket){
       $message->attach(\Swift_Attachment::fromPath('files/Ticket-'.$ticket->getTicketNumber().'.pdf'));
      }

      $messageAdmin = (new \Swift_Message('Validation Paiement'))
      ->setFrom('send@example.com')
      ->setTo('euralenscolloque@gmail.com')
      ->setBody(
          $this->renderView(
            'email/validationpaiementadmin.html.twig',
            array('facture' => $facture,
          )
        ),'text/html'
      );


      $mailer->send($message);
      $mailer->send($messageAdmin);

      return $this->render('admin/adminPaiement.html.twig', array(
        'customers' => $customers,
        'factures' => $factures,
      ));
    }


    return $this->render('admin/adminPaiement.html.twig', array(
      'customers' => $customers,
      'factures' => $factures,

    ));

  }

  /**
  * @Route("/admin/colloque", name="admin_colloque")
  * @Method("GET")
  */
  public function colloqueAction(Request $request)
  {

    $optionName = $request->query->get('optionName', null);
    $optionValue = $request->query->get('optionValue', null);

    $em = $this->getDoctrine()->getManager();

    if ($optionName && $optionValue){
      $prixTotal = null;
      $tickets = $em->getRepository('AppBundle:Ticket')->findPaidTicketsByOption($optionName,$optionValue);
      $personNumber = $em->getRepository('AppBundle:Ticket')->computeCountPersonNumberByOption($optionName, $optionValue);
    } else {

      $tickets   =  $em->getRepository('AppBundle:Ticket')->findTicketsByStatus2();
      $prixTotal   =  $em->getRepository('AppBundle:Ticket')->computeSumStatus2();
      $personNumber = $em->getRepository('AppBundle:Ticket')->computeCountPersonNumber();

    }

    return $this->render('admin/adminColloque.html.twig', array(
      'tickets' => $tickets,
      'prixTotal' => $prixTotal,
      'personNumber' => $personNumber,
      'optionName' => $optionName,
      'optionValue' => $optionValue,

    ));
  }

  /**
  * @Route("/admin/annulation", name="admin_annulation")
  */
  public function annulationAction()
  {

    $em = $this->getDoctrine()->getManager();
    $tickets = $em->getRepository('AppBundle:Ticket')->findByStatus(1);

    return $this->render('admin/adminAnnulation.html.twig', array(
      'tickets' => $tickets,

    ));
  }

  /**
  * @Route("/admin/liste", name="admin_listeattente")
  */
  public function adminListeAttenteAction()
  {


    $em = $this->getDoctrine()->getManager();
    $listes = $em->getRepository('AppBundle:ListeAttente')->findAll();

    return $this->render('admin/adminListeAttente.html.twig', array(
      'listes' => $listes,

    ));
  }

}
