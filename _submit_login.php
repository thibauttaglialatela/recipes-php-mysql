<?php
session_start();

require_once ('variables.php');
require_once ('functions.php');

if (isset($_POST['email']) && isset($_POST['password'])) {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['ERROR_MESSAGE'] = 'Please enter a valid email address';
    } else if (!isset($_SESSION['email'])) {
        foreach ($users as $user) {
            if ($_POST['email'] === $user['email'] && $_POST['password'] === $user['password']) {
                $_SESSION['email'] = $user['email'];
            }
        }

        if (!isset($_SESSION['email'])) {
            $_SESSION['ERROR_MESSAGE'] = sprintf('les informations fournies ne permettent pas de vous identifier : (%s/%s)',
                htmlspecialchars($_POST['email']),
                htmlspecialchars($_POST['password']));
        }
    }
}

redirectToUrl('index.php');
?>
