<?php

require __DIR__ . '/../vendor/autoload.php';

use Bayonet\BayonetClient;

$bayonet = new BayonetClient(['version' => 1]);
$fx = json_decode(file_get_contents(__DIR__ . '/fixtures/requests.json'), true);

$consulting_response = $bayonet->consulting($fx['consulting']);
print_r($consulting_response);

$bayonet->feedback($fx['feedback']);
$bayonet->feedback_historical($fx['feedback_historical']);
?>