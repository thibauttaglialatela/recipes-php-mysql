<?php
session_start();
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/connect.php');

$errorMessage = '';
try {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header('Location: error.php');
        exit();
    }
    $recipeId = $_GET['id'];
    $statement = $pdo->prepare("SELECT * FROM `recipes` WHERE `recipe_id` = :recipe_id");
    $statement->bindParam(':recipe_id', $recipeId);
    if (!$statement->execute()) {
        throw new PDOException('Erreur lors de l\'exécution de la requête.');
    }
    $recipe = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$recipe) {
        throw new PDOException('La recette n\'existe pas.');
    }

} catch (PDOException $PDOException) {
    $errorMessage = $PDOException->getMessage();
}

?>
<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail d'une recette</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="d-flex flex-column min-vh-100">
<main class="container">
    <!-- inclusion de l'entête du site -->
    <?php require_once(__DIR__ . '/_header.php'); ?>
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger"><?= $errorMessage ?></div>
    <?php else: ?>
        <h1 class="text-center"><?= $recipe['title'] ?></h1>
        <section class="row justify-content-center">
            <article class="col-lg-8">
                <div class="card shadow rounded">
                    <div class="card-body">
                        <p class="card-text"><?= $recipe['recipe'] ?></p>
                    </div>
                    <div class="card-footer">
                        <?php echo displayAuthor($recipe['author'], $users); ?>
                        <?php if (isset($_SESSION['email']) && $_SESSION['email'] === $recipe['author']): ?>
                            <div class="d-flex justify-content-around mt-2">
                                <a href="update_recipe.php?id=<?= $recipe['recipe_id'] ?>"
                                   class="btn btn-warning">Modifier</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRecipeModal<?= $recipe['recipe_id'] ?>">
                                    Supprimer
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="modal fade" id="deleteRecipeModal<?= $recipe['recipe_id']  ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
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
                                    <?php endif;  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </section>
    <?php endif; ?>


</main>
<!-- inclusion du bas de page du site -->
<?php require_once(__DIR__ . '/_footer.php'); ?>
</body>
</html>
