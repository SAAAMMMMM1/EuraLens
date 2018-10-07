<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Common\Collections;
use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\TicketRepository;

/**
 * Ticket controller.
 *
 * @Route("ticket")
 */
class PaiementController extends Controller
{
    /**
     *
     * @Route("/paiement", name="paiement_facture")
     */
    public function paiementAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $customer =   $em->getRepository('AppBundle:Customer')->findByUser($user)[0];
        $facture = $em->getRepository('AppBundle:Facture')->findOneByCustomer($customer);
        $price =  $em->getRepository('AppBundle:Ticket')->computeSum($facture);
        $prixPayzen = $price * 100;

        $random = random_int(100000,999999);

        date_default_timezone_set('Europe/Paris');
        $date = date('YmdHis');

        $vads_action_mode = "INTERACTIVE";
        $vads_capture_delay = "0";
        $vads_ctx_mode = "TEST";
        $vads_currency = "978";
        $vads_cust_cell_phone = "978";
        $vads_cust_city = "978";
        $vads_cust_email = "salb_du62@outlook.fr";
        $vads_cust_first_name = "978";
        $vads_cust_id = "978";
        $vads_cust_last_name = "978";
        $vads_cust_title = "978";
        $vads_page_action = "PAYMENT";
        $vads_payment_config = "SINGLE";
        $vads_return_mode = "POST";
        $vads_site_id = "34880966";
        $vads_trans_date = $date;
        $vads_trans_id = "$random";
        $vads_url_return ="http://colloque.euralens.org/return";
        $vads_version ="V2";
        $certificate = "2532840209385675";

        $rawData = $vads_action_mode."+".
        $prixPayzen."+".
        $vads_capture_delay."+".
        $vads_ctx_mode."+".
        $vads_currency."+".
        $vads_cust_cell_phone."+".
        $vads_cust_city."+".
        $vads_cust_email."+".
        $vads_cust_first_name."+".
        $vads_cust_id."+".
        $vads_cust_last_name."+".
        $vads_cust_title."+".
        $vads_page_action."+".
        $vads_payment_config."+".
        $vads_return_mode."+".
        $vads_site_id."+".
        $vads_trans_date."+".
        $vads_trans_id."+".
        $vads_url_return."+".
        $vads_version."+".
        $certificate;

        $signature = sha1($rawData);

        $facture->setSignature($signature);
        $em->persist($facture);
        $em->flush();


        return $this->render('paiement/new.html.twig',array(
            'price' => $price,
            'prixPayzen' => $prixPayzen,
            'vads_action_mode' => $vads_action_mode,
            'vads_capture_delay' => $vads_capture_delay,
            'vads_ctx_mode' => $vads_ctx_mode,
            'vads_currency' => $vads_currency,
            'vads_cust_cell_phone' => $vads_cust_cell_phone,
            'vads_cust_city' => $vads_cust_city,
            'vads_cust_email' => $vads_cust_email,
            'vads_cust_first_name' => $vads_cust_first_name,
            'vads_cust_id' => $vads_cust_id,
            'vads_cust_last_name' => $vads_cust_last_name,
            'vads_cust_title' => $vads_cust_title,
            'vads_page_action' => $vads_page_action,
            'vads_payment_config' => $vads_payment_config,
            'vads_return_mode' => $vads_return_mode,
            'vads_site_id' => $vads_site_id,
            'vads_trans_date' => $vads_trans_date,
            'vads_trans_id' => $vads_trans_id,
            'vads_url_return' => $vads_url_return,
            'vads_version' => $vads_version,
            'signature' => $signature
        ));
    }
}
