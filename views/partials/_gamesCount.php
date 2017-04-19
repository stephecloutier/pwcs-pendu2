<?php if ($_SESSION['email']): ?>
    <div class="stats">
        Tu as déjà joué <?= $data['gamesCount']; ?> parties (et tu en as gagné <?= $data['gamesWon'] ?>)
    </div>
<?php endif; ?>
