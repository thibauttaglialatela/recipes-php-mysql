<!-- Afficher les erreurs après la logique principale -->
<?php if (!empty($_SESSION['errors']) && isset($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <?php foreach ($_SESSION['errors'] as $error): ?>
            <?php echo $error . "<br>"; ?>
        <?php endforeach; ?>
    </div>
<?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<article class="col-lg-8 mx-auto">
    <h2 class="text-center mb-4">Formulaire d'ajout de commentaire</h2>
    <form action="_submit_comment.php" method="post">
        <div class="mb-3">
            <label for="comment" class="form-label">Votre commentaire</label>
            <textarea name="comment" id="comment" class="form-control" rows="10" placeholder="Votre commentaire"
                      required></textarea>
        </div>
        <div class="mb-3">
            <label for="review" class="form-label">Votre note</label>
            <input type="number" name="review" id="review" min="0" max="5" placeholder="3" required>
        </div>
        <div class="mb-3">
            <input type="hidden" name="recipe_id" value="<?= $_GET['id'] ?>">
        </div>
        <div class="mb-3">
            <?php if (isset($_SESSION['csrf_token'])): ?>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <?php endif; ?>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success btn-lg">Soumettre</button>
        </div>
    </form>
</article>
