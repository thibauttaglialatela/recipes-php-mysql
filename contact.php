<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Page contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="d-flex flex-column min-vh-100">
<div class="container">
    <?php require_once(__DIR__ . '/_header.php'); ?>
    <h1>Contactez nous</h1>
    <form action="_submit_contact.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help">
            <div id="email-help" class="form-text">Nous ne revendrons pas votre email.</div>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Votre message</label>
            <textarea class="form-control" placeholder="Exprimez vous" id="message" name="message"></textarea>
        </div>
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="screenshot" name="screenshot">
            <label class="input-group-text" for="screenshot">Votre capture d'écran</label>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
    <br />
</div>
<?php require_once(__DIR__ . '/_footer.php'); ?>
</body>


</html>
