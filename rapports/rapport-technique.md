````markdown
# Rapport technique — API REST sécurisée Laravel

## 1. Contexte du projet

Ce projet consiste à développer une API REST sécurisée avec Laravel dans un contexte inspiré d’une entreprise bancaire ou fintech à Abidjan.

L’objectif est de simuler une API interne permettant la gestion de produits financiers par des employés authentifiés. L’API doit gérer l’authentification, les rôles utilisateurs, la validation des données, les routes protégées et les réponses JSON propres.

Ce projet entre dans le cadre de la constitution d’un portfolio professionnel orienté développement backend, API REST, Laravel et cybersécurité applicative.

## 2. Scénario professionnel

Une entreprise souhaite moderniser son système de gestion interne de produits financiers.

Le responsable technique demande la création d’une API REST sécurisée permettant aux employés de consulter les produits, et aux administrateurs de créer, modifier ou supprimer ces produits.

L’API doit pouvoir être utilisée plus tard par une application mobile Flutter ou un dashboard web.

## 3. Objectifs techniques

Les objectifs du projet sont :

1. Installer et configurer un projet Laravel.
2. Configurer une base de données MySQL.
3. Mettre en place une authentification API avec Laravel Sanctum.
4. Gérer deux rôles utilisateurs : `admin` et `employe`.
5. Protéger les routes sensibles.
6. Créer un CRUD pour les produits financiers.
7. Valider les données entrantes.
8. Tester les routes avec Thunder Client ou Postman.
9. Produire une documentation technique et un rapport d’audit API.

## 4. Stack technique

| Technologie | Rôle |
|---|---|
| Laravel | Framework backend PHP |
| PHP | Langage backend |
| MySQL | Base de données |
| Laravel Sanctum | Authentification par token |
| Thunder Client / Postman | Test des routes API |
| Git / GitHub | Versioning et publication du projet |

## 5. Structure du projet

```text
api-laravel-securisee/
│
├── ecobank-api/
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
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
│   ├── routes/
│   ├── postman/
│   ├── roles/
│   ├── validation/
│   ├── burpsuite/
│   └── github/
│
├── rapports/
│   ├── rapport-technique.md
│   └── rapport-audit-api.md
│
├── thunder-client/
├── README.md
└── .gitignore
````

Le dossier `ecobank-api/` contient le projet Laravel.

Les dossiers `captures/` et `rapports/` servent à documenter le projet pour GitHub et le portfolio.

## 6. Configuration de l’environnement

Le projet Laravel est configuré avec une base de données MySQL.

Exemple de configuration dans `.env` :

```env
APP_NAME=Ecobank-API
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecobank_api
DB_USERNAME=root
DB_PASSWORD=
```

Le fichier `.env` ne doit pas être envoyé sur GitHub car il peut contenir des informations sensibles.

## 7. Base de données

La base de données utilisée est :

```text
ecobank_api
```

Les principales tables attendues sont :

```text
users
produits
personal_access_tokens
```

La table `users` stocke les utilisateurs et leurs rôles.

La table `produits` stocke les produits financiers.

La table `personal_access_tokens` est utilisée par Laravel Sanctum pour gérer les tokens API.

## 8. Authentification

L’authentification est assurée avec Laravel Sanctum.

Les fonctionnalités d’authentification prévues sont :

| Méthode | Route           | Description                 |
| ------- | --------------- | --------------------------- |
| POST    | `/api/register` | Créer un compte             |
| POST    | `/api/login`    | Se connecter                |
| POST    | `/api/logout`   | Se déconnecter              |
| GET     | `/api/profil`   | Afficher le profil connecté |

Lors de la connexion, l’API retourne un token.

Ce token doit ensuite être envoyé dans les headers des requêtes protégées :

```http
Authorization: Bearer TOKEN_ICI
Accept: application/json
```

## 9. Gestion des rôles

Deux rôles sont utilisés :

| Rôle    | Permissions                                          |
| ------- | ---------------------------------------------------- |
| admin   | Consulter, créer, modifier et supprimer les produits |
| employe | Consulter uniquement les produits                    |

Le rôle `admin` permet d’effectuer toutes les actions sur les produits.

Le rôle `employe` est limité à la consultation.

Cette séparation permet de protéger les actions sensibles de l’API.

## 10. Gestion des produits

L’API permet la gestion de produits financiers.

Exemple de champs utilisés :

| Champ        | Description                                  |
| ------------ | -------------------------------------------- |
| nom          | Nom du produit                               |
| description  | Description du produit                       |
| type         | Type de produit : credit, epargne, placement |
| taux_interet | Taux d’intérêt                               |
| duree_mois   | Durée en mois                                |
| montant_min  | Montant minimum                              |
| actif        | Statut du produit                            |

Routes principales :

| Méthode | Route                | Rôle            |
| ------- | -------------------- | --------------- |
| GET     | `/api/produits`      | admin / employe |
| GET     | `/api/produits/{id}` | admin / employe |
| POST    | `/api/produits`      | admin           |
| PUT     | `/api/produits/{id}` | admin           |
| DELETE  | `/api/produits/{id}` | admin           |

## 11. Validation des données

L’API valide les données avant création ou modification d’un produit.

Exemples de règles :

* le nom est obligatoire ;
* le type doit être valide ;
* le taux d’intérêt doit être numérique ;
* la durée doit être un nombre entier ;
* le montant minimum doit être numérique ;
* les champs obligatoires ne doivent pas être vides.

En cas d’erreur de validation, l’API retourne une réponse HTTP `422`.

## 12. Tests API

Les tests sont réalisés avec Thunder Client ou Postman.

Tests principaux :

1. Création d’un compte administrateur.
2. Connexion administrateur.
3. Récupération du profil avec token.
4. Accès au profil sans token.
5. Liste des produits.
6. Création d’un produit avec un token admin.
7. Création d’un produit avec un token employé.
8. Erreur de validation.
9. Modification d’un produit.
10. Suppression d’un produit.
11. Déconnexion.

## 13. Codes HTTP attendus

| Code | Signification         |
| ---- | --------------------- |
| 200  | Requête réussie       |
| 201  | Ressource créée       |
| 401  | Non authentifié       |
| 403  | Accès interdit        |
| 404  | Ressource introuvable |
| 422  | Erreur de validation  |
| 500  | Erreur serveur        |

## 14. Sécurité appliquée

Les mesures de sécurité appliquées ou prévues sont :

* authentification par token ;
* routes protégées avec middleware `auth:sanctum` ;
* séparation des rôles `admin` et `employe` ;
* validation des données ;
* non-publication du fichier `.env` ;
* non-publication du dossier `vendor/` ;
* réponses JSON propres ;
* tests des accès non autorisés.

## 15. Résultats attendus

À la fin du projet, l’API doit permettre :

* l’inscription d’un utilisateur ;
* la connexion d’un utilisateur ;
* la génération d’un token Sanctum ;
* l’accès aux routes protégées avec token ;
* le refus d’accès sans token ;
* le refus d’accès à un employé sur les actions admin ;
* la gestion complète des produits financiers ;
* la validation des erreurs ;
* la documentation complète sur GitHub.

## 16. Compétences démontrées

Ce projet démontre les compétences suivantes :

* développement backend avec Laravel ;
* création d’une API REST ;
* utilisation de Laravel Sanctum ;
* gestion des rôles utilisateurs ;
* validation des données ;
* sécurisation des routes API ;
* tests avec Thunder Client ou Postman ;
* organisation d’un dépôt GitHub ;
* rédaction de documentation technique.

## 17. Conclusion

Ce projet montre la capacité à concevoir une API REST sécurisée avec Laravel, à gérer l’authentification par token, à protéger les routes sensibles, à appliquer une logique de rôles et à tester les comportements attendus d’une API.

Il constitue une preuve pratique de compétences backend Laravel et sécurité applicative pour un profil développeur junior ou stagiaire.

```
```
