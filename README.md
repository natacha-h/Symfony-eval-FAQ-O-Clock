# FAQ-O-Clock

Exercice d'évaluation réalisé à la fin de la spécialisation **Symfony**, en suivant les objectifs et contraintes suivantes :

## Objectif

Être capable de développer un site de type [Quora](https://www.quora.com/) ou  [StackOverflow](https://stackoverflow.com). Ce site :

- liste des **questions**  et plusieurs **réponses**.
- permet aux **visiteurs** de créer un compte, ils deviennent alors des **utilisateurs**.
- permet **uniquement** aux **utilisateurs inscrits (et identifiés)** de **poser des questions** et de **répondre à des questions**.
- en revanche, **tout le monde** peut consulter les contenus

## Structure du site

### Tous les visiteurs ont accès à :

- **Accueil** : affiche toutes les questions, les plus récentes d'abord
- **Question** : affiche la question et toutes ses réponses,
- **Inscription** (formulaire),
- **Connexion** (formulaire de login).

### Seuls les utilisateurs identifiés peuvent accéder :

- au formulaire pour **Poser une question**
- un formulaire permettant d'**Ajouter une réponse** (directement dans la page d'une **Question**)
- à un bouton permet de valider une réponse (situé dans la liste des réponses), mais  **seul l'utilisateur qui est l'auteur d'une question** peut indiquer une réponse comme étant **valide** . La réponse validée s'affiche distinctement et en premier dans la liste des réponses.
- à leur **Profil** : informations utilisateur, liste de ses questions et de ses réponses, avec un lien pour s'y rendre.
- Sur cette page, un lien **Modifier mon Profil** qui permet de modifier ses propres informations (au minimum username, email, mot de passe).

### Modération/Administration

Certains utilisateurs ont le statut de **modérateurs**. En tant que modératateurs, ils peuvent **bloquer une question ou une réponse** non-conforme à la charte du site. **Un admin peut donner les droits de modérateur à un utilisateur**.

- Sur la liste des questions (page Accueil) et sur la page des Questions/Réponses, **un bouton permet aux modérateurs de bloquer ou débloquer** une question ou une réponse. Une Question ou une Réponse bloquée ne s'affiche plus (ni dans les listes, ni en accès direct), **BONUS : sauf pour les modérateurs et les admins**.
- **L'Admin** a accès à une page **Admin users** lui permettant de changer le statut d'un utilisateur.

### Tags

Les questions peuvent être associées à plusieurs **tags** (mots-clé).

- l'admin et les modérateurs ont accès à la page **Admin tags**  qui leur permet d'administrer (création/modification/suppression) les tags.
- dans la page **Poser une Question**, il est possible de **choisir les tags associés à la question**.
- la _liste des questions (Accueil)_ et la _page Question_  **affichent les tags associés** à une question. **Un lien sur chaque tag** affiche les questions filtrées par tag et renvoie à la page _Question/Tag_.
- **La page Question/Tag** permet de consulter les questions associées à ce tag. Les **Tags** sont aussi accessibles depuis un nuage de tags sur la page d'accueil ou dans une sidebar.