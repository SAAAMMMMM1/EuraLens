<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FactureRepository")
 */
class Facture
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", nullable=true, unique=true)
     */
    private $number;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", nullable=false, unique=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false, unique=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="signature", type="string", nullable=true, unique=true, length=255)
     */
    private $signature;

    /**
     * @var \AppBundle\Entity\Customer
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer", inversedBy="factures")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="facture")
     */
    private $tickets;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Facture
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Add ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     *
     * @return Facture
     */
    public function addTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Facture
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Facture
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Facture
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set signature
     *
     * @param string $signature
     *
     * @return Facture
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }
}
