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
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class ListeAttenteController extends Controller
{

  /**
  * Lists all customer entities.
  *
  * @Route("/listeattente", name="liste_attente")
  * @Method("POST")
  */
  public function listeAttenteAction(Request $request)
  {

    $user = $this->getUser();
    $em = $this->getDoctrine()->getManager();
    $customer = $em->getRepository('AppBundle:Customer')->findOneByUser($user);
    $reservationCount = $em->getRepository('AppBundle:Ticket')->computeCountPersonNumber();
    $listeAttenteRepo = $em->getRepository('AppBundle:ListeAttente');
    $mailUser = $user->getEmail();

    $listeAttente = new ListeAttente();

    if ($request->request->has('inscriptionlisteattente')) {

      $listeAttenteValue = $_POST['inscription'];

      if( $listeAttenteValue == 1 ) {

        if ($listeAttenteRepo->findOneBy(['email' => $mailUser])) {

          $request->getSession()
                  ->getFlashBag()
                  ->add('dejaListeAttente', "Vous êtes déjà inscrit sur la liste d'attente. Vous serez contacté quand une place se libérera" );

                  return $this->redirectToRoute('homepage');

        } else {

          $listeAttente->setFirstname($customer->getFirstname());
          $listeAttente->setLastname($customer->getLastname());
          $listeAttente->setSociety($customer->getSociety());
          $listeAttente->setEmail($mailUser);
          $listeAttente->setPhonenumber($customer->getPhonenumber());
          $em->persist($listeAttente);
          $em->flush();

          $request->getSession()
                  ->getFlashBag()
                  ->add('inscriptionListeAttente', "Vous êtes maintenant inscrit sur la liste d'attente. Vous serez contacté quand une place se libérera" );

          return $this->render('default/index.html.twig',array(
            'reservationCount' => $reservationCount,
          ));

        }

      }else{

        return $this->render('default/index.html.twig',array(
          'reservationCount' => $reservationCount,
        ));
      }
    }
  }
}
