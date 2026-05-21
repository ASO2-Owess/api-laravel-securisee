# API REST Sécurisée — Laravel Sanctum

## Description

Ce projet est une API REST sécurisée développée avec Laravel.  
Elle simule une API interne utilisée dans un contexte d’entreprise, de fintech ou de gestion de produits/services.

L’objectif est de mettre en place une API professionnelle avec authentification, rôles utilisateurs, routes protégées, validation des données et tests avec un outil API comme Postman ou Thunder Client.

Ce projet fait partie de mon portfolio orienté développement backend, API REST, Laravel et cybersécurité applicative.

---

## Scénario professionnel

Une entreprise souhaite moderniser son système de gestion interne.  
Le responsable technique demande la création d’une API sécurisée permettant aux employés de gérer des produits ou services depuis différentes applications : mobile, web ou dashboard.

L’API doit permettre :

- la création de comptes utilisateurs ;
- la connexion sécurisée par token ;
- la gestion des rôles ;
- la protection des routes sensibles ;
- la gestion des produits ;
- la validation des données ;
- les tests de sécurité de base.

---

## Technologies utilisées

- Laravel
- PHP
- MySQL
- Laravel Sanctum
- API REST
- Postman / Thunder Client
- Git & GitHub

---

## Fonctionnalités prévues

### Authentification

- Inscription utilisateur
- Connexion utilisateur
- Déconnexion
- Récupération du profil connecté
- Génération de token API avec Laravel Sanctum

### Gestion des rôles

Deux rôles sont prévus :

| Rôle | Permissions |
|---|---|
| admin | Créer, modifier, supprimer et consulter les produits |
| employe | Consulter uniquement les produits |

### Gestion des produits

L’API permet de gérer des produits avec les actions suivantes :

- lister les produits ;
- afficher un produit ;
- créer un produit ;
- modifier un produit ;
- supprimer un produit.

### Sécurité

L’API doit gérer :

- les routes protégées par token ;
- les accès non autorisés ;
- les erreurs de validation ;
- les permissions selon les rôles ;
- les réponses JSON propres.

---

## Structure du projet

```text
api-laravel-securisee/
│
├── ecobank-api/
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── tests/
│   ├── composer.json
│   └── artisan
│
├── captures/
│   ├── installation/
│   ├── database/
│   ├── auth/
│   ├── roles/
│   ├── products/
│   ├── thunder-client/
│   └── github/
│
├── rapports/
│   ├── rapport-technique.md
│   └── rapport-audit-api.md
│
├── thunder-client/
│
├── README.md
└── .gitignore
````

---

## Installation du projet

### 1. Cloner le dépôt

```bash
git clone https://github.com/ASO2-Owess/api-laravel-securisee.git
cd api-laravel-securisee
```

### 2. Entrer dans le projet Laravel

```bash
cd ecobank-api
```

### 3. Installer les dépendances PHP

```bash
composer install
```

### 4. Copier le fichier d’environnement

```bash
copy .env.example .env
```

Sous Linux/Mac :

```bash
cp .env.example .env
```

### 5. Générer la clé Laravel

```bash
php artisan key:generate
```

### 6. Configurer la base de données

Dans le fichier `.env`, configurer :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_laravel_securisee
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Lancer les migrations

```bash
php artisan migrate
```

### 8. Lancer le serveur Laravel

```bash
php artisan serve
```

L’API sera disponible sur :

```text
http://127.0.0.1:8000
```

---

## Routes API prévues

### Authentification

| Méthode | Route           | Description             | Accès       |
| ------- | --------------- | ----------------------- | ----------- |
| POST    | `/api/register` | Créer un compte         | Public      |
| POST    | `/api/login`    | Se connecter            | Public      |
| GET     | `/api/profile`  | Voir le profil connecté | Authentifié |
| POST    | `/api/logout`   | Se déconnecter          | Authentifié |

### Produits

| Méthode | Route                | Description          | Accès       |
| ------- | -------------------- | -------------------- | ----------- |
| GET     | `/api/products`      | Lister les produits  | Authentifié |
| GET     | `/api/products/{id}` | Voir un produit      | Authentifié |
| POST    | `/api/products`      | Créer un produit     | Admin       |
| PUT     | `/api/products/{id}` | Modifier un produit  | Admin       |
| DELETE  | `/api/products/{id}` | Supprimer un produit | Admin       |

---

## Exemples de réponses attendues

### Connexion réussie

```json
{
  "message": "Connexion réussie",
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@example.com",
    "role": "admin"
  },
  "token": "token_api"
}
```

### Accès non autorisé

```json
{
  "message": "Non authentifié"
}
```

### Accès interdit

```json
{
  "message": "Accès interdit"
}
```

### Erreur de validation

```json
{
  "message": "Erreur de validation",
  "errors": {
    "email": [
      "L'adresse email est obligatoire."
    ]
  }
}
```

---

## Tests prévus

Les tests seront réalisés avec Postman ou Thunder Client.

Captures prévues :

```text
captures/auth/
captures/roles/
captures/products/
captures/thunder-client/
captures/database/
```

Tests à effectuer :

* inscription utilisateur ;
* connexion utilisateur ;
* récupération du profil ;
* création de produit avec admin ;
* tentative de création avec employé ;
* modification de produit ;
* suppression de produit ;
* accès sans token ;
* accès avec mauvais rôle ;
* validation des champs obligatoires.

---

## Rapports

Deux rapports seront ajoutés au projet :

```text
rapports/rapport-technique.md
rapports/rapport-audit-api.md
```

Le rapport technique expliquera :

* l’installation du projet ;
* la configuration de la base de données ;
* la structure Laravel ;
* les modèles, migrations, contrôleurs et routes ;
* les tests effectués.

Le rapport d’audit API expliquera :

* les routes protégées ;
* les tests sans token ;
* les tests avec rôle insuffisant ;
* les erreurs de validation ;
* les recommandations de sécurité.

---

## Compétences démontrées

* Développement backend Laravel
* Création d’API REST
* Authentification avec Sanctum
* Gestion des rôles
* Validation des données
* Protection des routes API
* Tests avec Postman / Thunder Client
* Documentation technique
* Organisation d’un projet GitHub

---

## Statut du projet

Projet en cours de développement.

Étapes prévues :

* [ ] Installation Laravel
* [ ] Configuration MySQL
* [ ] Installation Sanctum
* [ ] Authentification register/login/logout
* [ ] Ajout des rôles admin/employe
* [ ] CRUD produits
* [ ] Tests API
* [ ] Rapport technique
* [ ] Rapport d’audit API
* [ ] Publication finale sur GitHub

````

Après avoir collé ça, fais :

```cmd
git status
````
