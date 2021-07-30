<?php

namespace Bayonet;

class BayonetClient
{
    protected $client;
    protected $config;

    public function __construct(array $config = [])
    {
        if (!isset($config['api_key'])) {
            $config['api_key'] = getenv('BAYONET_API_KEY');
        }

        $this->config = $config;
        $this->config['base_uri'] = 'https://api.bayonet.io/v2/';
    }

    public function getConfig()
    {
        return $this->config;
    }
}
