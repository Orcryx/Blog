# Blog OCR PHP - Projet

Ce projet est une application de blog construite en PHP8 sans framework. Il utilise Twig pour les templates, PHPMailer pour l'envoi d'emails, et PHP Dotenv pour la gestion des variables d'environnement sensibles.
Lien Codacy : https://app.codacy.com/gh/Orcryx/Blog/dashboard 

## Table des matières

1. [Prérequis](#prérequis)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Utilisation](#utilisation)
5. [Structure du projet](#structure-du-projet)
6. [Documentation](#documentation)

**Prérequis : **

-   PHP version 8.3.4 : Le projet est compatible avec PHP8.
-   composer version 2.7.2 : Assurez-vous que Composer est installé pour gérer les dépendances.
-   twig version 3.8.0
-   **MySQL** : Version recommandée : 8.0.19 ou plus récent.
-   **Serveur local** : Apache ou un serveur équivalent pour exécuter l’application en local.

## Installation

1. **Cloner le dépôt** : Clonez ce dépôt sur votre machine locale.
2. Accéder au dossier du projet :
    - cd blog
3. Installer les dépendances avec Composer :
    - composer install

## Configuration

1. Configuration de l'environnement :
   Créez un fichier .env.dev à la racine du projet pour les variables d'environnement. Ce fichier est crucial pour sécuriser les données sensibles (comme les identifiants de la base de données).

-   Exemple de fichier .env.dev :
    DB_HOST=localhost
    DB_NAME=blog
    DB_USER=root
    DB_PASS=password

2. Configuration de la base de données :
   Importez le fichier de base de données se trouvant dans document/blog.sql pour créer la structure et les données initiales nécessaires.

3. Autoloading :
   Assurez-vous que Composer génère correctement l’autoload avec PSR-4 pour le namespace App.

## Utilisation

Pour exécuter le projet, démarrez votre serveur local (Apache, Nginx, ou un serveur intégré comme celui de PHP) et accédez à l’index de l'application.
Accédez à l’application dans votre navigateur via http://localhost:3000.

## Structure du projet

Voici un aperçu de la structure du projet :

.

├── src/ # Dossier principal de l'application PHP

├── public/ # Dossier public accessible par le serveur web

├── views/ # Templates Twig

├── documentation/ # Documentation, UML, bdd
