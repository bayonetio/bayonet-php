<?php

// load requirements
require __DIR__ . '/../vendor/autoload.php';

// initialize bayonet sdk
use Bayonet\BayonetClient;
$bayonet = new BayonetClient([
    'version' => 1
]);

// fixtures
$fx = json_decode(file_get_contents(__DIR__ . '/fixtures/requests.json'), true);

// make the request
$bayonet->consulting([
    'body' => $fx['consulting'],
    'on_success' => function($response) {
        print_r($response);
    },
    'on_failure' => function($response) {
        print_r($response);
    }
]);

?>