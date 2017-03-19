<?php

use Bayonet\BayonetClient;

final class BayonetTest extends PHPUnit_Framework_TestCase {
	public function testBayonetClient() {
		return new BayonetClient([
		    'api_key' => getenv('BAYONET_API_KEY'),
		    'version' => 1
		]);

		$this->assertInstanceOf(BayonetClient::class, $bayonet);
	}

	public function testApiVersionIsMandatory() {
		$this->setExpectedException(Exception::class);

		$bayonet = new BayonetClient([
		    'api_key' => 'your_api_key'
		]);
	}

	public function testSetApiKey() {
		$api_key = 'your_api_key';
		$bayonet = new BayonetClient([
		    'api_key' => $api_key,
		    'version' => 1
		]);

		$this->assertEquals($api_key, $bayonet->getConfig()['api_key']);
	}
}

?>