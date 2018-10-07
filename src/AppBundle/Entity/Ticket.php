<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketRepository")
 */
class Ticket
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
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="society", type="string", length=255, nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $society;

    /**
     * @var string
     *
     * @ORM\Column(name="ticket_number", type="string", nullable=true, unique=true)
     */
    private $ticketNumber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="day1transport_train", type="boolean", nullable=false, unique=false)
     */
    private $day1TransportTrain;

    /**
     * @var integer
     *
     * @ORM\Column(name="day1breakfast", type="integer", nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $day1Breakfast;

    /**
     * @var integer
     *
     * @ORM\Column(name="day1visite", type="integer", nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $day1Visite;

    /**
     * @var boolean
     *
     * @ORM\Column(name="day1transport_bus", type="boolean", nullable=false, unique=false)
     */
    private $day1TransportBus;

    /**
     * @var boolean
     *
     * @ORM\Column(name="day2transport_bus", type="boolean", nullable=false, unique=false)
     */
    private $day2TransportBus;

    /**
     * @var integer
     *
     * @ORM\Column(name="day2visite", type="integer", nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $day2Visite;

    /**
     * @var integer
     *
     * @ORM\Column(name="day2breakfast", type="integer", nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $day2Breakfast;

    /**
     * @var boolean
     *
     * @ORM\Column(name="day2transport_train", type="boolean", nullable=false, unique=false)
     */
    private $day2TransportTrain;

    /**
     * @var boolean
     *
     * @ORM\Column(name="day2night", type="boolean", nullable=false, unique=false)
     */
    private $day2Night;

    /**
     * @var boolean
     *
     * @ORM\Column(name="day2transport_bus_night", type="boolean", nullable=false, unique=false)
     */
    private $day2TransportBusNight;

    /**
     * @var integer
     *
     * @ORM\Column(name="option_visite", type="integer", nullable=true, unique=false)
     */
    private $optionVisite;

    /**
     * @var integer
     *
     * @ORM\Column(name="option_expo", type="integer", nullable=true, unique=false)
     */
    private $optionExpo;

    /**
     * @var integer
     *
     * @ORM\Column(name="option_art_deco", type="integer", nullable=true, unique=false)
     */
    private $optionArtDeco;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_decouverte", type="boolean", nullable=false, unique=false)
     */
    private $optionDecouverte;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_grand_site", type="boolean", nullable=false, unique=false)
     */
    private $optionGrandSite;

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
     * @var string
     *
     * @ORM\Column(name="mailparticipant", type="string", nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $mailParticipant;

    /**
     * @var \AppBundle\Entity\Customer
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer", inversedBy="tickets")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;

    /**
     * @var \AppBundle\Entity\Facture
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Facture", inversedBy="tickets")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="facture_id", referencedColumnName="id")
     * })
     */
    private $facture;


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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Ticket
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Ticket
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set society
     *
     * @param string $society
     *
     * @return Ticket
     */
    public function setSociety($society)
    {
        $this->society = $society;

        return $this;
    }

    /**
     * Get society
     *
     * @return string
     */
    public function getSociety()
    {
        return $this->society;
    }

    /**
     * Set ticketNumber
     *
     * @param integer $ticketNumber
     *
     * @return Ticket
     */
    public function setTicketNumber($ticketNumber)
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }

    /**
     * Get ticketNumber
     *
     * @return integer
     */
    public function getTicketNumber()
    {
        return $this->ticketNumber;
    }

    /**
     * Set day1TransportTrain
     *
     * @param boolean $day1TransportTrain
     *
     * @return Ticket
     */
    public function setDay1TransportTrain($day1TransportTrain)
    {
        $this->day1TransportTrain = $day1TransportTrain;

        return $this;
    }

    /**
     * Get day1TransportTrain
     *
     * @return boolean
     */
    public function getDay1TransportTrain()
    {
        return $this->day1TransportTrain;
    }

    /**
     * Set day1Breakfast
     *
     * @param integer $day1Breakfast
     *
     * @return Ticket
     */
    public function setDay1Breakfast($day1Breakfast)
    {
        $this->day1Breakfast = $day1Breakfast;

        return $this;
    }

    /**
     * Get day1Breakfast
     *
     * @return integer
     */
    public function getDay1Breakfast()
    {
        return $this->day1Breakfast;
    }

    /**
     * Set day1Visite
     *
     * @param integer $day1Visite
     *
     * @return Ticket
     */
    public function setDay1Visite($day1Visite)
    {
        $this->day1Visite = $day1Visite;

        return $this;
    }

    /**
     * Get day1Visite
     *
     * @return integer
     */
    public function getDay1Visite()
    {
        return $this->day1Visite;
    }

    /**
     * Set day1TransportBus
     *
     * @param boolean $day1TransportBus
     *
     * @return Ticket
     */
    public function setDay1TransportBus($day1TransportBus)
    {
        $this->day1TransportBus = $day1TransportBus;

        return $this;
    }

    /**
     * Get day1TransportBus
     *
     * @return boolean
     */
    public function getDay1TransportBus()
    {
        return $this->day1TransportBus;
    }

    /**
     * Set day2TransportBus
     *
     * @param boolean $day2TransportBus
     *
     * @return Ticket
     */
    public function setDay2TransportBus($day2TransportBus)
    {
        $this->day2TransportBus = $day2TransportBus;

        return $this;
    }

    /**
     * Get day2TransportBus
     *
     * @return boolean
     */
    public function getDay2TransportBus()
    {
        return $this->day2TransportBus;
    }

    /**
     * Set day2Visite
     *
     * @param integer $day2Visite
     *
     * @return Ticket
     */
    public function setDay2Visite($day2Visite)
    {
        $this->day2Visite = $day2Visite;

        return $this;
    }

    /**
     * Get day2Visite
     *
     * @return integer
     */
    public function getDay2Visite()
    {
        return $this->day2Visite;
    }

    /**
     * Set day2Breakfast
     *
     * @param integer $day2Breakfast
     *
     * @return Ticket
     */
    public function setDay2Breakfast($day2Breakfast)
    {
        $this->day2Breakfast = $day2Breakfast;

        return $this;
    }

    /**
     * Get day2Breakfast
     *
     * @return integer
     */
    public function getDay2Breakfast()
    {
        return $this->day2Breakfast;
    }

    /**
     * Set day2TransportTrain
     *
     * @param boolean $day2TransportTrain
     *
     * @return Ticket
     */
    public function setDay2TransportTrain($day2TransportTrain)
    {
        $this->day2TransportTrain = $day2TransportTrain;

        return $this;
    }

    /**
     * Get day2TransportTrain
     *
     * @return boolean
     */
    public function getDay2TransportTrain()
    {
        return $this->day2TransportTrain;
    }

    /**
     * Set day2Night
     *
     * @param boolean $day2Night
     *
     * @return Ticket
     */
    public function setDay2Night($day2Night)
    {
        $this->day2Night = $day2Night;

        return $this;
    }

    /**
     * Get day2Night
     *
     * @return boolean
     */
    public function getDay2Night()
    {
        return $this->day2Night;
    }

    /**
     * Set day2TransportBusNight
     *
     * @param boolean $day2TransportBusNight
     *
     * @return Ticket
     */
    public function setDay2TransportBusNight($day2TransportBusNight)
    {
        $this->day2TransportBusNight = $day2TransportBusNight;

        return $this;
    }

    /**
     * Get day2TransportBusNight
     *
     * @return boolean
     */
    public function getDay2TransportBusNight()
    {
        return $this->day2TransportBusNight;
    }

    /**
     * Set optionVisite
     *
     * @param integer $optionVisite
     *
     * @return Ticket
     */
    public function setOptionVisite($optionVisite)
    {
        $this->optionVisite = $optionVisite;

        return $this;
    }

    /**
     * Get optionVisite
     *
     * @return integer
     */
    public function getOptionVisite()
    {
        return $this->optionVisite;
    }

    /**
     * Set optionExpo
     *
     * @param integer $optionExpo
     *
     * @return Ticket
     */
    public function setOptionExpo($optionExpo)
    {
        $this->optionExpo = $optionExpo;

        return $this;
    }

    /**
     * Get optionExpo
     *
     * @return integer
     */
    public function getOptionExpo()
    {
        return $this->optionExpo;
    }

    /**
     * Set optionArtDeco
     *
     * @param integer $optionArtDeco
     *
     * @return Ticket
     */
    public function setOptionArtDeco($optionArtDeco)
    {
        $this->optionArtDeco = $optionArtDeco;

        return $this;
    }

    /**
     * Get optionArtDeco
     *
     * @return integer
     */
    public function getOptionArtDeco()
    {
        return $this->optionArtDeco;
    }

    /**
     * Set optionDecouverte
     *
     * @param boolean $optionDecouverte
     *
     * @return Ticket
     */
    public function setOptionDecouverte($optionDecouverte)
    {
        $this->optionDecouverte = $optionDecouverte;

        return $this;
    }

    /**
     * Get optionDecouverte
     *
     * @return boolean
     */
    public function getOptionDecouverte()
    {
        return $this->optionDecouverte;
    }

    /**
     * Set optionGrandSite
     *
     * @param boolean $optionGrandSite
     *
     * @return Ticket
     */
    public function setOptionGrandSite($optionGrandSite)
    {
        $this->optionGrandSite = $optionGrandSite;

        return $this;
    }

    /**
     * Get optionGrandSite
     *
     * @return boolean
     */
    public function getOptionGrandSite()
    {
        return $this->optionGrandSite;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Ticket
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
     * @return Ticket
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
     * Set mailParticipant
     *
     * @param string $mailParticipant
     *
     * @return Ticket
     */
    public function setMailParticipant($mailParticipant)
    {
        $this->mailParticipant = $mailParticipant;

        return $this;
    }

    /**
     * Get mailParticipant
     *
     * @return string
     */
    public function getMailParticipant()
    {
        return $this->mailParticipant;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Ticket
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
     * Set facture
     *
     * @param \AppBundle\Entity\Facture $facture
     *
     * @return Ticket
     */
    public function setFacture(\AppBundle\Entity\Facture $facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \AppBundle\Entity\Facture
     */
    public function getFacture()
    {
        return $this->facture;
    }
}
