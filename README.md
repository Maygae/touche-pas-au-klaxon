# Touche pas au klaxon

## Description

Touche pas au klaxon est une application web intranet de covoiturage inter-sites développée en PHP selon une architecture MVC.  
Elle permet de diffuser les trajets professionnels prévus entre les différentes agences de l’entreprise afin de favoriser le covoiturage et de réduire le nombre de véhicules utilisés.

## Fonctionnalités

### Visiteur
- Consulter la liste des trajets planifiés ayant encore des places disponibles.
- Voir uniquement les trajets à venir, triés par date de départ croissante.

### Utilisateur connecté
- Se connecter à l’application.
- Consulter les détails d’un trajet.
- Créer un trajet.
- Modifier les trajets dont il est l’auteur.
- Supprimer les trajets dont il est l’auteur.

### Administrateur
- Accéder au tableau de bord.
- Lister les utilisateurs.
- Lister les agences.
- Créer, modifier et supprimer une agence.
- Lister les trajets.
- Supprimer un trajet.

## Technologies utilisées

- PHP 8.1+
- Architecture MVC
- MySQL ou MariaDB
- Bootstrap 5
- Sass
- Composer
- PHPStan
- PHPUnit
- Git / GitHub

## Prérequis

Avant de lancer le projet, il faut disposer de :

- PHP 8.1 ou supérieur
- Composer
- MySQL ou MariaDB
- Node.js et npm si la compilation Sass est utilisée

## Installation

1. Cloner le dépôt GitHub :
   ```bash
   git clone https://github.com/ton-pseudo/touche-pas-au-klaxon.git
   cd TOUCHE-PAS-AU-KLAXON
   ```

2. Installer les dépendances PHP :
   ```bash
   composer install
   ```

3. Installer les dépendances front si nécessaire :
   ```bash
   npm install
   ```

4. Créer la base de données `klaxon` dans MySQL ou MariaDB.

5. Importer le script de création de la base :
   ```bash
   mysql -u root -p klaxon < sql/schema.sql
   ```

6. Importer le jeu d’essai :
   ```bash
   mysql -u root -p klaxon < sql/seeds.sql
   ```

7. Configurer les accès à la base de données dans le fichier `.env` ou dans le fichier de configuration du projet selon l’architecture retenue.

8. Lancer le serveur local :
   ```bash
   php -S localhost:8000 -t public
   ```

9. Ouvrir l’application dans le navigateur :
   ```text
   http://localhost:8000
   ```

## Structure du projet

```text
app/
  Controllers/
  Core/
  Models/
  Views/
assets/
config/
docs/
node_modules/
public/
sql/
tests/
vendor/
.gitignore
composer.json
composer.lock
package.json
package-lock.json
phpstan.neon
phpunit.xml
README.md
```

Cette organisation respecte une architecture MVC avec séparation des contrôleurs, modèles, vues et du cœur applicatif, ainsi que les dossiers techniques nécessaires (configuration, assets, scripts SQL, tests et dépendances).

## Scripts utiles

### Lancer l’analyse statique
```bash
composer analyse
```

### Lancer les tests
```bash
composer test
```

## Contrôles de cohérence

L’application vérifie notamment les règles suivantes lors de la création ou de la modification d’un trajet :

- l’agence de départ et l’agence d’arrivée doivent être différentes ;
- la date et l’heure d’arrivée doivent être postérieures à celles du départ ;
- le nombre de places disponibles ne peut pas être supérieur au nombre de places totales.

## Comptes de démonstration

### Administrateur
- Email : `admin@klaxon.fr`
- Mot de passe : `password`

### Utilisateur
- Email : `sophie.dubois@email.fr`
- Mot de passe : `password`

## Livrables présents dans le dépôt

Le dépôt GitHub contient :

- le code du projet ;
- le script de création de la base de données ;
- le script d’alimentation de la base de données ;
- ce fichier README.md.

## Auteur

Projet réalisé dans le cadre du développement de l’application **Touche pas au klaxon**.