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
use AppBundle\Entity\CodePromo;
use AppBundle\Entity\Content;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections;

class DefaultController extends Controller
{
  /**
  * @Route("/", name="homepage")
  */
  public function indexAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();
    $texte = $em->getRepository('AppBundle:Texte')->findAll();
    $reservationCount = $em->getRepository('AppBundle:Ticket')->computeCountPersonNumber();
    $contents = $em->getRepository('AppBundle:Content')->findAll();
    $reservationMax = $this->container->getParameter('reservation_max');
    $texte1 = $em->getRepository('AppBundle:Texte')->findOneByNumber(1);

    if ($request->request->has('ckeditortext')){

      $reservationMax = $this->container->getParameter('reservation_max');
      $reservationCount = $em->getRepository('AppBundle:Ticket')->computeCountPersonNumber();
      $data = $_POST['editor1'];
      $texte1 = $em->getRepository('AppBundle:Texte')->findOneByNumber(1);
      $texte1->setText($data);
      $em->persist($texte1);
      $em->flush();

      return $this->render('default/index.html.twig',array(
        'reservationCount' => $reservationCount,
        'reservationMax' => $reservationMax,
        'contents' => $contents,
        'texte1' => $texte1,
      ));
    }


        return $this->render('default/index.html.twig',array(
          'reservationMax' => $reservationMax,
          'contents' => $contents,
          'reservationCount' => $reservationCount,
          'texte1' => $texte1,
        ));
  }

  /**
  * @Route("/ticket/new", name="ticket_new")
  */
  public function resAction(Request $request)
  {
    // replace this example code with whatever you need
    return $this->render('ticket/new.html.twig');
  }

  /**
  * @Route("/recapitulatif", name="recapitulatif")
  */
  public function recapAction(Request $request)
  {
    // replace this example code with whatever you need
    return $this->render('default/recapitulatif.html.twig', [
      'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
    ]);
  }
  /**
  * @Route("/erreurlogin", name="popup")
  */
  public function popupAction(Request $request)
  {

    $request->getSession()
    ->getFlashBag()
    ->add('erreur', 'Merci');
    return $this->render('default/modal.html.twig');
  }
  /**
  * @Route("../customer/new", name="new")
  * @Method({"GET", "POST"})
  */
  public function customerNewAction(Request $request)
  {
    $user = $this->getUser();
    if (!is_object($user) || !$user instanceof UserInterface) {
      throw new AccessDeniedException('This user does not have access to this section.');
    }
    return $this->render('customer/new.html.twig', array(
      'user' => $user,
      'targetUrl' => $this->getTargetUrlFromSession($request->getSession()),
    ));
  }
  /**
  * @Route("/admin", name="admin_page")
  *
  */
  public function adminPageAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $tickets = $em->getRepository('AppBundle:Ticket')->findAll();

    return $this->render('admin/admin.html.twig', array(
      'tickets' => $tickets,
    ));
  }

  /**
  * @Route("/facture", name="admin_facture")
  *
  */
  public function factureAction(Request $request)

  {

    $user = $this->getUser();
    $em = $this->getDoctrine()->getManager();
    $customers = $em->getRepository('AppBundle:Customer')->findAll();
    $factures  =  $em->getRepository('AppBundle:Facture')->findAll();


  }
}
