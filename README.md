# Blog OCR PHP - Projet

Ce projet est une application de blog construite en PHP8 sans framework. Il utilise Twig pour les templates, PHPMailer pour l'envoi d'emails, et PHP Dotenv pour la gestion des variables d'environnement sensibles.
Lien Codacy : https://app.codacy.com/gh/Orcryx/Blog/dashboard

## Table des matières

1. [Prérequis](#prérequis)
2. [Configuration](#configuration)
3. [Installation](#installation)
4. [Utilisation](#utilisation)
5. [Structure du projet](#structure-du-projet)
6. [Documentation](#documentation)

**Prérequis : **

-   PHP version 8.3.4 : Le projet est compatible avec PHP8.
-   composer version 2.7.2 : Assurez-vous que Composer est installé pour gérer les dépendances.
-   twig version 3.8.0
-   **MySQL** : Version recommandée : 8.0.19 ou plus récent.
-   **Serveur local** : Apache ou un serveur équivalent pour exécuter l’application en local.

## Configuration

1. Configuration de l'environnement :
   Créez un fichier .env.dev à la racine du projet pour les variables d'environnement. Ce fichier est crucial pour sécuriser les données sensibles (comme les identifiants de la base de données).

-   Exemple de fichier .env.dev :
    DB_HOST=localhost
    DB_NAME=blog
    DB_USER=root
    DB_PASS=password
    MAIL_PASS
    MAIL_USER
    MAIL_HOST
    MAIL_ADRESS

<<<<<<< HEAD
Documentation : https://github.com/vlucas/phpdotenv

2. Configuration de la base de données :
    - Créer une base de données SQL nommée "blog" (par exemple avec DBeaver)
    - Importez le fichier de base de données se trouvant dans document/blog.sql pour créer la structure et les données initiales nécessaires.
=======
Documentation : https://github.com/vlucas/phpdotenv 

2. Configuration de la base de données :
   - Créer une base de données SQL nommée "blog" (par exemple avec DBeaver)
   - Importez le fichier de base de données se trouvant dans document/blog.sql pour créer la structure et les données initiales nécessaires.
>>>>>>> 873b333b2577f2dda7eaefb27d4fc356862521cf

## Installation

1. **Cloner le dépôt** : Clonez ce dépôt sur votre machine locale.
2. Accéder au dossier du projet :
    - cd blog
3. Installer les dépendances avec Composer :
    - composer install

## Utilisation

Pour exécuter le projet, démarrez votre serveur local (Apache, Nginx, ou un serveur intégré comme celui de PHP) et accédez à l’index de l'application.
Accédez à l’application dans votre navigateur via http://localhost:3000.
Utilisateur :

-   Admin
    -   ID : userAdminBlog@mailinator.com
    -   Mtp : oY4L4p3q
-   User
    -   ID : userBlog@mailinator.com
    -   Mtp : x5plex

## Structure du projet

Voici un aperçu de la structure du projet :

.

├── src/ # Dossier principal de l'application PHP

├── public/ # Dossier public accessible par le serveur web

├── views/ # Templates Twig

├── document/ # Diagramme, UML, bdd
