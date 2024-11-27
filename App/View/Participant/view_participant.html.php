<div class="details">
    <h2>Détails du participant</h2>
    <?php if ($participant->getProfilePicture()): ?>
        <img src="data:image/jpeg;base64,<?= base64_encode($participant->getProfilePicture()) ?>"
             width="100">
    <?php endif; ?>
    <ul>
        <li>Nom : <?= $participant->getLastName() ?></li>
        <li>Prénom : <?= $participant->getFirstName() ?></li>
        <li>Niveau : <?= $participant->getLevel() ?></li>
    </ul>
</div>
<div class="details">
    <h2>Vols du participant</h2>
    <ul>
        <?php foreach ($flights as $flight): ?>
            <li>
                <a href="index.php?controller=flight&action=view&id=<?= $flight->getId() ?>">
                    Vol du <?= (new DateTime($flight->getDate()))->format('d/m/Y') ?>, lieu de décollage : <?= $flight->getLocation() ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

<div class="actions">
    <a href="index.php?controller=participant&action=list"><button>Retour</button></a>
    <a href="index.php?controller=participant&action=edit&id=<?= $participant->getId() ?>"><button class="edit">Modifier</button></a>
    <a href="index.php?controller=participant&action=delete&id=<?= $participant->getId() ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce participant ?');">
        <button class="delete">Supprimer</button>
    </a>
</div>


