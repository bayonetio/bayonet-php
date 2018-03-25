<?php

use Bayonet\EcommerceClient;

class EcommerceTest extends PHPUnit_Framework_TestCase {

  private $bayonet_client;
  private $bayonet_client_invalid;
  private $fixtures;

  public function setUp() {
    $this->fixtures = $this->getFixures();
    $this->bayonet_client_invalid = $this->initializeClient($this->fixtures['invalid_api_key']);
    $this->bayonet_client = $this->initializeClient(getenv('BAYONET_API_KEY'));
  }

  private function initializeClient($api_key) {
    return new EcommerceClient([
      'api_key' => $api_key,
      'version' => 2
    ]);
  }

  private function getFixures() {
    $str = file_get_contents(__DIR__ . '/../fixtures/ecommerce.json');
    return json_decode($str, true);
  }

  public function testConsultShouldValidateApiKey() {
    $this->bayonet_client_invalid->consult([
      'body' => [],
      'on_success' => function($response) {
        $this->assertEquals(true, false);
      },
      'on_failure' => function($response) {
        $this->assertEquals($response->reason_code, 12);
      }
    ]);
  }

  public function testUpdateTransactionShouldValidateApiKey() {
    $this->bayonet_client_invalid->update_transaction([
      'body' => [],
      'on_success' => function($response) {
        $this->assertEquals(true, false);
      },
      'on_failure' => function($response) {
        $this->assertEquals($response->reason_code, 12);
      }
    ]);
  }

  public function testFeedbackHistoricalShouldValidateApiKey() {
    $this->bayonet_client_invalid->feedback_historical([
      'body' => [],
      'on_success' => function($response) {
        $this->assertEquals(true, false);
      },
      'on_failure' => function($response) {
        $this->assertEquals($response->reason_code, 12);
      }
    ]);
  }

  public function testSuccessfulConsult() {
    $this->bayonet_client->consult([
      'body' => $this->fixtures['consult'],
      'on_success' => function($response) {
        $this->assertEquals($response->reason_code, 0);
        $this->assertObjectHasAttribute(
          'bayonet_tracking_id', $response);
      },
      'on_failure' => function($response) {
        fwrite(STDERR, print_r($response, TRUE));
        $this->assertEquals(true, false);
      }
    ]);
  }

  public function testSuccessfulUpdateTransaction() {
    $this->bayonet_client->update_transaction([
      'body' => $this->fixtures['update_transaction'],
      'on_success' => function($response) {
        $this->assertEquals($response->reason_code, 0);
      },
      'on_failure' => function($response) {
        fwrite(STDERR, print_r($response, TRUE));
        $this->assertEquals(true, false);
      }
    ]);
  }

  public function testSuccessfulFeedbackHistorical() {
    $json = $this->fixtures['feedback_historical'];
    # set random transaction ID
    $json['transaction_id'] = (string) rand();
    $this->bayonet_client->feedback_historical([
      'body' => $json,
      'on_success' => function($response) {
        $this->assertEquals($response->reason_code, 0);
      },
      'on_failure' => function($response) {
        fwrite(STDERR, print_r($response, TRUE));
        $this->assertEquals(true, false);
      }
    ]);
  }
}

?>