<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'erreurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<main class="container">
    <?php require_once(__DIR__ . '/_header.php'); ?>
    <section class="row">
        <div class="col-lg-8">
            <h2 class="text-center">Demande invalide</h2>
            <div class="alert alert-danger">Une erreur est survenue. SVP. <a href="index.php">retournez</a> et réessayez.</div>
        </div>
    </section>

</main>
<?php require_once(__DIR__ . '/_footer.php'); ?>
</body>
</html>
