<?php

namespace Bayonet;

class EcommerceClient extends BayonetClient {

  public function __construct(array $config = []) {
    parent::__construct($config);
  }

  public function consult(array $params = []) {
    ApiHelper::request('ecommerce', 'consult', $params, $this->config);
  }

  public function update_transaction(array $params = []) {
    ApiHelper::request('ecommerce', 'update-transaction', $params, $this->config);
  }

  public function feedback_historical(array $params = []) {
    ApiHelper::request('ecommerce', 'feedback-historical', $params, $this->config);
  }
}