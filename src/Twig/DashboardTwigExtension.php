<?php

namespace ICS\DashboardBundle\Twig;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use ICS\DashboardBundle\Entity\HelpWidget;
use ICS\DashboardBundle\Entity\Widget;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * NavBarExtension.
 *
 * @author David Dutas <david.dutas@ia.defensecdd.gouv.fr >
 */
class DashboardTwigExtension extends AbstractExtension
{
    private $doctrine;
    private $container;
    private $security;

    /**
     * Constructeur.
     *
     * @param RegistryInterface $doctrine
     */
    public function __construct(EntityManagerInterface $doctrine, ContainerInterface $container, Security $security)
    {
        $this->doctrine = $doctrine;
        $this->container = $container;
        $this->security = $security;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('renderDashBoard', [$this, 'renderDashBoard'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
            new TwigFunction('renderDashBoardcss', [$this, 'renderDashBoardcss'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
            new TwigFunction('renderDashBoardjs', [$this, 'renderDashBoardjs'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
        ];
    }

    public function renderDashBoard(Environment $twig, string $dashboardName)
    {
        $widgets = $this->getWidgets($twig, $dashboardName);

        return $twig->render('@Dashboard/dashboard.html.twig', [
            'config' => $this->getConfig($dashboardName),
            'widgets' => $widgets,
            'dashboard' => $dashboardName,
        ]);
    }

    public function renderDashBoardjs(Environment $twig, string $dashboardName)
    {
        $widgets = $this->getWidgets($twig, $dashboardName);

        return $twig->render('@Dashboard/js.html.twig', [
            'config' => $this->getConfig($dashboardName),
            'widgets' => $widgets,
            'dashboard' => $dashboardName,
        ]);
    }

    public function renderDashBoardcss(Environment $twig, string $dashboardName)
    {
        $widgets = $this->getWidgets($twig, $dashboardName);

        return $twig->render('@Dashboard/css.html.twig', [
            'config' => $this->getConfig($dashboardName),
            'widgets' => $widgets,
            'dashboard' => $dashboardName,
        ]);
    }

    private function getWidgets(Environment $twig, string $dashboardName)
    {
        $widgets = $this->doctrine->getRepository(Widget::class)->findBy([
            'dashboardName' => $dashboardName,
            'user_id' => $this->security->getUser()->getId(),
        ]);

        if (count($widgets) ==0) {
            $widgets=$this->getDefaultWidgets($twig);
        }

        foreach ($widgets as $widget) {
            $widget->setTwig($twig);
        }

        return $widgets;
    }

    private function getConfig(string $dashboardName)
    {
        $config = $this->container->getParameter('dashboard');

        $dashboardConfig = $config['dashboards'][$dashboardName];

        $widgets = [];

        foreach ($dashboardConfig['widgets'] as $widget) {
            $widgets[$widget['group']][] = $widget;
        }

        return [
            'nbColumns' => $dashboardConfig['nbColumns'],
            'widgets' => $widgets,
        ];
    }

    private function getDefaultWidgets(Environment $twig): ArrayCollection
    {
        $widgets=new ArrayCollection();
        $widget=new HelpWidget($twig);
        $widget->setid(-1);
        $widgets->add($widget);
        return $widgets;
    }
}
