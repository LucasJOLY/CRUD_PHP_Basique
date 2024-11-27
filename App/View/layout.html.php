<!DOCTYPE html>
<html>
<head>
    <title>Liste des vols</title>
    <link rel="stylesheet" href="/App/View/Flight/style_flight.css">
    <link rel="stylesheet" href="/App/View/Participant/style_participant.css">
</head>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.querySelector('.dropdown-multi-select');
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');
        toggle.addEventListener('click', () => {
            dropdown.classList.toggle('active');
        });
        document.addEventListener('click', (event) => {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });
        menu.addEventListener('change', () => {
            const selected = Array.from(menu.querySelectorAll('input[type="checkbox"]:checked'));
            if (selected.length > 0) {
                toggle.textContent = `${selected.length} participants sélectionnés`;
            } else {
                toggle.textContent = 'Sélectionner des participants';
            }
        });
    });
</script>

<body>
<?= $content ?>
</body>
</html>
