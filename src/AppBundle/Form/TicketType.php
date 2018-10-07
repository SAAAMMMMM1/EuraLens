<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('lastName')
          ->add('firstName')
          ->add('society')
          ->add('day1TransportTrain')
          ->add('day1Breakfast')
          ->add('day1Visite')
          ->add('day1TransportBus')
          ->add('day2TransportBus')
          ->add('day2Visite')
          ->add('day2Breakfast')
          ->add('day2TransportTrain')
          ->add('day2Night')
          ->add('day2TransportBusNight')
          ->add('optionVisite')
          ->add('optionExpo')
          ->add('optionArtDeco')
          ->add('optionDecouverte')
          ->add('optionGrandSite')
          ->add('mailParticipant');

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_ticket';
    }


}
