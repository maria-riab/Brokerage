<?php $titre = "Login" ?>
<?php ob_start(); ?>

<form class="p-4" action="index.php?action=login" method="post">
    <h1>Connexion</h1>
    <label for="email">Courriel</label>
    <input type="email" name="email" id="email" required />
    <br />
    <label for="password">Mot de Passe</label>
    <input type="password" name="password" id="password" required />
    <br />
    <button type="submit">Submit</button>
</form>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>