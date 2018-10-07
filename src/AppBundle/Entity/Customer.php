<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 */
class Customer
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
     * @var integer
     *
     * @ORM\Column(name="sexe", type="smallint", precision=0, scale=0, nullable=false, unique=false)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre prenom ne peut pas contenir de chiffres"
     * )
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne peut pas contenir de chiffres"
     * )
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="society", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $society;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $adress;

    /**
     * @var integer
     *
     * @ORM\Column(name="cp", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     * @Assert\Regex(
     *     pattern="/[^0-9]+/",
     *     match=false,
     *     message="Votre prenom ne peut pas contenir de chiffres"
     * )
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="phonenumber", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     * @Assert\Length(min=10 , max=10, minMessage="Votre numero n'est pas valide")
     * @Assert\Regex(
     *     pattern="/[^0-9]+/",
     *     match=false,
     *     message="Votre prenom ne peut pas contenir de chiffres"
     * )
     */
    private $phonenumber;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)
     * })
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Facture", mappedBy="customer")
     */
    private $factures;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="customer")
     */
    private $tickets;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->factures = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set sexe
     *
     * @param integer $sexe
     *
     * @return Customer
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return integer
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Customer
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Customer
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set society
     *
     * @param string $society
     *
     * @return Customer
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
     * Set adress
     *
     * @param string $adress
     *
     * @return Customer
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     *
     * @return Customer
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return integer
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set town
     *
     * @param string $town
     *
     * @return Customer
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set phonenumber
     *
     * @param string $phonenumber
     *
     * @return Customer
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * Get phonenumber
     *
     * @return string
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return Customer
     */
    public function setUserEmail($userEmail)
    {
        $this->user_email = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * Set facturesReference
     *
     * @param integer $facturesReference
     *
     * @return Customer
     */
    public function setFacturesReference($facturesReference)
    {
        $this->factures_reference = $facturesReference;

        return $this;
    }

    /**
     * Get facturesReference
     *
     * @return integer
     */
    public function getFacturesReference()
    {
        return $this->factures_reference;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Customer
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add facture
     *
     * @param \AppBundle\Entity\Facture $facture
     *
     * @return Customer
     */
    public function addFacture(\AppBundle\Entity\Facture $facture)
    {
        $this->factures[] = $facture;

        return $this;
    }

    /**
     * Remove facture
     *
     * @param \AppBundle\Entity\Facture $facture
     */
    public function removeFacture(\AppBundle\Entity\Facture $facture)
    {
        $this->factures->removeElement($facture);
    }

    /**
     * Get factures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFactures()
    {
        return $this->factures;
    }

    /**
     * Add ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     *
     * @return Customer
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

}
