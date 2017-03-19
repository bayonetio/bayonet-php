<?php

use Bayonet\BayonetClient;

final class ConsultingTest extends PHPUnit_Framework_TestCase {
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

		$bayonet->consulting([
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

	public function testShouldReturnFeedbackApiTransCode() {
		$fixtures = $this->getFixures();
		$bayonet = $this->initializeBayonetClient(getenv('BAYONET_API_KEY'));

		$bayonet->consulting([
			'body' => $fixtures['consulting'],
			'on_success' => function($response) {
				$this->assertEquals($response->reason_code, 00);
				$this->assertObjectHasAttribute(
					'feedback_api_trans_code', $response);
			},
			'on_failure' => function($response) {
				$this->assertEquals(true, false);
			}
		]);

		$this->assertInstanceOf(BayonetClient::class, $bayonet);
	}
}

?>