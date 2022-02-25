<?php
require __DIR__ . '/Config.php';
require __DIR__ . '/DB_Connect.php';

/**
 * Commencez par importer le fichier sql live.sql via PHPMyAdmin.
 * 1. Sélectionnez tous les utilisateurs.
 * 2. Sélectionnez tous les articles.
 * 3. Sélectionnez tous les utilisateurs qui parlent de poterie dans un article.
 * 4. Sélectionnez tous les utilisateurs ayant au moins écrit deux articles.
 * 5. Sélectionnez l'utilisateur Jane uniquement s'il elle a écris un article ( le résultat devrait être vide ! ).
 *
 * ( PS: Sélectionnez, mais affichez le résultat à chaque fois ! ).
 */

$stm = DB_Connect::dbConnect()->prepare("
    SELECT * FROM user
");

$stm->execute();

echo "<pre>";
print_r($stm->fetchAll());
echo "</pre>";

$stm = DB_Connect::dbConnect()->prepare("
    SELECT * FROM article
");

$stm->execute();

echo "<pre>";
print_r($stm->fetchAll());
echo "</pre>";

$stm = DB_Connect::dbConnect()->prepare("
    SELECT username FROM user 
    WHERE id = ANY (SELECT user_fk FROM article WHERE contenu LIKE '%poterie%')
");

$stm->execute();

echo "<pre>";
print_r($stm->fetchAll());
echo "</pre>";


$stm = DB_Connect::dbConnect()->prepare("
    SELECT username FROM user
    WHERE id = ANY(SELECT user_fk FROM article GROUP BY user_fk HAVING count(user_fk) > 1)
");

$stm->execute();

echo "<pre>";
print_r($stm->fetchAll());
echo "</pre>";


$stm = DB_Connect::dbConnect()->prepare("
    SELECT username FROM user WHERE username LIKE 'jane%'
        AND id = ALL(SELECT user_fk FROM article)
");

$stm->execute();

echo "<pre>";
print_r($stm->fetchAll());
echo "</pre>";
