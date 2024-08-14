<?php
session_start();
require_once ('connect.php');
//valider les données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipeTitle = $_POST["recipeTitle"];
    $recipeContent = $_POST["recipeContent"];

    $recipeTitle = strip_tags(trim($recipeTitle));
    $recipeContent = strip_tags(trim($recipeContent));

    $recipeTitle = htmlspecialchars($recipeTitle, ENT_QUOTES);
    $recipeContent = htmlspecialchars($recipeContent, ENT_QUOTES);

    $errors = [];

    if (empty($recipeTitle)) {
        $errors['recipeTitle'] = "La recette doit comporter un titre";
    } elseif (strlen($recipeContent) > 128 || strlen($recipeContent) < 2 ) {
        $errors['recipeTitle'] = "Le titre doit faire entre 2 et 128 caracteres";
    }

    if (empty($recipeContent)) {
        $errors['recipeContent'] = "La recette doit comporter un texte";
    } elseif (strlen($recipeContent) < 20) {
        $errors['recipeContent'] = "La recette doit faire un minimum de 20 caractéres";
    }

    if (empty($errors)) {
        $sqlInsert = "INSERT INTO `recipes` (`title` , `recipe`, `author`, `is_enabled`) VALUES (:recipeTitle, :recipeContent, :recipeAuthor, 0);')";

        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->bindValue(':recipeTitle', $recipeTitle, PDO::PARAM_STR);
        $stmtInsert->bindValue(':recipeContent', $recipeContent, PDO::PARAM_STR);
        $stmtInsert->bindValue(':recipeAuthor', $_SESSION['email'], PDO::PARAM_STR);

        $stmtInsert->execute();
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
