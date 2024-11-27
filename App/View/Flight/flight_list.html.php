
<a href="index.php?controller=flight&action=add" class="add-button">Ajouter un vol</a>

<table class="table-list">
    <thead>
    <tr>
        <th>ID</th>
        <th>Lieu de décollage</th>
        <th>Date</th>
        <th>Durée en minutes</th>
        <th>Altitude départ</th>
        <th>Altitude arrivée</th>
        <th>Commentaires</th>
        <th>Détails</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($flights as $flight): ?>
        <tr>
            <td><?= $flight->getId() ?></td>
            <td><?= $flight->getLocation() ?></td>
            <td><?= (new DateTime($flight->getDate()))->format('d/m/Y') ?></td>
            <td><?= $flight->getTime() ?> min</td>
            <td><?= $flight->getFromAlt() ?> m</td>
            <td><?= $flight->getToAlt() ?> m</td>
            <td><?= $flight->getComment() ?></td>
            <td><a href="index.php?controller=flight&action=view&id=<?= $flight->getId() ?>">Voir</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a href="index.php?controller=participant&action=list" class="go_to_list">Accéder à la liste des participants</a>

