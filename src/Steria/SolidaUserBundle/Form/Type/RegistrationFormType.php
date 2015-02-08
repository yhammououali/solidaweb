<?php
 
namespace Steria\SolidaUserBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
 
class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('birthdate', 'birthday', array('label' => 'Date de naissance :', 'widget' => 'choice', 'format' => 'dd / MM / yyyy'))
            ->add('firstname', 'text', array('label' => 'Prénom :'))
            ->add('lastname', 'text', array('label' => 'Nom de famille :'))
            ->add('gender', 'choice', array('label' => 'Sexe :', 'choices' => array('H' => 'Homme', 'F' => 'Femme', 'A' => 'Autre')))
        ;
    }
 
    public function getName()
    {
        return 'steria_fosextend_registration';
    }
}