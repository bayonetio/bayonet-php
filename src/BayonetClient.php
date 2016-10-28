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

    public function consulting($body = []) {
        $this->request('consulting', $body);
    }

    public function feedback($body = []) {
        $this->request('feedback', $body);
    }

    public function feedback_historical($body = []) {
        $this->request('feedback-historical', $body);
    }

    private function request($api, $body = []) {
        $body['api_key'] = $this->config['api_key'];

        $response = $this->client->post($this->config['base_uri'] . $api,  [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'json' => $body
        ]);

        print_r($response);
    }
}
?>