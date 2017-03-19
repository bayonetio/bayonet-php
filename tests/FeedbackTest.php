<?php

use Bayonet\BayonetClient;

final class FeedbackTest extends PHPUnit_Framework_TestCase {
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

	public function testValidateFeedbackApiTransCode() {
		$fixtures = $this->getFixures();
		$bayonet = $this->initializeBayonetClient(getenv('BAYONET_API_KEY'));

		$bayonet->feedback([
			'body' => $fixtures['feedback'],
			'on_success' => function($response) {
				$this->assertEquals(true, false);
			},
			'on_failure' => function($response) {
				$this->assertEquals($response->reason_code, 87);
			}
		]);

		$this->assertInstanceOf(BayonetClient::class, $bayonet);
	}

	public function testAcceptFeedbackApiTransCode() {
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
					'on_success' => function($f_response) use ($self, $bayonet, $fixtures)  {
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
}

?>