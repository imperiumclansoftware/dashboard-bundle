<?php

namespace ICS\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ICS\DashboardBundle\Form\Type\DTWidgetType;
use Twig\Environment;

/**
 * @ORM\Table(name="dtwidgets", schema="dashboard")
 * @ORM\Entity
 */
class DTWidget extends Widget
{
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $timezone = 'Europe/Paris';
    protected $configForm = DTWidgetType::class;
    protected $resize = false;

    public function __construct(Environment $twig)
    {
        parent::__construct($twig);
        $this->setWidth(2);
        $this->setHeight(2);
    }

    public function getJs()
    {
        if (null == $this->twig) {
            return '';
        }

        return $this->twig->render('@Dashboard/Generic/DTWidget.js.twig', ['widget' => $this]);
    }

    public function getUI()
    {
        if (null == $this->twig) {
            return '';
        }

        return $this->twig->render('@Dashboard/Generic/DTWidget.html.twig', ['widget' => $this]);
    }

    /**
     * Get the value of timezone.
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set the value of timezone.
     *
     * @return self
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }
}
