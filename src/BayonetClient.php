<?php

namespace Bayonet;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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

    public function getConfig() {
        return $this->config;
    }

    public function consulting(array $config = []) {
        $this->request('consulting', $config);
    }

    public function feedback(array $config = []) {
        $this->request('feedback', $config);
    }

    public function feedback_historical(array $config = []) {
        $this->request('feedback-historical', $config);
    }

    private function request($api, array $config = []) {
        if(!isset($config['body']))
            $config['body'] = [];

        $config['body']['api_key'] = $this->config['api_key'];

        try {
            $response = $this->client->post($this->config['base_uri'] . $api,  [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => $config['body']
            ]);

            if(isset($config['on_success'])) {
                $config['on_success'](
                    json_decode(
                        $response->getBody()
                    )
                );
            }
        } catch(\Exception $e) {
            if(isset($config['on_failure'])) {
                $config['on_failure'](
                    json_decode(
                        $e->getResponse()->getBody()->getContents()
                    )
                );
            } else {
                // let the client know the request wasnt successful
                throw $e;
            }
        }
    }
}
?>