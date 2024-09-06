<?php
session_start();
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');
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
    <!-- inclusion de l'entête du site -->
    <?php require_once(__DIR__ . '/_header.php'); ?>
    <h1 class="text-center">Bienvenu sur notre site de recettes de cuisine.</h1>
    <?php if (!isset($_SESSION['email'])): ?>
        <?php require_once(__DIR__ . '/_login.php'); ?>
    <?php else: ?>
    <p class="text-center">Bon retour <?= $_SESSION['email'] ?></p>
        <p class="text-center"><a href="_logout.php">Se déconnecter</a></p>
    <?php endif; ?>
    <section class="row justify-content-center">
        <article class="col-lg-6">
        <h2 class="text-center">Nos recettes</h2>
        <?php foreach ($recipesWithRatings as $recipesWithRating) : ?>
            <article class="d-flex flex-column justify-content-center my-4 p-2">
                <h3 class="text-center"><?php echo $recipesWithRating['title']; ?></h3>
                <p class="text-center">Auteur de la recette : <?php echo displayAuthor($recipesWithRating['author'], $users); ?></p>
                <a href="recipe_read.php?id=<?= $recipesWithRating['recipe_id'] ?>" class="btn btn-info">Découvrir</a>
                <i class="mt-2">Moyenne des notes : <?= $recipesWithRating['rating'] ?></i>
            </article>
        <?php endforeach ?>
        </article>
    </section>

</main>
<!-- inclusion du bas de page du site -->
<?php require_once(__DIR__ . '/_footer.php'); ?>
</body>
</html>
