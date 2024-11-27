
<div class="actions-retour">
    <a href="index.php?controller=flight&action=list"><button class="buttonRetour">Retour</button></a>
</div>
<form method="post" class="form_edit" enctype="multipart/form-data">
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
    <input type="text" name="location" id="location" value="<?= $flight->getLocation() ?>" required>
    <label for="date">Date</label>
    <input type="date" name="date" id="date" value="<?= (new DateTime($flight->getDate()))->format(
        'Y-m-d') ?>" required>
    <label for="from_alt">Altitude au décollage</label>
    <input type="number" name="from_alt" id="from_alt" value="<?= $flight->getFromAlt() ?>" required>
    <label for="to_alt">Altitude à l'arrivée</label>
    <input type="number" name="to_alt" id="to_alt" value="<?= $flight->getToAlt() ?>" required>
    <label for="comment">Commentaire</label>
    <textarea name="comment" id="comment"><?= $flight->getComment() ?></textarea>
    <label for="time">Durée (minutes)</label>
    <input type="number" name="time" id="time" value="<?= $flight->getTime() ?>" required>
    <div class="dropdown-multi-select">
        <button type="button" class="dropdown-toggle">
            <?= count($listIds) > 0 ? count($listIds) . ' participants sélectionnés' : 'Sélectionner des participants' ?>
        </button>
        <div class="dropdown-menu">
            <?php foreach ($participants as $participant) : ?>
                <label class="dropdown-item">
                    <input type="checkbox" name="participants[]" value="<?= $participant->getId() ?>"
                        <?= in_array($participant->getId(), $listIds) ? 'checked' : '' ?>

                    >
                    <?= $participant->getLastName() ?> <?= $participant->getFirstName() ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>
    <button type="submit">Modifier</button>
</form>