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
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections;

class ProfileController extends Controller
{
    /**
     * Finds and displays a customer entity.
     *
     * @Route("profile", name="customer_show")
     *
     */
    public function profileActionAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $checkCustomer = $em->getRepository('AppBundle:Customer')->findByUser($user);
        if (!$checkCustomer){
            $request->getSession()
                    ->getFlashBag()
                    ->add('espaceClient', 'Merci de remplir le formulaire afin d\'acceder à l\'espace client.');
            return $this->redirectToRoute('customer_new');
        }

        $customer = $em->getRepository('AppBundle:Customer')->findByUser($user)[0];
        $facture = $em->getRepository('AppBundle:Facture')->findByTickets($customer);
        $factures = new Collections\ArrayCollection($facture);




        $ticket = $em->getRepository('AppBundle:Ticket')->findByCustomer($customer);

        $tickets = new Collections\ArrayCollection($ticket);

        return $this->render('@FOSUser/Profile/show_content.html.twig', array(
            'factures' => $factures,
            'customer' => $customer,
            'tickets' => $tickets,
            'user' => $user,
        ));
    }




}
