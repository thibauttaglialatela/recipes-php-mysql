<?php
if (isset($_POST['recipe_id']) && !empty($_POST['recipe_id'])) {
printf('La recette %s est supprimée', htmlspecialchars($_POST['recipe_id']));
//todo: implémenter la suppression de la recette
}
