
    <div class="actions-retour">
        <a href="index.php?controller=participant&action=list"><button class="buttonRetour">Retour</button></a>
    </div>
    <form method="post" class="add_form" enctype="multipart/form-data">
        <label for="profilePicture">Photo de profil</label>
        <input type="file" name="profilePicture" id="profilePicture" accept="image/*" required>
        <?php if (!empty($errors['profilePicture'])): ?>
            <p class="error"><?=
                $errors['profilePicture']
            ?></p>
        <?php endif; ?>
        <label for="lastName">Nom</label>
        <input type="text" name="lastName" id="lastName" required>
        <?php if (!empty($errors['lastName'])): ?>
            <p class="error"><?= $errors['lastName'] ?></p>
        <?php endif; ?>
        <label for="firstName">Prénom</label>
        <input type="text" name="firstName" id="firstName" required>
        <?php if (!empty($errors['firstName'])): ?>
            <p class="error"><?=
                $errors['firstName']
            ?></p>
        <?php endif; ?>
        <label for="level">Niveau</label>
        <select name="level" id="level" required>
            <option value="débutant">Débutant</option>
            <option value="intermédiaire">Intermédiaire</option>
            <option value="confirmé">Confirmé</option>
        </select>
        <?php if (!empty($errors['level'])): ?>
            <p class="error"><?=
                $errors['level']
            ?></p>
        <?php endif; ?>
        <button type="submit">Ajouter</button>
    </form>