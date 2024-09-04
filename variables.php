<?php
require_once ('connect.php');

$userStatement = $pdo->prepare("SELECT * FROM users");
$userStatement->execute();
$users = $userStatement->fetchAll();

$recipesSqlStatement = $pdo->prepare("SELECT * FROM `recipes` WHERE `is_enabled` = true");
$recipesSqlStatement->execute();
$recipes = $recipesSqlStatement->fetchAll();

$ratingSqlStatement = $pdo->prepare("SELECT ROUND(AVG(comments.review), 1) AS rating, recipes.title, recipes.recipe_id, recipes.author 
FROM comments LEFT JOIN recipes ON recipes.recipe_id = comments.recipe_id 
WHERE recipes.is_enabled = 1 GROUP BY recipes.title, recipes.recipe_id, recipes.author");
$ratingSqlStatement->execute();
$recipesWithRatings = $ratingSqlStatement->fetchAll();
