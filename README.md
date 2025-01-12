

# Système de plate-forme de communication en ligne - Forum
## 📋 Contexte du projet
Vous travaillez au sein d'une web agency en tant que développeur-intégrateur web. Suite à la 
commande d’un client, vous vous occupez de la conception d'une plate-forme de communication en ligne de type forum.

## 🎯 Objectifs pédagogiques
Créer une interface utilisateur responsive et intuitive
Implémenter un CRUD complet (Create, Read, Update, Delete)
Gérer une base de données MySQL avec PHP
Utiliser JavaScript pour des interactions dynamiques
Pratiquer l'architecture MVC

## 📝 Consignes
### Fonctionnalités attendues :

- Critères de performance
- Code structuré selon le pattern MVC
- Validation des données côté client ET serveur
- Interface responsive (mobile first)
- Sécurisation des requêtes SQL (requêtes préparées)
- Code commenté et indenté

## 🔧 Technologies utilisées
Langages :
- HTML5 (structure sémantique)
- CSS3 (Flexbox/Grid, variables CSS)
- JavaScript (ES6+, fetch API)
- PHP 8 (POO, PDO)
- SQL (CRUD, JOIN)

Outils :
- VSCode
- XAMPP v3.3.0
- Git/GitHub
- HeidiSQL

## 💡 Concepts clés abordés

- HTML/CSS : 
  - Sémantique HTML5
  - Flexbox et Grid
  - Media queries
  - Variables CSS
  - JavaScript

- Gestion des formulaires
- PHP
- POO
- PDO et requêtes préparées
- Sessions
- Architecture MVC
- SQL

- CRUD
- Jointures
- Index
- Clés étrangères

## 📦 Installation et configuration
  \# Cloner le repository
git clone le [repo](https://github.com/alexandreleote/PHP_MVC_Forum.git) 


  \# Configuration de la base de données
1. Démarrer XAMPP (Apache et MySQL)
2. Accéder à PhpMyAdmin (http://localhost/phpmyadmin)
3. Créer une nouvelle base de données 'forum_alexandre'
4. Importer le fichier database/forum_alexandre.sql

  \# Configuration du projet
1. Copier config.example.php vers config.php
2. Modifier les informations de connexion dans config.php :<br>
   define('DB_HOST', 'localhost');<br>
   define('DB_NAME', 'forum_alexandre');<br>
   define('DB_USER', 'root');<br>
   define('DB_PASS', '');<br>
   
## 🚀 Structure du projet

```
PHP_MVC_Forum/<br>
├── Database/
|   └── forum_alexandre.sql
├── app/
|   ├── AbstractController.php
|   ├── Autoloader.php
|   ├── ControllerInterface.php
|   ├── DAO.php
|   ├── Entity.php
|   ├── Manager.php
|   └── Session.php
├── controller/
|   ├── ForumController.php
|   ├── HomeController.php
|   └── SecurityController.php
├── model/
|   ├── entities/
|   |   ├── Category.php
|   |   ├── Post.php
|   |   ├── Topic.php
|   |   └── User.php
|   └── managers/
|       ├── CategoryManager.php
|       ├── PostManager.php
|       ├── TopicManager.php
|       └── UserManager.php
├── public/
|   ├── css/
|   |   └── style.css
|   ├── img/
|   |   └── bg-forum.jpg
|   └── js/
|       └── script.js
├── view/
|   ├── forum/
|   |   ├── listCategories.php
|   |   ├── listMessages.php
|   |   └── listTopics.php
|   ├── security/
|   |   ├── login.php
|   |   ├── profile.php
|   |   └── register.php
|   ├── home.php
|   └── layout.php
├── README.md
└── index.php
```

## ✨ Démonstration
Captures d'écran<br>
Bientôt affichées<br>


## 📚 Ressources
Documentation officielle
- [PHP](https://www.php.net/)
- [W3Schools](https://www.w3schools.com/)
- [MDN](https://developer.mozilla.org/fr/)
- [StackOverflow](https://stackoverflow.com/)

## 🏆 Compétences visées
- Développer une application web complète
- Mettre en place une architecture MVC
- Gérer les interactions utilisateur
- Manipuler une base de données
- Sécuriser une application web
___
Exercice réalisé dans le cadre de la formation [Développeur Web et Web Mobile](https://elan-formation.fr/formation/19754)
📅 Date : 09/12/2024 - en cours
✍️ Auteur : [Alexandre Leote](https://github.com/alexandreleote)
