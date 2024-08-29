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
        <article class="col-lg-8">
        <h2 class="text-center">Nos recettes</h2>
        <?php foreach (getRecipes($recipes) as $recipe) : ?>
            <article>
                <h3><?php echo $recipe['title']; ?></h3>
                <div><?php echo $recipe['recipe']; ?></div>
                <i><?php echo displayAuthor($recipe['author'], $users); ?></i>
                <?php if (isset($_SESSION['email']) && $_SESSION['email'] === $recipe['author']): ?>
                <div class="d-flex justify-content-around">
                    <a href="update_recipe.php?id=<?= $recipe['recipe_id'] ?>" class="btn btn-warning">Modifier</a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRecipeModal<?= $recipe['recipe_id'] ?>">
                        Supprimer
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteRecipeModal<?= $recipe['recipe_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Etes-vous certain(e) de vouloir supprimer cette recette ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Non</button>
                                    <?php if ($_SESSION['email'] === $recipe['author']): ?>
                                    <form action='delete_recipe.php' method="post">
                                        <input type="hidden" name="recipe_id" value="<?= $recipe['recipe_id']; ?>">
                                        <button type="submit" class="btn btn-danger">Oui</button>
                                    </form>
                                    <?php else: ?>
                                    <div class="alert alert-danger" role="alert">
                                        Seul l'auteur de la recette ou un administrateur peut la supprimer.
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </article>
        <?php endforeach ?>
        </article>
    </section>

</main>
<!-- inclusion du bas de page du site -->
<?php require_once(__DIR__ . '/_footer.php'); ?>
</body>
</html>
