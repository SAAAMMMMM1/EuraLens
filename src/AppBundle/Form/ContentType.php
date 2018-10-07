<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use FM\ElfinderBundle\Form\Type\ElFinderType;


class ContentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title')
        ->add('description', CKEditorType::class, array(
                'config' => array(
                        'filebrowserBrowseRoute' => 'elfinder',
                        'filebrowserBrowseRouteParameters' => array(
                                  'instance' => 'default',
                                  'homeFolder' => ''))))
        ->add('picture', CKEditorType::class, array(
                'config' => array(
                        'filebrowserBrowseRoute' => 'elfinder',
                        'filebrowserBrowseRouteParameters' => array(
                                  'instance' => 'default',
                                  'homeFolder' => ''))));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Content'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_content';
    }


}
