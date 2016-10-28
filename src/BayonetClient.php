<?php

namespace Bayonet;

use GuzzleHttp\Client;

class BayonetClient {
    private $client;
    private $config;

    public function __construct(array $config = []) {
        if(!isset($config['api_key'])) {
            $config['api_key'] = getenv('BAYONET_API_KEY');
        }

        if(!isset($config['version'])) {
            throw new \Exception('You need to specify a Bayonet API version.');
        }

        $this->config = $config;
        $this->config['base_uri'] = 'https://api.bayonet.io/v' . $this->config['version'] . '/';
        $this->client = new Client();
    }

    public function consulting() {
        $this->request('consulting');
    }

    public function feedback() {
        $this->request('feedback');
    }

    public function feedback_historical() {
        $this->request('feedback-historical');
    }

    private function request($api) {
        $response = $this->client->post($this->config['base_uri'] . $api,  [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'api_key' => $this->config['api_key']
            ]
        ]);

        print_r($response);
    }
}
?>