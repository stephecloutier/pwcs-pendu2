<div>
    <h1>Bienvenue sur le pendu</h1>
</div>

<div>
    <p>
        Si tu souhaites mémoriser tes parties, nous pouvons le faire, mais il faut nous fournir alors un identifiant.
    </p>
    <p>
        Suite du blabla
    </p>

    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="email">Ton email (pas obligatoire)</label>
        <input type="text" id="email" name="email" placeholder="jon.snow@nightwatch.north" value="<?= $_SESSION['email']; ?>">

        <?php if (isset($_SESSION['errors']['email'])): ?>
            <div><p><?= $_SESSION['errors']['email']; ?></p></div>
        <?php endif; ?>

        <input type="submit" value="Jouer">
    </form>

</div>