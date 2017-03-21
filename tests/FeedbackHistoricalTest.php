<?php

use Bayonet\BayonetClient;

final class FeedbackHistoricalTest extends PHPUnit_Framework_TestCase {
	private function initializeBayonetClient($api_key) {
		return new BayonetClient([
		    'api_key' => $api_key,
		    'version' => 1
		]);
	}

	private function getFixures() {
		$str = file_get_contents(__DIR__ . '/fixtures/requests.json');
		return json_decode($str, true);
	}

	public function testShouldValidateApiKey() {
		$fixtures = $this->getFixures();
		$bayonet = $this->initializeBayonetClient($fixtures['invalid_token']);

		$bayonet->feedback([
			'body' => [],
			'on_success' => function($response) {
				$this->assertEquals(true, false);
			},
			'on_failure' => function($response) {
				$this->assertEquals($response->reason_code, 11);
			}
		]);

		$this->assertInstanceOf(BayonetClient::class, $bayonet);
	}

	public function testAcceptTransactionIdFromFeedbackApi() {
		$fixtures = $this->getFixures();
		$bayonet = $this->initializeBayonetClient(getenv('BAYONET_API_KEY'));
		$self = $this;

		$bayonet->consulting([
			'body' => $fixtures['consulting'],
			'on_success' => function($response) use ($self, $bayonet, $fixtures) {
				$f = $fixtures['feedback'];
				$f['transaction_id'] = (string) rand();
				$f['feedback_api_trans_code'] = $response->feedback_api_trans_code;

				$bayonet->feedback([
					'body' => $f,
					'on_success' => function($f_response) use ($self, $bayonet, $fixtures, $f)  {
						$fh = $fixtures['feedback_historical'];
						$fh['transaction_id'] = $f['transaction_id'];

						$bayonet->feedback_historical([
							'body' => $fh,
							'on_success' => function($fh_response) use ($self, $f, $fh) {
								$self->assertEquals($fh_response->reason_code, 00);
								$self->assertEquals($fh['transaction_id'], $f['transaction_id']);
							},
							'on_failure' => function($fh_response) use ($self) {
								$self->assertEquals(true, false);
							}
						]);

						$self->assertEquals($f_response->reason_code, 00);
					},
					'on_failure' => function($f_response) use ($self, $bayonet, $fixtures) {
						$self->assertEquals(true, false);
					}
				]);
			},
			'on_failure' => function($response) use ($self, $bayonet, $fixtures) {
				$self->assertEquals(true, false);
			}
		]);

		$this->assertInstanceOf(BayonetClient::class, $bayonet);
	}



	public function testAcceptAnyTransactionId() {
		$fixtures = $this->getFixures();
		$bayonet = $this->initializeBayonetClient(getenv('BAYONET_API_KEY'));
		$self = $this;

		$fh = $fixtures['feedback_historical'];
		$fh['transaction_id'] = (string) rand();

		$bayonet->feedback_historical([
			'body' => $fh,
			'on_success' => function($fh_response) use($self) {
				$self->assertEquals($fh_response->reason_code, 00);
			},
			'on_failure' => function($fh_response) use($self) {
				$self->assertEquals(true, false);
			}
		]);

		$this->assertInstanceOf(BayonetClient::class, $bayonet);
	}
}

?>