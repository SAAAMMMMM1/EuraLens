<?php


namespace AppBundle\Repository;

use AppBundle\Entity\User;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\Customer;
use AppBundle\Entity\Facture;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    public function findByUser(User $user)
    {
            $queryBuilder = $this->createQueryBuilder('c')
                    ->where('c.user = :userid')
                    ->setParameter('userid',$user->getId())
                    ->getQuery();

            return $queryBuilder->getResult();


    }
}
