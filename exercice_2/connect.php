<?php

// Bien vérifier ici que le nom de base de données correspond,
// mais également le nom d'utilisateur et mot de passe
// Attention : dans mon cas AMPPS fonctionne avec le mot de passe 'mysql' (à adapter selon les cas, 'root' ou '')
$db = new PDO('mysql:host=localhost;dbname=userslist;charset=utf8', 'root', 'mysql');