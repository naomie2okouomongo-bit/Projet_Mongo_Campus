# 🎓 Campus Marketplace — Application Web PHP & MongoDB

---

# 📌 1. Présentation du projet

Campus Marketplace est une application web développée en **PHP** utilisant **MongoDB** comme base de données NoSQL.

L’objectif de cette application est de permettre aux étudiants d’un campus universitaire de :

- Créer un compte utilisateur
- Se connecter et se déconnecter
- Publier des annonces (livres, matériel, services…)
- Modifier ou supprimer leurs annonces
- Consulter les annonces des autres étudiants
- Réserver des annonces

Ce projet met en pratique :

- L’intégration d’une base NoSQL avec PHP
- La gestion des relations entre collections MongoDB
- L’implémentation d’un CRUD complet
- La gestion des sessions et de l’authentification
- Une architecture propre et organisée
- L’utilisation professionnelle de Git et GitHub

---

# 🏗️ 2. Architecture du projet

Structure du dossier :

Projet_Mongo/
│
├── public/                  → Racine web (accessible via navigateur)
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php
│   ├── market.php
│   ├── listing_new.php
│   ├── listing_edit.php
│   ├── listing_delete.php
│   ├── reservation.php
│   └── assets/
│       └── style.css
│
├── src/                     → Logique métier
│   ├── auth.php
│   ├── helpers.php
│
├── config.php               → Connexion MongoDB
├── composer.json
├── vendor/                  → Dépendances Composer
└── README.md

Le dossier public/ est isolé pour des raisons de sécurité.  
Seul ce dossier est exposé au navigateur.

---

# ⚙️ 3. Technologies utilisées

- PHP 8.x
- MongoDB Atlas
- Extension PHP MongoDB
- Composer
- HTML / CSS
- Git / GitHub

---

# 🗄️ 4. Base de données MongoDB

Base utilisée : campusdb

L’application repose sur plusieurs collections interconnectées.

---

## 📂 4.1 Collection : users

Contient les utilisateurs de l’application.

Structure type :

{
  "_id": ObjectId,
  "name": "Naomie",
  "email": "naomie@email.com",
  "password": "hash sécurisé",
  "createdAt": Date
}

Un utilisateur possède :
- un identifiant unique (_id)
- un nom
- un email unique
- un mot de passe hashé
- une date de création

---

## 📂 4.2 Collection : listings

Contient les annonces publiées par les utilisateurs.

{
  "_id": ObjectId,
  "userId": ObjectId,
  "title": "Livre Maths",
  "description": "Très bon état",
  "category": "Livres",
  "createdAt": Date
}

Chaque annonce contient :
- un identifiant unique
- un userId (référence vers l’utilisateur propriétaire)
- un titre
- une description
- une catégorie
- une date de création

---

## 📂 4.3 Collection : reservations

Contient les réservations effectuées par les utilisateurs.

{
  "_id": ObjectId,
  "listingId": ObjectId,
  "userId": ObjectId,
  "createdAt": Date
}

Chaque réservation contient :
- un identifiant
- un listingId (référence vers l’annonce)
- un userId (référence vers l’utilisateur)
- une date

---

# 🔗 5. Relations entre les collections

MongoDB étant une base NoSQL, les relations ne sont pas automatiques comme en SQL.  
Elles sont gérées manuellement via des références d’identifiants ObjectId.

---

## 🔁 Relation 1 : Users → Listings (1 à N)

Un utilisateur peut publier plusieurs annonces.

Relation logique :

users._id  → listings.userId

Cela signifie :
- Chaque document listing contient un champ userId
- Ce champ correspond à l’identifiant d’un utilisateur

Donc :

1 utilisateur peut avoir N annonces.

---

## 🔁 Relation 2 : Listings → Reservations (1 à N)

Une annonce peut être réservée plusieurs fois.

Relation :

listings._id → reservations.listingId

1 annonce peut avoir N réservations.

---

## 🔁 Relation 3 : Users → Reservations (1 à N)

Un utilisateur peut réserver plusieurs annonces.

Relation :

users._id → reservations.userId

1 utilisateur peut avoir N réservations.

---

# 📐 6. Modélisation simplifiée

Users
  │
  ├───< Listings
  │         │
  │         └───< Reservations
  │
  └─────────────< Reservations

Cette structure démontre :
- Une relation 1 → N entre users et listings
- Une relation 1 → N entre listings et reservations
- Une relation 1 → N entre users et reservations

---

# 🔧 7. Installation

## 1️⃣ Cloner le projet

git clone <URL_DU_REPO>
cd Projet_Mongo

---

## 2️⃣ Installer les dépendances

composer install

---

## 3️⃣ Configuration MongoDB

Aucune donnée sensible n’est stockée dans le code.

Les variables d’environnement suivantes doivent être définies :

- MONGODB_URI
- MONGODB_DB

Sous Windows (PowerShell) :

[Environment]::SetEnvironmentVariable("MONGODB_URI","mongodb+srv://USER:PASSWORD@cluster.mongodb.net", "User")
[Environment]::SetEnvironmentVariable("MONGODB_DB","campusdb", "User")

Redémarrer le terminal après configuration.

---

## 4️⃣ Lancer le serveur

php -S localhost:8000 -t public

Puis ouvrir dans le navigateur :

http://localhost:8000/login.php

---

# 🔐 8. Sécurité

- Mots de passe hashés avec password_hash
- Sessions PHP sécurisées
- require_once utilisé pour éviter les redéclarations
- Variables sensibles stockées en variables d’environnement
- Dossier public isolé pour sécurité

---

# 🧪 9. Tests unitaires

Les tests peuvent être exécutés via :

vendor/bin/phpunit

Les tests couvrent :
- Fonctions helpers
- Gestion des sessions
- Validation des données

---

# 🚀 10. Optimisations

- Séparation logique / affichage
- Architecture modulaire
- Centralisation des fonctions utilitaires
- Centralisation de l’authentification
- Gestion propre des erreurs
- Structure claire et maintenable

---

# 📊 11. Fonctionnalités

✔ Inscription  
✔ Connexion  
✔ Déconnexion  
✔ Création d’annonce  
✔ Modification d’annonce  
✔ Suppression d’annonce  
✔ Marketplace  
✔ Réservations  

---

# 📁 12. Gestion Git

Le projet respecte :

- Commits réguliers et structurés
- Messages explicites (feat, fix, docs…)
- Tag version v1.0.0
- .gitignore configuré
- Aucun mot de passe dans le repository

---

# 🎯 13. Objectif pédagogique

Ce projet démontre :

- L’intégration d’une base NoSQL avec PHP
- La gestion de relations entre collections MongoDB
- L’implémentation d’un système d’authentification
- Un CRUD complet
- Une architecture propre et sécurisée
- Une utilisation professionnelle de GitHub

---

# 👩‍💻 Auteur

Naomie  
Projet universitaire — No SQL
