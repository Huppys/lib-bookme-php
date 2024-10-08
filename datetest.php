<?php

// Was passiert, wenn die Stunden abgeschnitten werden?

date_default_timezone_set('Europe/Berlin');

$date = new DateTime();
//var_dump($date);

$timezoneBerlin = new DateTimeZone('Europe/Berlin');
$dateTimeBerlin = clone ($date)->setTimezone($timezoneBerlin);
var_dump($dateTimeBerlin);

$timezoneLosAngeles = new DateTimeZone('America/Los_angeles');
$dateTimeLosAngeles = clone ($date)->setTimezone($timezoneLosAngeles);
var_dump($dateTimeLosAngeles);


//$dateBerlin = DateTimeImmutable::createFromFormat('Y-m-d|', date('Y-m-d'));
var_dump($dateTimeBerlin->format('Y-m-d'));
var_dump($dateTimeLosAngeles->format('Y-m-d'));

//$dateLosAngeles = DateTimeImmutable::createFromFormat('Y-m-d|', $dateTimeLosAngeles->format(DATE_ATOM));
//var_dump($dateLosAngeles);