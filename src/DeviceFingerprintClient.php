<?php

namespace Bayonet;


class DeviceFingerprintClient extends BayonetClient {

  public function __construct(array $config = []) {
    parent::__construct($config);
  }

  public function get_fingerprint_data(array $params = []) {
    ApiHelper::request('fingerprinting', 'get-fingerprint-data', $params, $this->config);
  }
}