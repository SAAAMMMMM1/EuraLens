<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Common\Collections;
use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\TicketRepository;
use AppBundle\Repository\CustomerRepository;
use AppBundle\Repository\FactureRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class ExportController extends Controller
{
    /**
     *
     * @Route("/csv", name="admin_csv")
     */
    public function exportAction(Request $request)
    {

      $em = $this->getDoctrine()->getManager();
      $customers = $em->getRepository('AppBundle:Customer')->findAll();
      $factures  =  $em->getRepository('AppBundle:Facture')->findAll();
      $tickets  =  $em->getRepository('AppBundle:Ticket')->findAll();


      $writer = $this->container->get('egyg33k.csv.writer');
      $csv = $writer::createFromFileObject(new \SplTempFileObject());
      $csv->insertOne([
        'Nom',
        'Prenom',
        'Societe',
        'N° Ticket',
        'Day1TransportTrain',
        'Day1Breakfast',
        'Day1Visite',
        'Day1TransportBus',
        'Day2TransportBus',
        'Day2Visite',
        'Day2Breakfast',
        'Day2TransportTrain',
        'Day2Night',
        'Day2TransportBusNight',
        'OptionVisite',
        'OptionExpo',
        'OptionArtDeco',
        'OptionDecouverte',
        'OptionGrandSite',
        'Price',
        'Customer Prenom',
        'Customer Nom',
        'Customer Societe',
        'Customer Adresse',
        'Customer Code Postal',
        'Customer Ville',
        'Customer Telephone',
        'Customer Email'
        ]);

      foreach($tickets as $ticket){
        $csv->insertOne([
          $ticket->getLastName(),
          $ticket->getFirstName(),
          $ticket->getSociety(),
          $ticket->getTicketNumber(),
          $ticket->getDay1TransportTrain(),
          $ticket->getDay1Breakfast(),
          $ticket->getDay1Visite(),
          $ticket->getDay1TransportBus(),
          $ticket->getDay2TransportBus(),
          $ticket->getDay2Visite(),
          $ticket->getDay2Breakfast(),
          $ticket->getDay2TransportTrain(),
          $ticket->getDay2Night(),
          $ticket->getDay2TransportBusNight(),
          $ticket->getOptionVisite(),
          $ticket->getOptionExpo(),
          $ticket->getOptionArtDeco(),
          $ticket->getOptionDecouverte(),
          $ticket->getOptionGrandSite(),
          $ticket->getPrice(),
          $ticket->getCustomer()->getFirstname(),
          $ticket->getCustomer()->getLastname(),
          $ticket->getCustomer()->getSociety(),
          $ticket->getCustomer()->getAdress(),
          $ticket->getCustomer()->getCp(),
          $ticket->getCustomer()->getTown(),
          $ticket->getCustomer()->getPhonenumber(),
          $ticket->getCustomer()->getUser()->getEmail()

        ]);
      }
      $csv->output('liste.csv');
      die();

      /*
      Faire L'export complet de ce qui est demande par marlene.
      */

    }

}
