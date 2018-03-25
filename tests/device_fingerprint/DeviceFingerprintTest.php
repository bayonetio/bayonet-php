<?php

use Bayonet\DeviceFingerprint;

final class DeviceFingerprintTest extends PHPUnit_Framework_TestCase {

  private $bayonet_client;
  private $bayonet_client_invalid;
  private $fixtures;

  public function setUp() {
    $this->fixtures = $this->getFixures();
    $this->bayonet_client_invalid = $this->initializeClient($this->fixtures['invalid_api_key']);
    $this->bayonet_client = $this->initializeClient(getenv('BAYONET_API_KEY'));
  }

  private function initializeClient($api_key) {
    return new DeviceFingerprint([
      'api_key' => $api_key,
      'version' => 2
    ]);
  }

  private function getFixures() {
    $str = file_get_contents(__DIR__ . '/../fixtures/device_fingerprint.json.json');
    return json_decode($str, true);
  }

  public function testShouldValidateApiKey() {
    $this->bayonet_client_invalid->get_fingerprint_data([
      'body' => $this->fixtures['get_fingerprint_data'],
      'on_success' => function($response) {
        fwrite(STDERR, print_r($response, TRUE));
        $this->assertEquals(true, false);
      },
      'on_failure' => function($response) {
        $this->assertEquals($response->status, "Error : Invalid API key");
      }
    ]);
  }

  public function testValidateBayonetFingerprintToken() {
    $this->bayonet_client->get_fingerprint_data([
      'body' => $this->fixtures['get_fingerprint_data'],
      'on_success' => function($response) {
        fwrite(STDERR, print_r($response, TRUE));
      },
      'on_failure' => function($response) {
        $this->assertEquals($response->status, "Error: Invalid value for bayonet_fingerprint_token");
      }
    ]);
  }
}