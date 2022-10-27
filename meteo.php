<?php 
// require_once 'class/OpenWeather.php';

$weather = new OpenWeather('fd21127cb0bc28122fa5fe77d22ff605');
$forecast = $weather->getForecast('arbois,fr');
var_dump($forecast);
?>


<div class="container">
    <ul>
        <?php for ($i = 0; $i < count($forecast); $i+=8) : ?>
        <li>
            <img src="http://openweathermap.org/img/w/<?= $forecast[$i]['icon'] ?>.png" alt="">
            <p><?= $forecast[$i]['temp'] ?>°C</p>
            <p><?= $forecast[$i]['description'] ?></p>
            <p><?= $forecast[$i]['date']->format('d/m/Y') ?></p>
        </li>
        <?php endfor ?>
    </ul>
</div>




