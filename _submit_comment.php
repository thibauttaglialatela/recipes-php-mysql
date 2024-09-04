<?php
session_start();
require_once 'connect.php';
require_once 'functions.php';

$errors = [];  // Initialiser les erreurs en dehors du bloc POST

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
    //check the csrf token
    if (!isValidToken()) {
        die('Invalid Token');
    }

    $comment = trim($_POST['comment']);  // Utilisation de trim pour éviter les espaces vides
    $recipeId = trim($_POST['recipe_id']);
    $userId = $_SESSION['user_id'];

    $stmtRecipes = $pdo->prepare("SELECT * FROM recipes WHERE recipe_id = :recipe_id");
    $stmtRecipes->bindParam(':recipe_id', $recipeId);
    $stmtRecipes->execute();
    $recipes = $stmtRecipes->fetchAll();

    if (empty($recipes)) {
        $errors['recipe_id'] = 'Cette recette n\' existe pas';
        redirectToUrl('recipe_read.php?id=' . $recipeId);
    }

    if (empty($comment)) {
        $errors['commentContent'] = "Veuillez indiquer un commentaire";
    } elseif (strlen($comment) < 2) {
        $errors['commentContent'] = "Votre commentaire doit faire au moins 2 caractères";
    } elseif (strlen($comment) > 250) {
        $errors['commentContent'] = "Votre commentaire est trop long. Il doit faire moins de 250 caractéres";
    } else {
        $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
    }

    if (empty($errors)) {
        try {
            $sql = "INSERT INTO `comments` (`user_id`, `recipe_id`, `comment`) VALUES (:user_id, :recipe_id, :comment)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
            $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);

            if ($stmt->execute()) {
                header('Location: recipe_read.php?id=' . $recipeId);
                exit();  // Arrête le script après la redirection
            }
        } catch (PDOException $e) {
            $errors['dbError'] = "Erreur lors de l'insertion : " . $e->getMessage();
        }
    }
}
