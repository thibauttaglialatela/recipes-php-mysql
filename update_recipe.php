<?php
session_start();
require_once __DIR__ . '/connect.php';

if (isset($_POST) && !empty($_POST)) {
    $id = $_POST['id'];

    $errors = [];
    //check that the recipe has a title
    $recipeTitle = $_POST['recipeTitle'];
    $recipeTitle = strip_tags(trim($recipeTitle));
    $recipeTitle = htmlspecialchars($recipeTitle, ENT_QUOTES);
    if (empty($recipeTitle)) {
        $errors['recipeTitle'] = 'La recette doit comporter un titre';
    } elseif (strlen($recipeTitle) > 128 || strlen($recipeTitle) < 2) {
        $errors['recipeTitle'] = 'Le titre doit faire entre 2 et 128 caracteres';
    }

    //check if the recipe has a content
    $recipeContent = $_POST['recipeContent'];
    $recipeContent = strip_tags(trim($recipeContent));
    $recipeContent = htmlspecialchars($recipeContent, ENT_QUOTES);
    if (empty($recipeContent)) {
        $errors['recipeContent'] = 'Où ma recette ?';
    } elseif (strlen($recipeContent) < 20) {
        $errors['recipeContent'] = 'Moins de 20 caractéres ? C\' est un peu court';
    }

    // Initialiser isEnabled à 0 par défaut
    $isEnabled = 0;

    // Si la checkbox est cochée, isEnabled est défini sur 1
    if (isset($_POST['is_Enabled'])) {
        $isEnabled = 1;
    }

    if (empty($errors)) {
        try {
            $sql = "UPDATE `recipes` SET `title` = :recipeTitle, `recipe` = :recipeContent, `is_enabled` = :is_enabled WHERE `recipe_id` = :id";
            $stmtUpdate = $pdo->prepare($sql);
            $stmtUpdate->bindValue(':recipeTitle', $recipeTitle, PDO::PARAM_STR);
            $stmtUpdate->bindValue(':recipeContent', $recipeContent, PDO::PARAM_STR);
            $stmtUpdate->bindValue(':is_enabled', $isEnabled, PDO::PARAM_INT);
            $stmtUpdate->bindValue(':id', $id, PDO::PARAM_INT);

            if ($stmtUpdate->execute()) {
                header('Location: index.php');
                exit();
            } else {
                echo 'La recette n\' a pas pu être mise à jour';
            }
        } catch (PDOException $exception) {
            $errorMessage = sprintf('Erreur : %s', $exception->getMessage());
        }

    } else {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>" . $error . "</p>";
        }
    }
} elseif (isset($_GET['id']) && !empty($_GET['id'])) {
    //chercher dans la base la recette correspondante à cet id
    try {
        $id = $_GET['id'];
        $sql = "SELECT * FROM `recipes` WHERE `recipe_id` = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            throw new PDOException('Erreur lors de l\'exécution de la requête.');
        }

        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$recipe) {
            throw new PDOException('La recette n\'existe pas.');
        }
    } catch (PDOException $exception) {
        $errorMessage = sprintf('Erreur : %s', $exception->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - update recipe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
<div class="container">
    <?php require_once(__DIR__ . '/_header.php'); ?>
    <h1>Modifier une recette</h1>
    <section class="row">
        <div class="col-lg-10">
            <?php if (isset($errorMessage) && !empty($errorMessage)): ?>
            <div class="alert alert-danger"><?= $errorMessage ?></div>
            <?php else: ?>
            <form action="<?= htmlspecialchars(basename($_SERVER['REQUEST_URI'])) ?>" method="post">
                <div class="col-lg-6">
                    <label for="recipeTitle" class="form-label">Titre de la recette</label>
                    <input type="text" id="recipeTitle" name="recipeTitle"
                           value="<?= htmlspecialchars($recipe['title']) ?>" class="form-control" required>
                </div>
                <div class="col-lg-6">
                    <label for="recipeContent" class="form-label">Contenu de la recette</label>
                    <textarea name="recipeContent" id="recipeContent" cols="30" rows="10" class="form-control" required>
                    <?= htmlspecialchars($recipe['recipe']) ?>
                    </textarea>
                </div>
                <div class="col-lg-6 form-check">
                    <input class="form-check-input" type="checkbox" name="is_Enabled"
                           value="<?= htmlspecialchars($recipe['is_enabled']) ?>" id="isEnabled"
                        <?= $recipe['is_enabled'] === 1 ? 'checked' : '' ?>
                    >
                    <label class="form-check-label" for="isEnabled">
                        En ligne
                    </label>
                </div>
                <input type="hidden" name="id" value="<?= $id ?>">
                <div class="col-lg-6 mt-2">
                    <button class="btn btn-primary" type="submit">Modifier la recette</button>
                    <a href="/index.php" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php require_once(__DIR__ . '/_footer.php'); ?>
</body>

</html>
