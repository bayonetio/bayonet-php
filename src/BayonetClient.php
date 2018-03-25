<?php

namespace Bayonet;

class BayonetClient {

    protected $client;
    protected $config;
    protected $supported_versions = [2];

    public function __construct(array $config = []) {
        if(!isset($config['api_key'])) {
            $config['api_key'] = getenv('BAYONET_API_KEY');
        }

        if(!isset($config['version'])) {
            throw new \Exception('You need to specify a Bayonet API version');
        }
        else if(!in_array($config['version'], $this->supported_versions)) {
          throw new \Exception('The specified version is not supported');
        }

        $this->config = $config;
        $this->config['base_uri'] = 'https://api.bayonet.io/v' . $this->config['version'] . '/';
        $this->config['base_uri_fingerprinting'] = 'https://fingerprinting.bayonet.io/v1/';
    }

    public function getConfig() {
        return $this->config;
    }
}
?>