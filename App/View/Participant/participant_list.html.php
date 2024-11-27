
<div class="actions-retour">
    <a href="index.php?controller=flight&action=list"><button class="buttonRetour">Retour</button></a>
</div>
<a href="index.php?controller=participant&action=add" class="add-button">Ajouter un participant</a>

<table class="table-list">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Niveau</th>
        <th>Détails</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($participants as $participant): ?>
        <tr>
            <td><?= $participant->getId() ?></td>
            <td><?= $participant->getLastName() ?></td>
            <td><?= $participant->getFirstName() ?></td>
            <td><?= $participant->getLevel() ?></td>
            <td><a href="index.php?controller=participant&action=view&id=<?= $participant->getId() ?>">Voir</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


