<?php

namespace GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PedidosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pedido')->add('folio')->add('cliente')->add('cuenta')->add('fecha')->add('devolucion')->add('statusPedido')->add('cant')->add('clave')->add('equipo')->add('dias')->add('pu')->add('importe')->add('direccionEntrega')->add('comentarios')->add('descuento')->add('impuesto')->add('total')->add('statusPago')->add('subtotal')->add('subtotal2')        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\Pedidos'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_pedidos';
    }


}
