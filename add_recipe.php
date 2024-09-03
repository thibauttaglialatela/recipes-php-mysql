<?php
session_start();
require_once('connect.php');
require_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isValidToken()) {
        die('token is invalid');
    }
    $recipeTitle = $_POST["recipeTitle"];
    $recipeContent = $_POST["recipeContent"];

    $recipeTitle = strip_tags(trim($recipeTitle));
    $recipeContent = strip_tags(trim($recipeContent));

    $recipeTitle = htmlspecialchars($recipeTitle, ENT_QUOTES);
    $recipeContent = htmlspecialchars($recipeContent, ENT_QUOTES);

    $errors = [];

    if (empty($recipeTitle)) {
        $errors['recipeTitle'] = "La recette doit comporter un titre";
    } elseif (strlen($recipeTitle) > 128 || strlen($recipeTitle) < 2) {
        $errors['recipeTitle'] = "Le titre doit faire entre 2 et 128 caractères";
    }

    if (empty($recipeContent)) {
        $errors['recipeContent'] = "La recette doit comporter un texte";
    } elseif (strlen($recipeContent) < 20) {
        $errors['recipeContent'] = "La recette doit faire un minimum de 20 caractères";
    }

    if (empty($errors)) {
        try {
            $sqlInsert = "INSERT INTO `recipes` (`title`, `recipe`, `author`, `is_enabled`) VALUES (:recipeTitle, :recipeContent, :recipeAuthor, 1);";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->bindValue(':recipeTitle', $recipeTitle, PDO::PARAM_STR);
            $stmtInsert->bindValue(':recipeContent', $recipeContent, PDO::PARAM_STR);
            $stmtInsert->bindValue(':recipeAuthor', $_SESSION['email'], PDO::PARAM_STR);

            if ($stmtInsert->execute()) {
                // Redirection vers la page index.php en cas de succès
                header("Location: index.php");
                exit();
            } else {
                echo "Erreur : La recette n'a pas pu être ajoutée.";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion : " . $e->getMessage();
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<main class="container">
    <?php require_once(__DIR__ . '/_header.php'); ?>
    <h1 class="text-left">Formulaire de création de recette de cuisine.</h1>
<section class="row">
    <div class="col-lg-10">
    <form action="" method="post">
        <div class="col-lg-6">
            <label for="recipeTitle" class="form-label">Titre de la recette</label>
            <input type="text" id="recipeTitle" name="recipeTitle" class="form-control" required>
        </div>
        <div class="col-lg-6">
            <label for="recipeContent" class="form-label">Contenu de la recette</label>
            <textarea name="recipeContent" id="recipeContent" cols="30" rows="10" class="form-control" required></textarea>
        </div>
        <div class="col-lg-6 ">
            <button class="btn btn-primary" type="submit">Poster la recette</button>
        </div>
    </form>
    </div>
</section>
</main>
<?php require_once(__DIR__ . '/_footer.php'); ?>
</body>
</html>
