<?php
require_once ('connect.php');

$userStatement = $pdo->prepare("SELECT * FROM users");
$userStatement->execute();
$users = $userStatement->fetchAll();

$recipesSqlStatement = $pdo->prepare("SELECT * FROM `recipes` WHERE `is_enabled` = true");
$recipesSqlStatement->execute();
$recipes = $recipesSqlStatement->fetchAll();
