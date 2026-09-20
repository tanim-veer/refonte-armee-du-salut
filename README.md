# Refonte du site de l'Armée du Salut

![PHP](https://img.shields.io/badge/PHP-8-777BB4) ![MySQL](https://img.shields.io/badge/MySQL-MariaDB-003545) ![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3)

> **Projet scolaire (SAE, BUT Informatique)** : maquette non officielle, sans lien avec l'Armée du Salut. Les données présentes dans la base sont fictives.

Proposition de refonte du site de l'Armée du Salut : nouvelle interface, pages dynamiques en PHP et back-office d'administration relié à une base MySQL.

**Démo en ligne :** https://tanim-veer.alwaysdata.net (back-office : `/admin/`, identifiants non publiés)

## Fonctionnalités

**Site public**
- Pages : accueil, qui sommes-nous, actions sociales, actualités, contact, devenir salarié, devenir bénévole
- Formulaire « Devenir bénévole » enregistré en base de données
- Design responsive (Bootstrap), navigation avec appel au don visible

**Back-office (`/SAE-S3/admin`)**
- Connexion sécurisée (sessions PHP, mots de passe hachés avec `password_hash`)
- Tableau de bord
- Gestion des bénévoles (ajout, recherche, filtre par ville, suppression)
- Gestion des missions et de leurs participants
- Gestion des partenaires
- Espace documents (envoi de fichiers avec liste blanche d'extensions)

## Stack

PHP · MySQL / MariaDB (PDO, requêtes préparées) · HTML5 · CSS3 · JavaScript · Bootstrap

## Installation en local

1. Installer un serveur local (XAMPP, WAMP ou Laragon) et lancer Apache et MySQL.
2. Cloner le dépôt dans le dossier racine du serveur (`htdocs` ou `www`) :
   ```bash
   git clone https://github.com/tanim-veer/refonte-armee-du-salut.git
   ```
3. Créer la base et importer le fichier SQL :
   ```sql
   CREATE DATABASE armee_du_salut CHARACTER SET utf8mb4;
   ```
   puis importer `SAE-S3/database/armee_du_salut.sql` (phpMyAdmin > Importer).
4. Ouvrir `http://localhost/refonte-armee-du-salut/SAE-S3/Page%20d'Acceuil/index.html`.
5. Back-office : `http://localhost/refonte-armee-du-salut/SAE-S3/admin/` (identifiant `admin`, mot de passe à définir ci-dessous).

### Mot de passe administrateur

Le mot de passe n'est pas publié dans le dépôt. Pour en définir un, générer un hash en PHP :

```bash
php -r "echo password_hash('votre_mot_de_passe', PASSWORD_DEFAULT);"
```

puis mettre à jour la table :

```sql
UPDATE admin_users SET password = '<hash>' WHERE username = 'admin';
```

### Mise en ligne

Copier `SAE-S3/config/db.local.example.php` en `db.local.php` (ignoré par git), y mettre les identifiants de l'hébergeur, importer le fichier SQL et envoyer les fichiers du dossier `SAE-S3`.

## Mon rôle

- Système de connexion et gestion de session du back-office
- Tableau de bord
- CRUD des bénévoles
- Intégration du front (page « Devenir bénévole » reliée à la base)
- Sécurisation avant publication : suppression d'un script de réinitialisation de mot de passe, restriction des types de fichiers envoyés, identifiants de base de données hors du dépôt

## L'équipe

- **Tanim Veer** : [@tanim-veer](https://github.com/tanim-veer)
- **Osman Sobe** : [@bvantrikot](https://github.com/bvantrikot)
- **Titouan Le Neun** : [@Titouan2005](https://github.com/Titouan2005)
- **Maxence Amalfi** : [@maxenceamlf](https://github.com/maxenceamlf)
