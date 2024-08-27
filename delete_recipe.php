<?php
include_once __DIR__ . "/connect.php";
if (isset($_POST['recipe_id']) && !empty($_POST['recipe_id'])) {
$sql = "DELETE FROM `recipes` WHERE `recipe_id` = :recipe_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['recipe_id' => $_POST['recipe_id']]);
header('Location: index.php');
}
