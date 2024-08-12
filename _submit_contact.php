<?php
if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0) {
    if ($_FILES['screenshot']['size'] > 1000000) {
        echo "désolé le fichier est trop volumineux";
        return;
    }

    $fileInfo = pathinfo($_FILES['screenshot']['name']);
    $extension = $fileInfo['extension'];
    $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
    if (!in_array($extension, $allowedExtensions)) {
        echo sprintf('L\' envoi n\'a pu être effectué, l\' extension %s n\'est pas autorisée', $extension);
        return;
    }

    $path = __DIR__ . '/uploads/';
    if (!is_dir($path)) {
        echo sprintf('Le dossier %s n\'existe pas !', $path);
        return;
    }
    move_uploaded_file($_FILES['screenshot']['tmp_name'], $path . basename($_FILES['screenshot']['name']));

}
?>
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
    <?php require_once(__DIR__ . '/header.php'); ?>
    <h1>Message bien reçu !</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Rappel de vos informations</h5>
            <?php if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $path . basename($_FILES['screenshot']['name']))): ?>
            <div class="alert alert-info">Nous avons bien reçu votre image.</div>
            <?php endif;?>
            <?php if (!isset($_POST['email'])
                || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
                || !isset($_POST['message'])
                || empty($_POST['message'])
                || trim($_POST['message']) === ''
            ): ?>
                <div class="alert alert-danger">Il faut un mail et un message pour soumettre le formulaire</div>
            <?php else: ?>
                <p class="card-text"><b>Email</b> : <?php echo htmlspecialchars($_POST['email']); ?></p>
                <p class="card-text"><b>Message</b> : <?php echo htmlspecialchars($_POST['message']); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once(__DIR__ . '/footer.php'); ?>
</body>


</html>
