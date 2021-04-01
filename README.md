# Imperium Clan Software - Dashboard Bundle

Dashboard for symfony bundle

## Configuration

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

