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
use AppBundle\Entity\Avoir;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
* Ticket controller.
*
* @Route("ticket")
*/
class TicketController extends Controller
{
  /**
  * Lists all ticket entities.
  *
  * @Route("/", name="ticket_index")
  * @Method("GET")
  */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();

    $tickets = $em->getRepository('AppBundle:Ticket')->findAll();

    return $this->render('ticket/index.html.twig', array(
      'tickets' => $tickets,
    ));
  }

  /**
  * Creates a new ticket entity.
  *
  * @Route("/new", name="ticket_new")
  * @Route("/edit/{id}", name="ticket_modif")
  * @Method({"GET", "POST"})
  */
  public function newActionAction(Request $request, Ticket $ticket = null)
  {


    $prixExpotemporaire = 9;
    $prixBase = 300;
    $prixArtdeco = 6;
    $prixDecouverte = 9;
    $prixGrandsite = 6;
    $prixGala = 0;
    $prixTotal = $prixBase;

    date_default_timezone_set('Europe/Paris');
    $date = date('d-m-Y');

    if(!$ticket){
      $ticket = new Ticket();
    }

    $fileSystem = new Filesystem();
    $fileSystem->remove(array('files/Ticket-'.$ticket->getTicketNumber().'.pdf'));

    $form = $this->createForm('AppBundle\Form\TicketType', $ticket);
    $form->handleRequest($request);

    $user = $this->getUser();
    $em = $this->getDoctrine()->getManager();

    $checkCustomer = $em->getRepository('AppBundle:Customer')->findByUser($user);
    $reservationCount = $em->getRepository('AppBundle:Ticket')->computeCountPersonNumber();
    $reservationMax = $this->container->getParameter('reservation_max');

    if (!$checkCustomer){
      $request->getSession()
      ->getFlashBag()
      ->add('espaceClient', 'Merci de remplir le formulaire afin de réserver un ticket.');

      return $this->redirectToRoute('customer_new');
    }

    if ($reservationCount > $reservationMax){
      $request->getSession()
      ->getFlashBag()
      ->add('reservationComplet', "Les réservations sont complètes, merci de vous inscrire sur la liste d'attente");

      return $this->redirectToRoute('homepage');
    }


    $customer = $em->getRepository('AppBundle:Customer')->findByUser($user)[0];// @hack
    $watchFacture = $em->getRepository('AppBundle:Facture')->findOneByCustomer($customer);

    $ticket->setCustomer($customer);

    $result = false;

    if ($form->isSubmitted() && $form->isValid()) {
      $result = true;
      $data = $form->getData();
      if($data->getoptionDecouverte() === true) {
        $prixTotal += $prixDecouverte ;
      }
      if($data->getoptionGrandSite() === true) {
        $prixTotal += $prixGrandsite ;
      }
      if($data->getoptionArtDeco() == 1 || $data->getoptionArtDeco() == 2) {
        $prixTotal += $prixArtdeco ;
      }
      if($data->getoptionExpo() == 1 || $data->getoptionExpo() == 2) {
        $prixTotal += $prixExpotemporaire ;
      }
      if($data->getday2Night() === true) {
        $prixTotal += $prixGala ;
      }

      $ticket->setPrice($prixTotal);
      $ticket->setStatus(0);


      $em = $this->getDoctrine()->getManager();
      $em->persist($ticket);
      $em->flush();

      $ticket->setTicketNumber(str_pad($ticket->getId(),6,'0',STR_PAD_LEFT));
      $em->persist($ticket);
      $em->flush();



      if ($request->request->has('add')) {

        $watchFacture = $em->getRepository('AppBundle:Facture')->findOneByCustomer($customer);

        if(!$watchFacture) {

          $facture = new Facture();
          $facture->setCustomer($customer);
          $prixtotal =  $em->getRepository('AppBundle:Ticket')->findByPrice($customer);
          $facture->setPrice($prixtotal);
          $facture->setStatus(0);
          $facture->setNumber($random);
          $ticket->setFacture($facture);
          $em = $this->getDoctrine()->getManager();
          $em->persist($facture);
          $em->flush();

          $facture->setNumber(str_pad($facture->getId(),6,'0',STR_PAD_LEFT));
          $em->persist($facture);
          $em->flush();

          $tickets = $em->getRepository('AppBundle:Ticket')->findByFacture($facture);

          $pdf = $this->get('knp_snappy.pdf');
          $pdf->setOption('footer-html', 'http://colloque.euralens.org/files/footer.html');
          $pdf->setOption('header-html', 'http://colloque.euralens.org/files/footer.html');
          $pdf->setOption('header-spacing', 12);

          $pdf->generateFromHtml(
            $this->renderView(
              'factures/facture.html.twig', array(
                'date' => $date,
                'facture' => $facture,
                'tickets' => $tickets,
              )
            ),
            'files/Facture-'.$facture->getNumber().'.pdf'
          );

        }
        else{

          $fileSystem = new Filesystem();
          $fileSystem->remove(array('files/Facture-'.$watchFacture->getNumber().'.pdf'));
          $prixTicketNull =  $em->getRepository('AppBundle:Ticket')->findByPrice($customer);
          $prixtotal =  $em->getRepository('AppBundle:Ticket')->findPriceByStatus($customer);
          $watchFacture->setPrice($prixtotal + $prixTicketNull);
          $ticket->setFacture($watchFacture);
          $em = $this->getDoctrine()->getManager();
          $em->persist($watchFacture);
          $em->flush();

          $tickets = $em->getRepository('AppBundle:Ticket')->findByFacture($watchFacture);

          $pdf = $this->get('knp_snappy.pdf');
          $pdf->setOption('footer-html', 'http://colloque.euralens.org/files/footer.html');
          $pdf->setOption('header-html', 'http://colloque.euralens.org/files/footer.html');
          $pdf->setOption('header-spacing', 12);

          $pdf->generateFromHtml(
            $this->renderView(
              'factures/facture.html.twig', array(
                'date' => $date,
                'facture' => $watchFacture,
                'tickets' => $tickets,
              )
            ),
            'files/Facture-'.$watchFacture->getNumber().'.pdf'
          );

        }

        $pdf = $this->get('knp_snappy.pdf');
        $pdf->setOption('footer-html', 'http://colloque.euralens.org/files/footer.html');
        $pdf->setOption('header-html', 'http://colloque.euralens.org/files/footer.html');
        $pdf->setOption('header-spacing', 12);

        $pdf->generateFromHtml(
          $this->renderView(
            'ticket/ticket.html.twig', array(
              'date' => $date,
              'ticket' => $ticket,
            )
          ),
          'files/Ticket-'.$ticket->getTicketNumber().'.pdf'
        );

        return $this->redirectToRoute('ticket_new');
      }

      if ($request->request->has('next')) {

        $watchFacture = $em->getRepository('AppBundle:Facture')->findOneByCustomer($customer);

        if(!$watchFacture) {

          $facture = new Facture();
          $facture->setCustomer($customer);
          $prixtotal =  $em->getRepository('AppBundle:Ticket')->findByPrice($customer);
          $facture->setPrice($prixtotal);
          $facture->setStatus(0);
          $ticket->setFacture($facture);
          $em = $this->getDoctrine()->getManager();
          $em->persist($facture);
          $em->flush();

          $facture->setNumber(str_pad($facture->getId(),6,'0',STR_PAD_LEFT));
          $em->persist($facture);
          $em->flush();

          $tickets = $em->getRepository('AppBundle:Ticket')->findByFacture($facture);

          $pdf = $this->get('knp_snappy.pdf');
          $pdf->setOption('footer-html', 'http://colloque.euralens.org/files/footer.html');
          $pdf->setOption('header-html', 'http://colloque.euralens.org/files/footer.html');
          $pdf->setOption('header-spacing', 12);

          $pdf->generateFromHtml(
            $this->renderView(
              'factures/facture.html.twig', array(
                'date' => $date,
                'facture' => $facture,
                'tickets' => $tickets,
              )
            ),
            'files/Facture-'.$facture->getNumber().'.pdf'
          );

        }
        else{
          $fileSystem = new Filesystem();
          $fileSystem->remove(array('files/Facture-'.$watchFacture->getNumber().'.pdf'));
          $prixTicketNull =  $em->getRepository('AppBundle:Ticket')->findByPrice($customer);
          $prixtotal =  $em->getRepository('AppBundle:Ticket')->findPriceByStatus($customer);
          $watchFacture->setPrice($prixtotal + $prixTicketNull);
          $ticket->setFacture($watchFacture);
          $em = $this->getDoctrine()->getManager();
          $em->persist($watchFacture);
          $em->flush();

          $tickets = $em->getRepository('AppBundle:Ticket')->findByFacture($watchFacture);

          $pdf = $this->get('knp_snappy.pdf');
          $pdf->setOption('footer-html', 'http://colloque.euralens.org/files/footer.html');
          $pdf->setOption('header-html', 'http://colloque.euralens.org/files/footer.html');
          $pdf->setOption('header-spacing', 12);

          $pdf->generateFromHtml(
            $this->renderView(
              'factures/facture.html.twig', array(
                'date' => $date,
                'facture' => $watchFacture,
                'tickets' => $tickets,
              )
            ),
            'files/Facture-'.$watchFacture->getNumber().'.pdf'
          );

        }

        $pdf = $this->get('knp_snappy.pdf');
        $pdf->setOption('footer-html', 'http://colloque.euralens.org/files/footer.html');
        $pdf->setOption('header-html', 'http://colloque.euralens.org/files/footer.html');
        $pdf->setOption('header-spacing', 12);

        $pdf->generateFromHtml(
          $this->renderView(
            'ticket/ticket.html.twig', array(
              'date' => $date,
              'ticket' => $ticket,
            )
          ),
          'files/Ticket-'.$ticket->getTicketNumber().'.pdf'
        );

        return $this->redirectToRoute('recap_new');
      }

    }

    return $this->render('ticket/new.html.twig', array(
      'ticket' => $ticket,
      'editMode' => $ticket->getId() !== null,
      'form' => $form->createView(),
    ));
  }


  /**
  * Finds and displays a ticket entity.
  *
  * @Route("/{id}", name="ticket_show")
  * @Method("GET")
  */
  public function showAction(Ticket $ticket)
  {
    $deleteForm = $this->createDeleteForm($ticket);

    return $this->render('ticket/show.html.twig', array(
      'ticket' => $ticket,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
  * Displays a form to edit an existing ticket entity.
  *
  * @Route("/{id}/edit", name="ticket_edit")
  * @Method({"GET", "POST"})
  */
  public function editAction(Request $request, Ticket $ticket)
  {
    $deleteForm = $this->createDeleteForm($ticket);
    $editForm = $this->createForm('AppBundle\Form\TicketType', $ticket);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('ticket_edit', array('id' => $ticket->getId(),'factureid' => $ticket->getFacture()));
    }

    return $this->render('ticket/edit.html.twig', array(
      'ticket' => $ticket,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
  * Deletes a ticket entity.
  *
  * @Route("/{id}", name="ticket_delete")
  * @Method("DELETE")
  */
  public function deleteAction(Request $request, Ticket $ticket, \Swift_Mailer $mailer)
  {


    $form = $this->createDeleteForm($ticket);
    $form->handleRequest($request);

    $em = $this->getDoctrine()->getManager();

    $facture = $ticket->getFacture();

    date_default_timezone_set('Europe/Paris');
    $date = date('d-m-Y');

    if ($form->isSubmitted() && $form->isValid()) {

      $em = $this->getDoctrine()->getManager();

      $ticket->setStatus(2);

      $avoir = new Avoir();
      $avoir->setFacture($facture);
      $em->persist($avoir);
      $em->flush();
      $avoir->setNumber(str_pad($avoir->getId(),6,'0',STR_PAD_LEFT));
      $em->persist($avoir);
      $em->flush();

      $pdf = $this->get('knp_snappy.pdf');
      $pdf->setOption('footer-html', 'http://colloque.euralens.org/files/footer.html');
      $pdf->setOption('header-html', 'http://colloque.euralens.org/files/footer.html');
      $pdf->setOption('header-spacing', 12);


      $pdf->generateFromHtml(
      $this->renderView(
          'factures/avoir.html.twig', array(
            'date' => $date,
            'avoir' => $avoir,
            'facture' => $facture,
            'ticket' => $ticket,
                  )
          ),
          'files/Avoir-'.$avoir->getNumber().'.pdf'
      );

      // $mail = $facture->getCustomer()->getUser()->getEmail();
      //
      // $messageAdmin = (new \Swift_Message('Confirmation Annulation Paiement'))
      // ->setFrom('send@example.com')
      // ->setTo('euralenscolloque@gmail.com')
      // ->setBody(
      //   $this->renderView(
      //     'email/confirmationannulationadmin.html.twig',
      //     array(
      //       'facture' => $facture,
      //       'ticket' => $ticket,
      //     )
      //   ),'text/html'
      // );
      //
      // $messageClient = (new \Swift_Message('Confirmation Annulation Paiement'))
      // ->setFrom('send@example.com')
      // ->setTo($mail)
      // ->setBody(
      //   $this->renderView(
      //     'email/confirmationannulationclient.html.twig',
      //     array(
      //       'facture' => $facture,
      //       'ticket' => $ticket,
      //     )
      //   ),'text/html'
      // );
      //
      // $mailer->send($messageAdmin);
      // $mailer->send($messageClient);
    }


    return $this->redirectToRoute('admin_page');
  }

  /**
  * Cancel a ticket entity.
  *
  * @Route("/{id}", name="ticket_cancel")
  * @Method("POST")
  */
  public function annulationAction(Request $request, Ticket $ticket, \Swift_Mailer $mailer)
  {


    if ($request->request->has('annulationfacture')) {

      $em = $this->getDoctrine()->getManager();
      $id = $_POST['ticketid'];
      $ticket = $em->getRepository('AppBundle:Ticket')->findOneById($id);
      $ticket->setStatus(1);
      $em->flush();

      $facture = $ticket->getFacture();
      $tickets = $em->getRepository('AppBundle:Ticket')->findByFacture($facture);

      if(!$tickets){

        $em = $this->getDoctrine()->getManager();
        $ticket->setStatus(1);
        $em->flush();

      }

      $mail = $facture->getCustomer()->getUser()->getEmail();

      $messageAdmin = (new \Swift_Message('Annulation Paiement'))
      ->setFrom('send@example.com')
      ->setTo('euralenscolloque@gmail.com')
      ->setBody(
        $this->renderView(
          'email/demandeannulationadmin.html.twig',
          array(
            'facture' => $facture,
            'ticket' => $ticket,
          )
        ),'text/html'
      );

      $messageClient = (new \Swift_Message('Annulation Paiement'))
      ->setFrom('send@example.com')
      ->setTo($mail)
      ->setBody(
        $this->renderView(
          'email/demandeannulationclient.html.twig',
          array(
            'facture' => $facture,
            'ticket' => $ticket,
          )
        ),'text/html'
      );

      $mailer->send($messageAdmin);
      $mailer->send($messageClient);
    }


    return $this->redirectToRoute('fos_user_profile_show');
  }

  /**
  * Creates a form to delete a ticket entity.
  *
  * @param Ticket $ticket The ticket entity
  *
  * @return \Symfony\Component\Form\Form The form
  */
  private function createDeleteForm(Ticket $ticket)
  {
    return $this->createFormBuilder()
    ->setAction($this->generateUrl('ticket_delete', array('id' => $ticket->getId())))
    ->setMethod('DELETE')
    ->getForm()
    ;
  }

}
