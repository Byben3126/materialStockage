# Projet de Gestion d'Articles

## Description

Ce projet est une application pour la gestion d'articles. Vous pouvez l'utiliser pour gérer des articles dans une base de données SQLite.

## Configuration

1. **Configuration de la Base de Données**

Avant de lancer le projet, vous devez configurer la connexion à la base de données. Modifiez le fichier `config.json` pour entrer vos paramètres de connexion.

> **Remarque :** Une base de données SQLite est fournie par défaut. Vous pouvez l'utiliser si cela convient à vos besoins.

## Installation et Lancement

1. **Installer les Dépendances**

Utilisez Composer pour installer les dépendances du projet :

```bash
composer install
```

2. **Créer la Base de Données**
Créez la base de données en utilisant la commande Doctrine :
```bash
symfony console doctrine:database:create
```

3. **Mettre à Jour le Schéma de la Base de Données**
Appliquez les migrations et mettez à jour le schéma de la base de données :
```bash
php bin/console doctrine:schema:update --force
```

4. **Démarrer le Serveur**
Lancez le serveur Symfony pour démarrer l'application :
```bash
symfony server:start
```

