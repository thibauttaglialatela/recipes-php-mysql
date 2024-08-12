<?php if (!isset($_SESSION['email'])): ?>
    <section class="row justify-content-center">
        <article class="col-md-4">
            <h2 class="text-center my-4">Se connecter</h2>
            <?php if (isset($_SESSION['ERROR_MESSAGE'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['ERROR_MESSAGE'] ?></div>
            <?php endif; ?>
            <form action="_submit_login.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">e-mail</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="john.doe@exemple.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control"
                           placeholder="veuillez entrer votre mot de passe">
                </div>
                <button class="btn btn-primary" type="submit">Se connecter</button>
            </form>
        </article>
    </section>
<?php /*else: */?><!--
<div>
    <p>Bon retour parmi nous <?php /*= $_SESSION['email'] */?></p>
</div>-->
<?php endif; ?>
