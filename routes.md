# Routes

| URL | Titre | Description de la page | Méthode HTTP | Controller | Méthode | commentaire |
|-----|-------|------------------------|--------------|------------|---------|-------------|
| `/` | Accueil | affiche toutes les questions (ORDER BY CREATED AT ASC) + les tags associés à la question | GET | QuestionController | index |  |
| `/question/{id}` | Question {titre de la question} | affiche une question et toutes les réponses / Affiche les tags associés à la question (+ lien) | GET | QuestionController | show | (id= identifiant de la question) |
| `/question/new` |  Poser une question |  formulaire + choix des tags associés | POST | QuestionController | new | |
| `/question/{id}/answer` | Question {titre de la question} | formulaire permettant de répondre à la question | POST | AnswerController | new | (id= identifiant de la question) **uniquement visible par les utilisateurs loggés** |
| `/login` | Connexion | Formulaire de connexion | GET/POST | SecurityController | login |  |
| `/user/{id}/profile` | Mon profil | Affiche le profil du user, ses questions, ses réponses (liens pour les voir| GET | UserController | show | (id= identifiant du user) |
| `/user/{id}/edit` | Modifier mon profil | formulaire permettant au user de modifier username, email et password | POST | UserController | edit | (id= identifiant du user) |
| `/register` | Inscription | formulaire d'inscription, enregistrement en BDD (new user) | GET/POST | UserController | new |  |
| `/admin/tags` | Tags | Gestion des tags | GET/POST | TagController | list | **réservé aux roles admin et modo**  |
| `/admin/tags/new` | Tags | Gestion des tags/ajout | POST | TagController | new | **réservé aux roles admin et modo**  |
| `/admin/tags/{id}/edit` | Tags | Gestion des tags/modification | POST | TagController | edit | **réservé aux roles admin et modo**  (id= identifiant du tag)|
| `/admin/tags/{id}/delete` | Tags | Gestion des tags/suppression | GET/DELETE | TagController | delete | **réservé aux roles admin et modo**  (id= identifiant du tag)|
| `/tags/{id}/questions` | Question/Tag | Affiche les questions associées au tag | GET | TagController | show |  (id= identifiant du tag)|
| `/admin/user` | Admin affichage des utilisateurs | Affiche la liste des utilisatuer pour l'admin | GET | UserController (backend)| index | **réservé aux roles admin**  |
| `/admin/user/{id}/status` | Admin gestion des status utilisateur | Change le status d'un user pour le passer modo | GET | UserController (backend)| changeStatus |  (id= identifiant du user) **réservé aux roles admin** |
| `/admin/answer/{id}/status` | Modo bloque/débloque une réponse | Change la visibilité d'une réponse | POST | AnswerController (backend)| changeStatus |  (id= identifiant de la réponse ) **réservé aux roles modo et admin** |
