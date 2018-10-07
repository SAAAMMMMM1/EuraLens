<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListeAttente
 *
 * @ORM\Table(name="liste_attente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ListeAttenteRepository")
 */
class ListeAttente
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="society", type="string", length=255)
     */
    private $society;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phonenumber", type="string", length=255)
     */
    private $phonenumber;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname.
     *
     * @param string $firstname
     *
     * @return ListeAttente
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname.
     *
     * @param string $lastname
     *
     * @return ListeAttente
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set society.
     *
     * @param string $society
     *
     * @return ListeAttente
     */
    public function setSociety($society)
    {
        $this->society = $society;

        return $this;
    }

    /**
     * Get society.
     *
     * @return string
     */
    public function getSociety()
    {
        return $this->society;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return ListeAttente
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phonenumber.
     *
     * @param string $phonenumber
     *
     * @return ListeAttente
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * Get phonenumber.
     *
     * @return string
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }
}
