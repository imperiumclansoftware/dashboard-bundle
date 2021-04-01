<?php

namespace ICS\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ICS\DashboardBundle\Form\Type\WidgetType;
use Twig\Environment;

/**
 * @ORM\Table(name="widgets", schema="dashboard")
 * @ORM\Entity()
 * @ORM\MappedSuperclass
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 */
class Widget
{
    protected $twig;
    protected $configForm = WidgetType::class;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="x", type="integer", nullable=true)
     */
    protected $x = 0;

    /**
     * @ORM\Column(name="y", type="integer", nullable=true)
     */
    protected $y = 0;

    /**
     * @ORM\Column(name="width", type="integer", nullable=true)
     */
    protected $width;

    /**
     * @ORM\Column(name="height", type="integer", nullable=true)
     */
    protected $height;

    /**
     * @ORM\Column(name="type", type="string", length=100, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $user_id;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $config;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $resize = true;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $dashboardName = '';
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $bgColor = '#007bff';
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $textColor = '#ffffff';

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->configForm = WidgetType::class;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(?int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(?int $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($config): self
    {
        $this->config = $config;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of resize.
     */
    public function getResize()
    {
        return $this->resize;
    }

    /**
     * Set the value of resize.
     *
     * @return self
     */
    public function setResize($resize)
    {
        $this->resize = $resize;

        return $this;
    }

    public function getJs()
    {
        return '';
    }

    public function getUI()
    {
        return 'New Widget';
    }

    /**
     * Get the value of dashbordName.
     */
    public function getDashboardName()
    {
        return $this->dashboardName;
    }

    /**
     * Set the value of dashbordName.
     *
     * @return self
     */
    public function setDashboardName($dashboardName)
    {
        $this->dashboardName = $dashboardName;

        return $this;
    }

    /**
     * Set the value of twig.
     *
     * @return self
     */
    public function setTwig(Environment $twig)
    {
        $this->twig = $twig;

        return $this;
    }

    /**
     * Get the value of bgColor.
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }

    /**
     * Set the value of bgColor.
     *
     * @return self
     */
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    /**
     * Get the value of textColor.
     */
    public function getTextColor()
    {
        return $this->textColor;
    }

    /**
     * Set the value of textColor.
     *
     * @return self
     */
    public function setTextColor($textColor)
    {
        $this->textColor = $textColor;

        return $this;
    }

    /**
     * Get the value of configForm.
     */
    public function getConfigForm()
    {
        return $this->configForm;
    }
}
