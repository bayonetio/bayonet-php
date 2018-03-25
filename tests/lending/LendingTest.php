<?php

use Bayonet\LendingClient;

class LendingTest extends PHPUnit_Framework_TestCase {

  private $bayonet_client;
  private $bayonet_client_invalid;
  private $fixtures;
  private $transaction_id;

  public function setUp() {
    $this->fixtures = $this->getFixures();
    $this->bayonet_client_invalid = $this->initializeClient($this->fixtures['invalid_api_key']);
    $this->bayonet_client = $this->initializeClient(getenv('BAYONET_API_KEY'));
    $this->transaction_id = (string) rand();
  }

  private function initializeClient($api_key) {
    return new LendingClient([
      'api_key' => $api_key,
      'version' => 2
    ]);
  }

  private function getFixures() {
    $str = file_get_contents(__DIR__ . '/../fixtures/lending.json');
    return json_decode($str, true);
  }

//  public function testReportTransactionShouldValidateApiKey() {
//    $this->bayonet_client_invalid->report_transaction([
//      'body' => [],
//      'on_success' => function($response) {
//        $this->assertEquals(true, false);
//      },
//      'on_failure' => function($response) {
//        $this->assertEquals($response->reason_code, 12);
//      }
//    ]);
//  }
//
//  public function testReportTransactionAndConsultShouldValidateApiKey() {
//    $this->bayonet_client_invalid->report_transaction_and_consult([
//      'body' => [],
//      'on_success' => function($response) {
//        $this->assertEquals(true, false);
//      },
//      'on_failure' => function($response) {
//        $this->assertEquals($response->reason_code, 12);
//      }
//    ]);
//  }
//
//  public function testConsultShouldValidateApiKey() {
//    $this->bayonet_client_invalid->consult([
//      'body' => [],
//      'on_success' => function($response) {
//        $this->assertEquals(true, false);
//      },
//      'on_failure' => function($response) {
//        $this->assertEquals($response->reason_code, 12);
//      }
//    ]);
//  }
//
//  public function testFeedbackShouldValidateApiKey() {
//    $this->bayonet_client_invalid->feedback([
//      'body' => [],
//      'on_success' => function($response) {
//        $this->assertEquals(true, false);
//      },
//      'on_failure' => function($response) {
//        $this->assertEquals($response->reason_code, 12);
//      }
//    ]);
//  }
//
//  public function testFeedbackHistoricalShouldValidateApiKey() {
//    $this->bayonet_client_invalid->feedback_historical([
//      'body' => [],
//      'on_success' => function($response) {
//        $this->assertEquals(true, false);
//      },
//      'on_failure' => function($response) {
//        $this->assertEquals($response->reason_code, 12);
//      }
//    ]);
//  }

  public function testSuccessfulReportTransaction() {
    $json = $this->fixtures['report_transaction'];
    $json['transaction_id'] = $this->transaction_id;
    fwrite(STDERR, print_r($json['transaction_id'], TRUE));
    $this->bayonet_client->report_transaction([
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

  public function testSuccessfulConsult() {
    $json = $this->fixtures['consult'];
    $json['transaction_id'] = $this->transaction_id;
    fwrite(STDERR, print_r($json['transaction_id'], TRUE));
    $this->bayonet_client->consult([
      'body' => $json,
      'on_success' => function($response) {
        $this->assertEquals($response->reason_code, 0);
        $this->assertObjectHasAttribute(
          'payload', $response);
      },
      'on_failure' => function($response) {
        fwrite(STDERR, print_r($response, TRUE));
        $this->assertEquals(true, false);
      }
    ]);
  }

  public function testSuccessfulReportTransactionAndConsult() {
    $json = $this->fixtures['report_transaction'];
    $json['transaction_id'] = (string) rand();
    $this->bayonet_client->report_transaction_and_consult([
      'body' => $json,
      'on_success' => function($response) {
        $this->assertEquals($response->reason_code, 0);
        $this->assertObjectHasAttribute(
          'payload', $response);
      },
      'on_failure' => function($response) {
        fwrite(STDERR, print_r($response, TRUE));
        $this->assertEquals(true, false);
      }
    ]);
  }

  public function testSuccessfulFeedback() {
    $json = $this->fixtures['feedback'];
    $json['transaction_id'] = $this->transaction_id;
    fwrite(STDERR, print_r($json['transaction_id'], TRUE));
    $this->bayonet_client->feedback([
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