-- Requête SQL pour afficher un article (id=10) et son auteur (nom et prénom)
-- On utilise la commande INNER JOIN en sélectionnant les tables "articles" et "users"
-- lorsque les données de la colonne "id_user" de la table articles est égal aux données de la colonne "id" de users

SELECT title, content, picture, date_publish, firstname, lastname
FROM articles
INNER JOIN users ON articles.id_user = users.id