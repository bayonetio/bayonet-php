<?php

namespace Bayonet;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ApiHelper {

  public static function request($api, $endpoint, array $params = [], array $config = []) {

    if(!isset($params['body']))
      $params['body'] = [];

    $params['body']['api_key'] = $config['api_key'];

    $base_uri = $config['base_uri'];
    if($api == "fingerprinting")
      $base_uri = $config['base_uri_fingerprinting'];
    if($api == "lending")
      $base_uri = $base_uri . 'lending/';
    if($api == "ecommerce")
      $base_uri = $base_uri . 'sigma/';

    try {
      $client = new Client();
      $response = $client->post($base_uri . $endpoint,  [
        'headers' => [
          'Content-Type' => 'application/json'
        ],
        'json' => $params['body']
      ]);

      if(isset($params['on_success'])) {
        $params['on_success'](
          json_decode(
            $response->getBody()
          )
        );
      }
    } catch(\Exception $e) {
      if(isset($params['on_failure'])) {
        $params['on_failure'](
          json_decode(
            $e->getResponse()->getBody()->getContents()
          )
        );
      } else {
        // let the client know the request was not successful
        throw $e;
      }
    }
  }

}