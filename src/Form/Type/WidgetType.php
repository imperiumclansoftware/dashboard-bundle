<?php

namespace ICS\DashboardBundle\Form\Type;

use Liip\ImagineBundle\Form\Type\ImageType;
use ICS\DashboardBundle\Entity\Widget;
use Symfony\Component\Form\AbstractType;
//Type d'extentions de formulaire
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WidgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $allroutes = $options['routes'];

        // $routes = [];
        // foreach ($allroutes as $r => $o) {
        //     if ('_' != substr($r, 0, 1)) {
        //         $routes[$r] = $r;
        //     }
        // }

        $builder->add('bgColor', ColorType::class, ['label' => "Couleur d'arrière plan"]);
        $builder->add('textColor', ColorType::class, ['label' => 'Couleur du texte']);
        // $builder->add('version', TextType::class, ['label' => "Version de l'application"]);
        // $builder->add('route', ChoiceType::class, [
        //                 'label' => "Chemin de l'application (Route)",
        //                 'choices' => $routes,
        //             ]);
        // $builder->add('valide', CheckboxType::class, ['label' => 'Application Valide', 'required' => false]);
        // $builder->add('ControleAcces', CheckboxType::class, ['label' => "Contrôle d'accès", 'required' => false]);
        // $builder->add('dbroles', CollectionType::class, [
        //     'entry_type' => RoleType::class,
        //     'entry_options' => ['label' => false],
        //     'allow_add' => true,
        //     'allow_delete' => true,
        //     'by_reference' => false,
        // ]);
        // $builder->add('image', ImageType::class, [
        //     'label' => 'Image représentante',
        //     'image_filter' => 'thumbnail',
        //     'image_path' => $options['image_path'],
        //     'data_class' => null,
        //     ]);
        $builder->add('submit', SubmitType::class, ['label' => 'Enregistrer']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Widget::class,
        ]);
    }
}
