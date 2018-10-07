<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Texte
 *
 * @ORM\Table(name="texte")
 * @ORM\Entity
 */
class Texte
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
     * @ORM\Column(name="text", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $text;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=false, unique=false)
     */
    private $number;


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
     * Set text.
     *
     * @param string $text
     *
     * @return Texte
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set number.
     *
     * @param int $number
     *
     * @return Texte
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }
}
