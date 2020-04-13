# API notation
API REST de gestion de notes pour une classe d'élèves.
Liste des fonctionnalités:
- Ajouter un élève
- Modifier les informations d'un élève (nom, prénom, date de naissance)
- Supprimer un élève
- Ajouter une note à un élève
- Récupérer la moyenne de toutes les notes d'un élève
- Récupérer la moyenne générale de la classe (moyenne de toutes les notes données)

Stack technique: PHP (Symfony, Api Platform, PHPUnit), Postgres, Nginx

## Comment démarrer

Pré-requis

- [Docker](https://docs.docker.com/install/#supported-platforms) >= 18.06.0
- [Docker compose](https://docs.docker.com/compose/install) >= 1.25

Pour démarrer la stack Docker, exécuter :

```bash
make install
```

Se rendre sur http://localhost:8443 pour accèder à l'api

Pour se connecter au container php 

```bash
make bash
```

## Tests

Pour lancer les tests PHPUnit, exécuter:

```bash
make phpunit
```