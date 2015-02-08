<?php

namespace Steria\SolidaClicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('placename', 'text')
      ->add('address',   'text')
      ->add('zip',       'number')
      ->add('city',      'text')
    ;
  }
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Steria\SolidaClicBundle\Entity\Address'
    ));
  }
  public function getName()
  {
    return 'steria_solidaclic_address';
  }
}
