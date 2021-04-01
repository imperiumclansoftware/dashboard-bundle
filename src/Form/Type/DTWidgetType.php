<?php

namespace ICS\DashboardBundle\Form\Type;

use ICS\DashboardBundle\Entity\Widget;
//Type d'extentions de formulaire
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DTWidgetType extends WidgetType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $timezones = [];
        $zones = timezone_identifiers_list();

        foreach ($zones as $zone) {
            $timezones[\explode('/', $zone)[0]][$zone] = $zone;
        }

        $builder->add('timezone', ChoiceType::class, [
            'label' => 'Fuseau horaire',
            'choices' => $timezones,
        ]);

        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Widget::class,
        ]);
    }
}
