# Hello CSE Test Technique

## Documentation

### Installation et commandes

_Pour installer le projet vous aurez besoin de Docker et de Docker Compose._

Pour installer le projet et le lancer il suffit d'utiliser la commande `make install`

Pour juste le lancer `make up`

Pour l'arrêter `make down`

Pour lancer les tests sur les Profiles `make test`

Pour lancer l'analyse du code via Larastan `make analyse`

### Routes

Utilisateur par défaut : - email : test@example.com - mot de passe : password

Authentification par défaut de Laravel Breeze (l'authentification par cookie)

-   Get /login : Page de connexion

Api :

-   GET /api/profile/all : Récupère les profils actifs et sans le statut pour les invités et tous les profils pour les administrateurs (les résultats sont paginés)

-   POST /api/profile/store : Crée un profil seulement pour les administrateurs

-   PATCH /api/profile/update : Modifie un profil seulement pour les administrateurs

-   DELETE /api/profile/delete/{id} : Supprime un profil seulement pour les administrateurs

Formulaires :

-   GET /profile/create : Formulaire de création de profil

-   GET /profile/update/{id} : Formulaire de modification de profil

Note : Le formulaire à un bug qui empêche l'upload de fichier. C'est un problème qui vient du front-end. Quand on upload une image le content-type passe de Json à multipart/form-data et l'id du formulaire n'est plus validé cotés back-end. Pour l'instant je n'ai pas trouvé de solution pour ce problème.

## Étapes et Réflexions

-   Mise en place du projet Laravel avec docker et sail. Pour plus de simplicité j'utilise l'installateur de base avec une base de données mysql.

-   Installation de Laravel Breeze pour la gestion de l'authentification

-   Modification du nom de la table User en Admnistrators (je ne l'ai pas appelé administrateur comme dans les consignes pour éviter le mélange du français et de l'anglais dans les noms)

-   Création de la migration et du modèle pour l'entité Profil. J'ai également ajouté un dossier Repository pour y stocker les requêtes liées aux entités. (Je n'ai juste pas touché au controller par défaut pour gagner du temps je l'aurai sans doute fait dans une vraie application pour plus de clarté et de consistance)

Deux méthodes sont mises en place pour obtenir tous les profils : une pour les invités avec les limites prévues dans les consignes et une pour les administrateurs avec un accès complet. C'est le controller qui vérifiera si l'utilisateur est connecté ou non pour choisir la méthode à appeler.

-   Changement de nom du controller par défaut ProfileController en AdminProfilController pour distinguer la modification du profil des administrateurs et l'entité Profil que je viens de créer (même chose pour les request, pages, ...).

-   Création d'un ProfileCreateRequest pour valider les données du formulaire de création de profil et amélioration du typage des données dans la migration de l'entité Profil.

-   Pour le moment je ne m'occupe pas de l'upload de l'image de profil, je me concentre sur les fonctionnalités de base.

-   Mise en place des routes pour l'API des profils : leurs noms et leur chemin débutent par "api" pour les distinguer des autres routes de l'application.

-   Déplacement des ProfileRequest dans un dossier spécifique pour un meilleur rangement.

-   Création d'un formulaire pour la création de profil et pour la modification de profils. J'ai utilisé les composants de Laravel Breeze pour la gestion des formulaires.

-   Créations de tests pour vérifier le bon fonctionnement des routes et des méthodes.

-   J'étudie le problème de l'envoi des images pour les profils. Pour faire ceci, je vais stocker les images en locale et de stocker le chemin de l'image dans la base de données.

-   Dans une vraie application il serait mieux d'avoir un serveur dédié pour le stockage de fichier.

-   J’ajoute des règles pour l'upload des images dans les FormRequest pour éviter les abus et sécuriser l'application.

-   Pour sauvegarder les images localement j'utilise la fonction putFile qui permet de streamer le fichier et de le sauvegarder en local de manière plus efficace.

-   Lorsque nous récupérons les profils nous renvoyons également le lien de l'image de profil. Pour cela j'utilise la fonction url de storage sur tous les éléments renvoyé(plus pratique pour l'affichage des fichiers depuis une API).

-   Pour limiter le nombres d'opérations faites en une fois j'ai paginé les profils renvoyés.

-   Écriture d'un test pour vérifier le fonctionnement de l'upload d'image et ajout de cette fonctionnalité au formulaire de création de profil.

-   On supprime les images lors de la suppression d'un profil ou d'une modification de l'image de profil (sauf pour l'image par défaut).

-   Ajout d'un makefile pour simplifier les commandes et l'Installation.

-   Ajout de Larastan pour vérifier la qualité du code et du typage.

## Améliorations

-   Améliorations des tests pour couvrir plus de cas.

-   Ajout d'un outil pour générer la documentation de l'api avec OpenApi.

-   Ajout de token Csrf pour sécuriser les formulaires.

-   Meilleure interface pour les formulaires.
