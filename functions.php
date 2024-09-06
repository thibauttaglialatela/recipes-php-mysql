<?php
function displayAuthor(string $authorEmail, array $users): string
{
    foreach($users as $user) {
        if ($authorEmail === $user['email']) {
            return $user['full_name'] . '(' . $user['age'] . ' ans)';
        }
    }
    return 'Auteur inconnu';
}
function isValidRecipe(array $recipe): bool
{
    return $recipe['is_enabled'];
}

function redirectToUrl(string $url): never
{
    header('Location: ' . $url);
    exit();
}

function isValidToken(): bool
{
    if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']) {
        return false;
    }
    return true;
}
