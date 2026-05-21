

````markdown
# Rapport d’audit API — API REST sécurisée Laravel

## 1. Contexte

Ce rapport présente un audit de sécurité basique réalisé sur une API REST Laravel.

L’objectif est de vérifier que les routes sensibles sont protégées, que les rôles sont respectés, que les erreurs sont correctement retournées et que l’API ne permet pas d’actions non autorisées.

## 2. Objectif de l’audit

L’audit vise à contrôler les points suivants :

1. L’accès aux routes protégées nécessite un token.
2. Un utilisateur non connecté ne peut pas accéder aux données protégées.
3. Un employé ne peut pas effectuer les actions réservées à l’administrateur.
4. Les données invalides sont rejetées.
5. Les ressources inexistantes retournent une erreur propre.
6. Les réponses API sont au format JSON.
7. Les fichiers sensibles ne sont pas envoyés sur GitHub.

## 3. Périmètre testé

Les routes concernées sont :

| Méthode | Route | Test |
|---|---|---|
| POST | `/api/register` | Création de compte |
| POST | `/api/login` | Connexion utilisateur |
| GET | `/api/profil` | Accès profil connecté |
| POST | `/api/logout` | Déconnexion |
| GET | `/api/produits` | Liste des produits |
| GET | `/api/produits/{id}` | Détail produit |
| POST | `/api/produits` | Création produit |
| PUT | `/api/produits/{id}` | Modification produit |
| DELETE | `/api/produits/{id}` | Suppression produit |

## 4. Comptes utilisés pour les tests

| Email | Rôle | Objectif |
|---|---|---|
| admin@ecobank.ci | admin | Tester les actions autorisées |
| employe@ecobank.ci | employe | Tester les restrictions de rôle |

Les mots de passe utilisés dans l’environnement de test ne doivent pas être réutilisés en production.

## 5. Test 1 — Inscription utilisateur

### Requête

```http
POST /api/register
````

### Résultat attendu

* Code HTTP : `201 Created`
* Création du compte réussie
* Retour d’un utilisateur
* Retour d’un token API

### Analyse

Ce test vérifie que l’API permet la création d’un compte et que les informations retournées sont correctes.

## 6. Test 2 — Connexion utilisateur

### Requête

```http
POST /api/login
```

### Résultat attendu

* Code HTTP : `200 OK`
* Connexion réussie
* Retour d’un token Sanctum

### Analyse

Ce test vérifie que seuls les identifiants valides permettent de générer un token d’accès.

## 7. Test 3 — Accès au profil avec token

### Requête

```http
GET /api/profil
Authorization: Bearer TOKEN_VALIDE
```

### Résultat attendu

* Code HTTP : `200 OK`
* Retour des informations de l’utilisateur connecté

### Analyse

Ce test confirme que le token permet d’accéder aux routes protégées.

## 8. Test 4 — Accès au profil sans token

### Requête

```http
GET /api/profil
```

### Résultat attendu

* Code HTTP : `401 Unauthorized`
* Message indiquant que l’utilisateur n’est pas authentifié

### Analyse

Ce test confirme que les routes protégées ne sont pas accessibles sans token.

### Risque évité

Sans cette protection, n’importe quel utilisateur pourrait accéder aux données internes.

## 9. Test 5 — Liste des produits avec token

### Requête

```http
GET /api/produits
Authorization: Bearer TOKEN_VALIDE
```

### Résultat attendu

* Code HTTP : `200 OK`
* Retour de la liste des produits

### Analyse

Ce test vérifie que les utilisateurs authentifiés peuvent consulter les produits.

## 10. Test 6 — Création de produit avec rôle admin

### Requête

```http
POST /api/produits
Authorization: Bearer TOKEN_ADMIN
```

### Exemple de body

```json
{
  "nom": "Crédit Immobilier",
  "description": "Financement achat immobilier Abidjan",
  "type": "credit",
  "taux_interet": 7.5,
  "duree_mois": 120,
  "montant_min": 10000000
}
```

### Résultat attendu

* Code HTTP : `201 Created`
* Produit créé avec succès

### Analyse

Ce test confirme que l’administrateur peut créer un produit.

## 11. Test 7 — Création de produit avec rôle employé

### Requête

```http
POST /api/produits
Authorization: Bearer TOKEN_EMPLOYE
```

### Résultat attendu

* Code HTTP : `403 Forbidden`
* Message d’accès interdit

### Analyse

Ce test vérifie que la séparation des rôles fonctionne correctement.

### Risque évité

Un utilisateur simple ne doit pas pouvoir créer, modifier ou supprimer des produits sensibles.

## 12. Test 8 — Données invalides

### Requête

```http
POST /api/produits
Authorization: Bearer TOKEN_ADMIN
```

### Exemple de body invalide

```json
{
  "nom": "",
  "type": "invalide"
}
```

### Résultat attendu

* Code HTTP : `422 Unprocessable Entity`
* Retour des erreurs de validation

### Analyse

Ce test confirme que l’API refuse les données incorrectes.

### Risque évité

La validation protège la base de données contre les valeurs incohérentes ou incomplètes.

## 13. Test 9 — Modification de produit

### Requête

```http
PUT /api/produits/{id}
Authorization: Bearer TOKEN_ADMIN
```

### Résultat attendu

* Code HTTP : `200 OK`
* Produit modifié avec succès

### Analyse

Ce test vérifie que seul l’administrateur peut modifier les produits.

## 14. Test 10 — Suppression de produit

### Requête

```http
DELETE /api/produits/{id}
Authorization: Bearer TOKEN_ADMIN
```

### Résultat attendu

* Code HTTP : `200 OK`
* Produit supprimé avec succès

### Analyse

Ce test vérifie que la suppression est protégée et limitée à l’administrateur.

## 15. Test 11 — Ressource inexistante

### Requête

```http
GET /api/produits/999
Authorization: Bearer TOKEN_VALIDE
```

### Résultat attendu

* Code HTTP : `404 Not Found`
* Message indiquant que la ressource est introuvable

### Analyse

Ce test vérifie que l’API retourne une erreur propre lorsqu’un produit n’existe pas.

## 16. Vérification GitHub

Les fichiers sensibles ne doivent pas être publiés.

Éléments à exclure :

```text
ecobank-api/.env
ecobank-api/vendor/
ecobank-api/node_modules/
ecobank-api/storage/logs/
ecobank-api/bootstrap/cache/
```

Le fichier `.gitignore` doit empêcher leur publication.

## 17. Résumé des contrôles

| Contrôle                       | Résultat attendu |
| ------------------------------ | ---------------- |
| Accès sans token               | Refusé           |
| Accès avec token valide        | Autorisé         |
| Action admin avec rôle admin   | Autorisée        |
| Action admin avec rôle employé | Refusée          |
| Données invalides              | Refusées         |
| Ressource inexistante          | Erreur 404       |
| Fichier `.env` sur GitHub      | Absent           |
| Dossier `vendor/` sur GitHub   | Absent           |

## 18. Recommandations

Pour renforcer davantage la sécurité de l’API, il est recommandé de :

1. Ne jamais publier le fichier `.env`.
2. Utiliser des mots de passe forts.
3. Limiter les rôles selon le principe du moindre privilège.
4. Mettre en place une limitation de requêtes contre les abus.
5. Journaliser les actions sensibles.
6. Utiliser HTTPS en production.
7. Ne pas afficher les détails techniques des erreurs en production.
8. Ajouter des tests automatisés Laravel.
9. Utiliser des politiques ou gates Laravel pour les autorisations complexes.
10. Documenter toutes les routes API.

## 19. Conclusion

L’audit montre que l’API est conçue pour respecter les principes de base de la sécurité applicative : authentification, contrôle d’accès, validation et réponses d’erreurs propres.

Ce projet démontre une compréhension des risques fréquents liés aux API REST et une capacité à mettre en place des protections adaptées avec Laravel Sanctum.

```
```
