<?php
require_once __DIR__ . '/OpenWeather.php';
$weather = new OpenWeather('ed7beff0087079db2d959f8563bc96b0');
$forecast = $weather->getForcast('Montpellier,fr');
$today = $weather->getToday('Montpellier,fr');
require 'elements/header.php';
?>

<div class = "container">
    <ul>  
        <li>En ce moment <?= $today['description'] ?> <?= $today['temp'] ?>°C</li>
        <?php foreach ($forecast as $day): ?>
        <li><?= $day['date']->format('d/m/y') ?> <?= $day['description'] ?> <?= $day['temp'] ?></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php require 'elements/footer.php'; ?>



