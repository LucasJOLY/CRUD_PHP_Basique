<div class="details">
    <h2>Détails du vol</h2>
    <div class="flight-images">
        <?php foreach ($images as $image): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($image) ?>"  width="150"/>
        <?php endforeach; ?>
    </div>
    <ul>
        <li>Lieu de décollage : <?= $flight->getLocation() ?></li>
        <li>Date : <?= (new DateTime($flight->getDate()))->format('d/m/Y') ?></li>
        <li>Altitude au décollage : <?= $flight->getFromAlt() ?> m</li>
        <li>Altitude à l'arrivée : <?= $flight->getToAlt() ?> m</li>
        <li>Commentaire : <?= $flight->getComment() ?></li>
        <li>Durée : <?= $flight->getTime() ?> minutes</li>
    </ul>
</div>
<div class="details">
    <h2>Participants du vol</h2>
    <ul>
        <?php foreach ($participants as $participant): ?>
            <li>
                <a href="index.php?controller=participant&action=view&id=<?= $participant->getId() ?>">
                    <?= $participant->getLastName() ?> <?= $participant->getFirstName() ?> (Niveau : <?= $participant->getLevel() ?>)
                </a>
            </li>
        <?php endforeach; ?>
    </ul>


<div class="actions">
    <a href="index.php?controller=flight&action=list"><button>Retour</button></a>
    <a href="index.php?controller=flight&action=edit&id=<?= $flight->getId() ?>"><button class="edit">Modifier</button></a>
    <a href="index.php?controller=flight&action=delete&id=<?= $flight->getId() ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce vol ?');">
        <button class="delete">Supprimer</button>
    </a>
</div>


