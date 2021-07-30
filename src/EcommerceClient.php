<?php

namespace Bayonet;

class EcommerceClient extends BayonetClient
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function consult(array $params = [])
    {
        ApiHelper::request('ecommerce', 'consult', $params, $this->config);
    }

    public function update_transaction(array $params = [])
    {
        ApiHelper::request('ecommerce', 'update-transaction', $params, $this->config);
    }

    public function feedback_historical(array $params = [])
    {
        ApiHelper::request('ecommerce', 'feedback-historical', $params, $this->config);
    }

    public function add_to_blocklist(array $params = [])
    {
        ApiHelper::request('ecommerce', 'labels/block/add', $params, $this->config);
    }

    public function remove_from_blocklist(array $params = [])
    {
        ApiHelper::request('ecommerce', 'labels/block/remove', $params, $this->config);
    }

    public function add_to_whitelist(array $params = [])
    {
        ApiHelper::request('ecommerce', 'labels/whitelist/add', $params, $this->config);
    }

    public function remove_from_whitelist(array $params = [])
    {
        ApiHelper::request('ecommerce', 'labels/whitelist/remove', $params, $this->config);
    }
}
