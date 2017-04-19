<main class="maingame">

    <header class="headergame">
        <h1><a href="http://homestead.app/pwcs/pwcs-pendu2/">Le pendu</a></h1>
        <span>Trouve le mot en moins de <?= MAX_TRIALS; ?> coups !</span>
    </header>

    <div>
        <p class="motADeviner">Le mot à deviner compte <?= $_SESSION['lettersCount']; ?>
            lettres&nbsp; <span class="replacementString"><?= $_SESSION['replacementString']; ?></span></p>
    </div>
    <div id="images">
        <img src="images/pendu<?= $_SESSION['trials']; ?>.gif"
             alt="" height="250" width="auto">
    </div>
    <div>
        <p>Voici les lettres que tu as déjà essayées&nbsp; <span class="triedLetters"><?= $_SESSION['triedLetters']; ?></span></p>
    </div>
    <?php if ($_SESSION['wordFound']
    ): ?>
        <div>
            <p class="bg-success lead">Bravo&nbsp;! Tu as trouvé le mot
                «&nbsp;<b class="wordFound"><?= $_SESSION['word']; ?></b>&nbsp;». <a href="index.php" class="resetGame">Recommence&nbsp;!</a>
            </p>
        </div>
        <?php include('views/partials/_gamesCount.php')  ?>
    <?php elseif ($_SESSION['remainingTrials'] == 0): ?>
        <div class="dead">
            <p class="bg-danger lead">Ooops&nbsp;! Tu sembles bien mort&nbsp;! Le mot à trouver était «&nbsp;<b class="wordNotFound"><?= $_SESSION['word']; ?></b>&nbsp;». <a href="index.php" class="resetGame">Recommence&nbsp;!</a>
            </p>
            <?php include('views/partials/_gamesCount.php')  ?>
        </div>
    <?php else: ?>
        <form action="index.php"
              method="post" class="gameForm">
            <fieldset>
                <legend class="formLegend">Il te reste <span class="remainingTrials"><?= $_SESSION['remainingTrials']; ?></span> essais pour sauver ta peau
                </legend>
                <div class="insideForm">
                    <label for="triedLetter" class="chooseLetter">Choisis ta lettre</label>
                    <select name="triedLetter"
                            id="triedLetter" class="tryLetter">
                        <?php foreach ($_SESSION['lettersArray'] as $letter => $status): ?>
                            <?php if ($status): ?>
                                <option value="<?= $letter; ?>"><?= $letter; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="r" value="game">
                    <input type="hidden" name="a" value="check">
                    <input type="submit"
                           value="essayer cette lettre" class="sendLetter">
                </div>
            </fieldset>
        </form>
    <?php endif; ?>
</main>
