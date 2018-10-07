<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Common\Collections;
use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\TicketRepository;
use AppBundle\Entity\CodePromo;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Ticket controller.
 *
 * @Route("ticket")
 */
class PostPaiementController extends Controller
{
    /**
     *
     * @Route("/paiement/test", name="postpaiement_facture")
     * @Method("POST")
     */
    public function paiementAction(Request $request)
    {
      $user = $this->getUser();
      $em = $this->getDoctrine()->getManager();

      $customer =   $em->getRepository('AppBundle:Customer')->findByUser($user)[0];
      $facture = $em->getRepository('AppBundle:Facture')->findOneByCustomer($customer);
      $prixtotal =  $em->getRepository('AppBundle:Ticket')->computeSum($facture);
      $price =  $em->getRepository('AppBundle:Facture')->findByPrice($customer);
      $prixPayzen = $prixtotal * 100;

      if ($request->request->has('codepromo')) {

        $codePromo = $request->request->get('code_promo' , null);
        $code = $em->getRepository('AppBundle:CodePromo')->findOneBy(['code' => $codePromo]);

        if($code){

        $facture->setPrice(0);
        $facture->setStatus(1);
        $em->remove($code);
        $em->persist($facture);

        $em->flush();

        $request->getSession()
        ->getFlashBag()
        ->add('promovalide', 'Votre code promotionnel a été validé, le montant de votre facture est de
        0€. Vous recevrez vos billets lors de la validation par l\'organisateur.');

        return $this->redirectToRoute('fos_user_security_homepage');

      }else{

        $request->getSession()
        ->getFlashBag()
        ->add('promo', 'Ce code promotionnel n\'existe pas !');
        return $this->redirectToRoute('paiement_facture');

      }
      }

      if ($request->request->has('paiementForm')) {

        $paiement = $_POST['paiement'];

        if ($paiement == 2 || $paiement == 3){

        $facture->setStatus(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($facture);
        $em->flush();
        $request->getSession()
                ->getFlashBag()
                ->add('paiement', 'Votre commande est en cours de validation par l\'organisateur');

          return $this->redirectToRoute('fos_user_security_homepage');
        }


        else{

          $request->getSession()
          ->getFlashBag()
          ->add('choixpaiement', 'Veuillez choisir un mode de paiement');
          return $this->redirectToRoute('paiement_facture');

        }
      }
    }
}
