Dépôt contenant le code source du projet tutoré du troisième semestre.

* La liste des problèmes détectés et à corriger est située [ici](https://git.iut-orsay.fr/dimitri.de-roeck/projet_tutore_web/-/issues).
* La liste des choses à faire pour compléter le projet se trouve [ici](https://git.iut-orsay.fr/dimitri.de-roeck/projet_tutore_web/-/requirements_management/requirements).

# Langages et outils utilisés
* [PHP](https://fr.wikipedia.org/wiki/PHP) dans la dernière version de PHP 7 (7.4.14).
* [MariaDB](https://fr.wikipedia.org/wiki/MariaDB) sera le SGBD utilisé car ce SGBD est 100% open-source, plus performant et moins buggé que [MySQL](https://fr.wikipedia.org/wiki/MySQL).
* Git, pour le *versionning*, notamment par l'intermédiaire du GitLab hébergé sur les serveurs de l'IUT.
* [Modoco](http://mocodo.wingi.net/) pour la modélisation de la base de données.

# Présentation
Dans le cadre du projet tutoré de S3, nous vous proposons de réaliser une application reposant sur les connaissances (en IHM, BD, Programmation web...) et les technologies vues au cours du semestre et des semestres précédents (HTML, JavaScript, PHP, SQL) permettant de créer une application web.

La conception et réalisation sera séparée en deux sous-parties, durant les modules de base de Bases de Données Avancée, puis de Programmation Web et avec différents rendus/livrables (rapport, codes, démo, ...) qui feront l'objet d'évaluations spécifiques dans chaque module. Les notes dans chaque matière seront ensuite agrégées (moyenne) pour donner la note finale de projet tutoré de S3.  Le projet devra s’effectuer en binômes, identiques dans les deux modules concernés. Les membres du binôme doivent appartenir au même TP. Par ailleurs, les étudiants au départ pour effectuer leur S4 à l’étranger doivent se binômer entre eux. Cette application devra répondre à toutes les exigences d’une application professionnelle, tant en termes de fonctionnement, d’ergonomie, que de qualité de développement ou de finition.

## Description de la problématique
En ces temps de confinement, vous voulez rendre service à votre voisin qui est un producteur bio, qui veut faire profiter des gens autour de lui de sa production, en ajoutant un service de livraison à domicile. Vous lui proposez de développer un service web dans ce sens.
Après discussion avec le producteur, vous décidez que les gens peuvent :
- demander une livraison hebdomadaire d’un panier complet qui sera constitué au gré des saisons, il correspondra à un nombre de personnes, avec éventuellement une limite de prix (attention à préciser le jour!),
- demander la livraison d’une liste de fruits et légumes ponctuelle;
- plusieurs voisins peuvent se réunir pour faire une commande groupée.

Attention, vous ne pouvez pas vous permettre de faire des livraisons en-dessous d’un certain prix.

## Les utilisateurs
Tout le monde peut créer un compte sur la plateforme web, afin d’avoir des livraisons. Le producteur doit gérer ses stocks de produits, et préparer les livraisons.  Les clients peuvent passer des commandes de livraison, comme décrit ci-dessus.

## Les fonctionnalités de l’application
### Création d’un compte client
Il faut créer des clients, avec toutes les informations nécessaires pour leur rendre les services voulus : leur adresse, ce qu’ils ont choisi comme service (type de livraison, ...), leur quartier, etc.

### Gestion de livraison hebdomadaire
Quand on choisit la livraison hebdomadaire, alors on aura un panier complet qui sera constitué au gré des saisons, il correspondra à un nombre de personnes, avec éventuellement une limite de prix (attention à préciser le jour !).

### Gestion de livraison ponctuelle
On peut aussi ne demander que la livraison d’une liste de fruits et légumes ponctuelle.

### Gestion de livraison groupée
Pour aider les livraisons, et éventuellement permettre de passer outre la limite inférieure d’une livraison, plusieurs voisins peuvent se réunir pour faire une commande groupée.

## Pour aller plus loin
La version très minimale du projet consiste donc à traiter ces aspects. Ensuite, vous pourrez choisir de développer un ou plusieurs éléments complémentaires dans ce projet :
- Améliorer le service en proposant des produits de substitution quand vous ne pouvez pas livrer le produit demandé (par exemple des butternuts à la place de potimarrons , des reinettes à la place de goldens, ...)
- Permettre de varier les conditions de livraison : permettre de faire des rythmes de livraison plus variés (2 fois par semaine, ou au contraire, toutes les deux semaines, etc.), ou encore de faire des livraisons groupées, pour les gens qui commandent peu, voire de les proposer si vous connaissez la zone de livraison,
- Proposer des promotions, en cas de stock trop importants de certains produits
Vous avez donc des possibilités d’amélioration nombreuses, à vous de choisir ce qui vous paraît le plus utile !

## Les contraintes de l’application
Il est important de noter que les utilisateurs ne sont pas nécessairement familiers avec l‘informatique. L’interface doit être pensée pour être la plus efficace possible, pour rapidement effectuer toutes les fonctionnalités de l’application. De plus, l’application web doit être utilisable sur n’importe quel terminal mobile comme sur ordinateur de bureau classique. Vous devez fournir un code professionnel, modulaire, évolutif, et facilement maintenable, c’est la raison pour laquelle il est demandé que vous suiviez une approche modèle-vue-contrôleur, de la conception à l’implémentation. Ainsi, le modèle étant la base de données, il s’agira côté programmation web de séparer tout ce qui est fonctionnel (requête dans les scripts PHP par exemple) dans une couche contrôleur qui fera le lien avec ce qui relève de la présentation à l’utilisateur dans la couche vue (vue, formulaire, CSS, aspect graphique et interactif).

Pour finir, l’accès à l’application pour chaque utilisateur devra être sécurisé par un identifiant et un mot de passe, validés par e-mail au moment de l’ajout de chaque utilisateur.
Pour les aspects bases de données, il faut donc réfléchir à :
- la modélisation des produits : fruits, légumes, organisés en famille (pour proposer des substituts), avec - la modélisation des clients, avec des notions de quartier,
- la modélisation des livraisons,

Et probablement à d’autres aspects que vous pourrez proposer ! Par exemple proposer un mode de transport pour les livraisons (si pas trop lourd, en vélo ?).

Pour la partie programmation web, il faudra faire l’interface pour les clients.

# Crédits images récupérées
* [Page d'accueil](https://dribbble.com/shots/10864467-Picnic-basket/attachments/2519886?mode=media)
* [Écran de connexion](https://unsplash.com/photos/xMh_ww8HN_Q)
* [Carottes](https://unsplash.com/photos/uidpH617Fb8)
* [Épinards](https://unsplash.com/photos/hlC6OwRSQFs)