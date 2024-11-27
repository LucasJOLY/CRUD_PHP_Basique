
<div class="actions-retour">
    <a href="index.php?controller=participant&action=list"><button class="buttonRetour">Retour</button></a>
</div>
<form method="post" class="form_edit" enctype="multipart/form-data">
    <label for="profilePicture">Photo de profil</label>
    <div class="image-preview">
        <?php if ($participant->getProfilePicture()): ?>
            <img id="currentImage" src="data:image/jpeg;base64,<?= base64_encode($participant->getProfilePicture()) ?>" width="100"/>
        <?php endif; ?>
    </div>
    <input type="file" name="profilePicture" id="profilePicture" accept="image/*">
    <?php if (!empty($errors['profilePicture'])): ?>
        <p class="error"><?=
            $errors['profilePicture']
            ?></p>
    <?php endif; ?>
    <label for="lastName">Nom</label>
    <input type="text" name="lastName" id="lastName" value="<?= $participant->getLastName() ?>" required>
    <?php if (!empty($errors['lastName'])): ?>
        <p class="error"><?= $errors['lastName'] ?></p>
    <?php endif; ?>
    <label for="firstName">Prénom</label>
    <input type="text" name="firstName" id="firstName" value="<?= $participant->getFirstName() ?>" required>
    <?php if (!empty($errors['firstName'])): ?>
        <p class="error"><?=
            $errors['firstName']
            ?></p>
    <?php endif; ?>
    <label for="level">Niveau</label>
    <select name="level" id="level" required>
        <option value="débutant" <?= $participant->getLevel() === 'débutant' ? 'selected' : '' ?>>Débutant</option>
        <option value="intermédiaire" <?= $participant->getLevel() === 'intermédiaire' ? 'selected' : '' ?>>Intermédiaire</option>
        <option value="confirmé" <?= $participant->getLevel() === 'confirmé' ? 'selected' : '' ?>>Confirmé</option>
    </select>
    <?php if (!empty($errors['level'])): ?>
        <p class="error"><?=
            $errors['level']
            ?></p>
    <?php endif; ?>
    <button type="submit">Modifier</button>
</form>