<?php

namespace ICS\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Twig\Environment;

/**
 * @ORM\Table(name="helpwidgets", schema="dashboard")
 * @ORM\Entity
 */
class HelpWidget extends Widget
{
    public function __construct(Environment $twig)
    {
        parent::__construct($twig);
        $this->setWidth(5);
        $this->setHeight(3);
        $this->setBgColor('grey');
    }

    public function getJs()
    {
        if (null == $this->twig) {
            return '';
        }

        return $this->twig->render('@Dashboard/Generic/HelpWidget.js.twig', ['widget' => $this]);
    }

    public function getUI()
    {
        if (null == $this->twig) {
            return '';
        }

        return $this->twig->render('@Dashboard/Generic/HelpWidget.html.twig', ['widget' => $this]);
    }
}
