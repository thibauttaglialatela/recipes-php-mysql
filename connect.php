<?php

const DB_HOST = 'db';
const DB_USER = 'user';
$DB_PASS = trim(file_get_contents('./secrets/secrets_mysql_password.txt'));
const DB_NAME = 'recipes_db';

$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";

try {
    $pdo = new PDO($dsn, DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Une erreur est survenue lors de la connexion : ' . $e->getMessage();
}
