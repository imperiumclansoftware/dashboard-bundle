# Imperium Clan Software - Dashboard Bundle

Dashboard for symfony bundle

## Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
composer require ics/dashboard-bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
composer require ics/dashboard-bundle
```

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    ICS\DashboardBundle\DashboardBundle::class => ['all' => true],
];
```

#### Step 3: Adding bundle routing

Add routes in applications `config/routes.yaml`

```yaml
# config/routes.yaml

# ...
dashboard_bundle:
    resource: '@DashboardBundle/config/routes.yaml'
    prefix: /dashboard
# ...
```

#### Step 4: Install Database

For install database :

```bash
# Installer la base de données

php bin/console doctrine:schema:create

```

For update database :

```bash
# Mise a jour la base de données

php bin/console doctrine:schema:update -f

```

## Configuration

### Step 1 : Dashboard configuration

```yaml
    # config/packages/dashboard.yaml

    dashboard:
        dashboards:
            homepage:
                nbColumns: 12
                widgets:
                    datetime:
                        entity: ICS\DashboardBundle\Entity\DTWidget
                        libelle: Date and Time
                        icon: fa fa-clock
                        group: Generic
                        roles: ['ROLE_USER']
                    help:
                        entity: ICS\DashboardBundle\Entity\HelpWidget
                        libelle: Help
                        icon: fa fa-question-circle
                        group: Generic
                        roles: ['ROLE_USER']
                    postit:
                        entity: ICS\DashboardBundle\Entity\PostitWidget
                        libelle: Post-It
                        icon: fa fa-sticky-note
                        group: Generic
                        roles: ['ROLE_USER']
```

### Step 2 : Twig integration

```twig

    {# templates/index.html.twig #}

    {% extends 'base.html.twig' %}

    {% block title %}Homepage{% endblock %}

    {% block stylesheets %}
        {{ renderDashBoardcss('homepage') }}
    {% endblock %}

    {% block body %}
        {{ renderDashBoard('homepage') }}
    {% endblock %}

    {% block javascripts %}
        {{ renderDashBoardjs('homepage') }}
    {% endblock %}

```

## Widget Developpement

### Step 1 : Create entity

To start, write an entity inheriting from `Widget`.

This must have at least the `getUI()` method. It can also have the `getJs()` and `getCss()` methods to add javascripts or css to your widgets.

```php

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

```

### Step 2 : Integrate in configuration

```yaml
    # ....
                widgets:
                    datetime:
                        entity: ICS\DashboardBundle\Entity\DTWidget
                        libelle: Date and Time
                        icon: fa fa-clock
                        group: Generic
                        roles: ['ROLE_USER']
    # ...

```
