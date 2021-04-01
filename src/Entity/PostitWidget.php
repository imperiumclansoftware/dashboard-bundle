<?php

namespace ICS\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Twig\Environment;

/**
 * @ORM\Table(name="postitwidgets", schema="dashboard")
 * @ORM\Entity
 */
class PostitWidget extends Widget
{
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $text = 'Votre texte ici !';

    public function __construct(Environment $twig)
    {
        parent::__construct($twig);
        $this->setWidth(3);
        $this->setHeight(3);
        $this->setBgColor('#ffff9f');
        $this->setTextColor('#000091');
    }

    public function getJs()
    {
        if (null == $this->twig) {
            return '';
        }

        return $this->twig->render('@Dashboard/Generic/PostitWidget.js.twig', ['widget' => $this]);
    }

    public function getUI()
    {
        if (null == $this->twig) {
            return '';
        }

        return $this->twig->render('@Dashboard/Generic/PostitWidget.html.twig', ['widget' => $this]);
    }

    /**
     * Get the value of text.
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text.
     *
     * @return self
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}
