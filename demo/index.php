<?php

require __DIR__ . '/../vendor/autoload.php';

use Bayonet\BayonetClient;

$bayonet = new BayonetClient(['version' => 1]);
$bayonet->consulting();

?>