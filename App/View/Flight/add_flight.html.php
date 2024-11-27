
    <div class="actions-retour">
        <a href="index.php?controller=flight&action=list"><button class="buttonRetour">Retour</button></a>
    </div>
    <form method="post" class="add_form" enctype="multipart/form-data">
        <?php if (!empty($errors)) : ?>
            <div class="errors">
                <?php foreach ($errors as $error) : ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <label for="images">Images</label>
        <input type="file" name="images[]" id="images" accept="image/*" multiple required>
        <label for="location">Lieu de décollage</label>
        <input type="text" name="location" id="location" required>
        <label for="date">Date</label>
        <input type="date" name="date" id="date" required>
        <label for="from_alt">Altitude au décollage</label>
        <input type="number" name="from_alt" id="from_alt" required>
        <label for="to_alt">Altitude à l'arrivée</label>
        <input type="number" name="to_alt" id="to_alt" required>
        <label for="comment">Commentaire</label>
        <textarea name="comment" id="comment"></textarea>
        <label for="time">Durée (minutes)</label>
        <input type="number" name="time" id="time" required>
        <label for="participants">Participants</label>
        <div class="dropdown-multi-select">
            <button type="button" class="dropdown-toggle">Sélectionner des participants</button>
            <div class="dropdown-menu">
                <?php foreach ($participants as $participant) : ?>
                    <label class="dropdown-item">
                        <input type="checkbox" name="participants[]" value="<?= $participant->getId() ?>">
                        <?= $participant->getLastName() ?> <?= $participant->getFirstName() ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <button type="submit">Ajouter</button>

    </form>