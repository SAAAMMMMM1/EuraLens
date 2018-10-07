<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Facture;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\User;
use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityRepository;

class TicketRepository extends EntityRepository
{
    public function findByCustomer(Customer $customer)
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->join('t.facture', 'f')
            ->where('t.customer = :customerid')
            ->setParameter('customerid',$customer->getId())
            ->orderBy('f.status' , 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }
    // public function findTicketByCustomer(Customer $customer)
    // {
    //     $queryBuilder = $this->createQueryBuilder('t')

    //         ->where('t.customer = :customerid')
    //         ->setParameter('customerid',$customer->getId())
    //         ->getQuery();

    //     return $queryBuilder->getResult();
    // }
    public function findByPrice(Customer $customer)
    {
        $queryBuilder = $this->createQueryBuilder('t')
        ->where('t.customer = :customerid')
        ->setParameter('customerid',$customer->getId())
        ->select('SUM(t.price) as prixtotal')
        ->andWhere('t.facture is null')
        ->getQuery();

        return $queryBuilder->getSingleScalarResult();
    }

    public function findPriceByStatus(Customer $customer)
    {
        $queryBuilder = $this->createQueryBuilder('t')
        ->join('t.facture', 'f')
        ->where('t.customer = :customerid')
        ->setParameter('customerid',$customer->getId())
        ->select('SUM(t.price) as prixtotal')
        ->andWhere('f.status = 0')
        ->getQuery();

        return $queryBuilder->getSingleScalarResult();
    }

    public function findTicketsByStatusCommandeEnCours(Customer $customer)
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->join('t.facture', 'f')
            ->where('t.customer = :customerid')
            ->setParameter('customerid',$customer->getId())
            ->andWhere('f.status = 0')
            ->orderBy('f.status' , 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }
//@Placer dans un service
    public function computeSum(Facture $facture) {

        $query = $this->createQueryBuilder('t')
        ->select('SUM(t.price) AS ticket_price')
        ->join('t.facture', 'f')
        ->where('f.id = :factureId')
        ->setParameter('factureId', $facture->getid())
        ->getQuery();

        return $query->getSingleScalarResult();
    }


        public function findTicketsByStatus2()
        {
            $queryBuilder = $this->createQueryBuilder('t')
                ->join('t.facture', 'f')
                ->where('f.status = 2')
                ->getQuery();

            return $queryBuilder->getResult();
        }

        public function computeSumStatus2() {

            $query = $this->createQueryBuilder('t')
            ->select('SUM(t.price) AS ticket_price')
            ->join('t.facture', 'f')
            ->where('f.status = 2')
            ->getQuery();

            return $query->getSingleScalarResult();
        }


        public function computeCountPersonNumber() {

            $query = $this->createQueryBuilder('t')
            ->select('COUNT(t) AS tickets')
            ->join('t.facture', 'f')
            ->where('f.status = 2')
            ->getQuery();

            return $query->getSingleScalarResult();
        }


        public function findPaidTicketsByOption($optionName, $optionValue)
        {
            // $optionNames = ['day1Visite', 'day2Visite', 'day3Visite']; // compléter ce tableau avec le vrai nom des options

            // if (!in_array($optionName, $optionNames)) {
            //     throw new Exception('Are you trying to fuck with me ?');
            // }

            $queryBuilder = $this->createQueryBuilder('t')
                ->join('t.facture', 'f')
                ->where('f.status = 2')
                ->andWhere('t.'.$optionName.' = :optionValue')
                ->setParameter('optionValue', $optionValue)
                ->getQuery();

            return $queryBuilder->getResult();
        }

        public function computeCountPersonNumberByOption($optionName, $optionValue)
        {
            // $optionNames = ['day1Visite', 'day2Visite', 'day3Visite']; // compléter ce tableau avec le vrai nom des options

            // if (!in_array($optionName, $optionNames)) {
            //     throw new Exception('Are you trying to fuck with me ?');
            // }

            $queryBuilder = $this->createQueryBuilder('t')
                ->select('COUNT(t) AS tickets')
                ->join('t.facture', 'f')
                ->where('f.status = 2')
                ->andWhere('t.'.$optionName.' = :optionValue')
                ->setParameter('optionValue', $optionValue)
                ->getQuery();

            return $queryBuilder->getSingleScalarResult();
        }
        
}
