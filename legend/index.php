<?php

$grades[0]['code_text'] = 'Onbekend';
$grades[0]['text'] = 'onbekend weer';
$grades[1]['code_text'] = 'Groen';
$grades[1]['text'] = 'normaal weer';
$grades[2]['code_text'] = 'Geel';
$grades[2]['text'] = 'gevaarlijk weer';
$grades[3]['code_text'] = 'Oranje';
$grades[3]['text'] = 'extreem weer';
$grades[4]['code_text'] = 'Rood';
$grades[4]['text'] = 'het weeralarm';

$types[0] = 'Onbekend';
$types[1] = 'Windstoten en hozen';
$types[2] = 'Sneeuw en gladheid';
$types[3] = 'Onweersbuien';
$types[4] = 'Slecht zicht';
$types[5] = 'Hitte';
$types[6] = 'Koude';
$types[7] = 'Kustbedreiging';
$types[8] = 'Bos- en heidebranden';
$types[9] = 'Lawines';
$types[10] = 'Regen';
$types[11] = 'Onbekend';
$types[12] = 'Overstroming';
$types[13] = 'Regenoverstroming';

$legend['grades'] = $grades;
$legend['types'] = $types;
$legend['source'] = 'http://www.meteoalarm.eu/';

header('Content-Type: application/json');
echo json_encode($legend);
