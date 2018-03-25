<?php

namespace Bayonet;

class Lending extends BayonetClient {

  public function __construct(array $config = []) {
    parent::__construct($config);
  }

  public function report_transaction(array $params = []) {
    ApiHelper::request('lending', 'transaction/report', $params, $this->config);
  }

  public function report_transaction_and_consult(array $params = []) {
    ApiHelper::request('lending', 'transaction/report?consult=true', $params, $this->config);
  }

  public function consult(array $params = []) {
    ApiHelper::request('lending', 'consult', $params, $this->config);
  }

  public function feedback(array $params = []) {
    ApiHelper::request('lending', 'feedback', $params, $this->config);
  }

  public function feedback_historical(array $params = []) {
    ApiHelper::request('lending', 'feedback-historical', $params, $this->config);
  }
}