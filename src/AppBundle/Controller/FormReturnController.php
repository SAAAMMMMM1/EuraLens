<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\Facture;
use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections;


class FormReturnController extends Controller
{

  /**
   *
   * @Route("/return", name="formreturn")
   * @Method({"GET", "POST"})
   */
  public function paiementReturnAction(Request $request, \Swift_Mailer $mailer)
  {

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $customer =   $em->getRepository('AppBundle:Customer')->findByUser($user)[0];
        $facture = $em->getRepository('AppBundle:Facture')->findOneByCustomer($customer);
        $tickets = $em->getRepository('AppBundle:Ticket')->findByFacture($facture);
        $mail = $facture->getCustomer()->getUser()->getEmail();

        $vads_trans_status = $_POST['vads_trans_status'];

        if($vads_trans_status == 'REFUSED'){

        $facture->setStatus(0);
        $em->persist($facture);
        $em->flush();

        return $this->redirectToRoute('paiement_facture');
      }else if ($vads_trans_status == 'AUTHORISED'){

        $facture->setStatus(2);
        $em->persist($facture);
        $em->flush();

        $request->getSession()
                    ->getFlashBag()
                    ->add('paiementok', 'Paiement accepté. Vos billets vous ont été envoyés par mail. Au plaisir de vous voir à l\'événement');

        $mail = $facture->getCustomer()->getUser()->getEmail();

        $message = (new \Swift_Message('Vos Tickets Odyssée 2019'))
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

        $mailer->send($message);

        return $this->redirectToRoute('customer_show');

      }
 }

 /**
  *
  * @Route("/returnipn", name="formipnreturn")
  * @Method({"POST"})
  */
 public function paiementIpnReturnAction(Request $request)
 {

    $post = $request->$request->all();

    $em = $this->getDoctrine()->getManager();

    $vads_trans_status = $post['vads_trans_status'];
    $vads_trans_id = $post['vads_trans_id'];
    $signature = $post['signature'];

    $facture = $em->getRepository('AppBundle:Facture')->find($vads_trans_id);





    if($signature == $facture->getSignature()){
      if($vads_trans_status == 'REFUSED'){

        $facture->setStatus(0);
        $em->persist($facture);
        $em->flush();

       return $this->redirectToRoute('paiement_facture');
      } else if ($vads_trans_status == 'AUTHORISED') {

        $facture->setStatus(2);
        $em->persist($facture);
        $em->flush();

        return new Response('ok');

      }
    }
  }
}
