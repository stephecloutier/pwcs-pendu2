<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Le pendu avec sessions</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<div>
    <h1>Trouve le mot en moins de <?= MAX_TRIALS; ?> coups !</h1>
</div>
<div>
    <p>Le mot à deviner compte <?= $_SESSION['lettersCount']; ?>
        lettres&nbsp;: <?= $_SESSION['replacementString']; ?></p>
</div>
<div id="images">
    <img src="images/pendu<?= $_SESSION['trials']; ?>.gif"
         alt="">
</div>
<div>
    <p>Voici les lettres que tu as déjà essayées&nbsp;: <?= $_SESSION['triedLetters']; ?></p>
</div>
<?php if ($_SESSION['wordFound']
): ?>
    <div>
        <p class="bg-success lead">Bravo&nbsp;! Tu as trouvé le mot
            «&nbsp;<b><?= $_SESSION['word']; ?></b>&nbsp;». <a href="index.php">Recommence&nbsp;!</a>
        </p>
    </div>
    <?php include('views/partials/_gamesCount.php')  ?>
<?php elseif ($_SESSION['remainingTrials'] == 0): ?>
    <div>
        <p class="bg-danger lead">Ooops&nbsp;! Tu sembles bien mort&nbsp;! Le mot à trouver était «&nbsp;<b><?= $_SESSION['word']; ?></b>&nbsp;». <a href="index.php">Recommence&nbsp;!</a>
        </p>
        <?php include('views/partials/_gamesCount.php')  ?>
    </div>
<?php else: ?>
    <form action="index.php"
          method="post">
        <fieldset>
            <legend>Il te reste <?= $_SESSION['remainingTrials']; ?> essais pour sauver ta peau
            </legend>
            <div>
                <label for="triedLetter">Choisis ta lettre</label>
                <select name="triedLetter"
                        id="triedLetter">
                    <?php foreach ($_SESSION['lettersArray'] as $letter => $status): ?>
                        <?php if ($status): ?>
                            <option value="<?= $letter; ?>"><?= $letter; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <input type="submit"
                       value="essayer cette lettre">
            </div>
        </fieldset>
    </form>
<?php endif; ?>
</body>
</html>
