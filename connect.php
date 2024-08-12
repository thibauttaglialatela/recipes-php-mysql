<?php

const DB_HOST = 'db';
const DB_USER = 'user';
const DB_PASS = 'password';
const DB_NAME = 'recipes_db';

$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
} catch (PDOException $e) {
    echo 'Une erreur est survenue lors de la connexion : ' . $e->getMessage();
}
