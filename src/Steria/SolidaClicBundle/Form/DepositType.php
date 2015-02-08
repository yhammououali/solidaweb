<?php

namespace Steria\SolidaClicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DepositType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('address',   'text')
      ->add('zip',       'number')
      ->add('city',      'text')
      ->add('description',      'textarea')
      ->add('title',      'text')
    ;
  }
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Steria\SolidaClicBundle\Entity\HelpRequest'
    ));
  }
  public function getName()
  {
    return 'steria_solidaclic_deposit';
  }
}