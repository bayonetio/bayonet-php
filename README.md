[![Latest Stable Version](https://poser.pugx.org/bayonet/bayonet-php/v/stable)](https://packagist.org/packages/bayonet/bayonet-php)
[![License](https://poser.pugx.org/bayonet/bayonet-php/license)](https://packagist.org/packages/bayonet/bayonet-php)

## Bayonet
Bayonet enables companies to feed and consult a global database about online consumers’ reputation, based on historic payments. Start making smarter business decisions today.

### Introduction
Bayonet’s API is organized around REST and exposes endpoints for HTTP requests. It is designed to have predictable, resource-oriented URLs and uses standard HTTP response codes to indicate the outcome of operations. Request and response payloads are formatted as JSON.

### About the service
Bayonet provides an Ecosystem of Trust and Protection where companies can colaborate with each other to combat online fraud together. We provide a secure platform to share and consult data to understand when a consumer is related to fraudulent activity or has a fraud-free record. Different technologies that run algorithms to link parameters seen in different transactions, fed by companies connected to the ecosystem are employed in order to build consumer profiles. By consulting Bayonet’s API, a response with data provided by companies themselves is available in real-time for your risk assesment process to analyze it and take better decisions.

### Bayonet's API details
To know more about Bayonet's API and its domain and technical details, please see the "Integration Specs V 1.0" document provided by the Bayonet team.

## Getting started
### Requirements
To use this SDK, please make sure:
  * You have PHP 5.4 or superior installed on your system.
  * You have an API KEY (sandbox and/or live) provided by Bayonet's team.
  
### Composer
1. Add dependency 'bayonet-php' in your composer.json file
  
    ```
    "require": {
        ...
        "bayonet/bayonet-php": "1.0.*"
        ...
    }
    ```
   Run composer to get the dependencies
  
    ```sh
    composer update
    ```
2. Import the Bayonet SDK

    ```php
    require __DIR__ . '/../vendor/autoload.php';
    use Bayonet\BayonetClient;
    ```
3. Create config options, with parameters (api_key)

    ```php
    $bayonet = new BayonetClient([
        'api_key' => 'your_api_key',
        'version' => 1
    ]);
    ```
    You can use environment vars too.

    ```sh
    export BAYONET_API_KEY=your_api_key
    ```
    
### Manual Installation
1. If you do not use Composer, download the [latest release](https://github.com/Bayonet-Client/bayonet-php/releases). Extract into your project root into a folder named "bayonet-php". Include BayonetClient in your project

    ```php
    require 'bayonet-php/src/BayonetClient.php';
    use Bayonet\BayonetClient;
    ```
2. BayonetClient uses [Guzzle](https://github.com/guzzle/guzzle) as dependency. Make sure you download and include Guzzle into your project

    ```php
    require 'guzzle/autoloader.php';
    ```
   If you use Composer, the above dependency will be handled automatically. If you choose manual installation, you will need to make sure that the dependecy is available.

3. Once you have BayonetClient set up, create config options, with parameters (api_key)

    ```php
    $bayonet = new BayonetClient([
    'api_key' => 'your_api_key',
    'version' => 1
    ]);
    ```
   You can use environment vars too

    ```sh
    export BAYONET_API_KEY=your_api_key
    ``` 

## Usage
Once you have Bayonet's SDK configured, you can call the three APIs with the following syntax:
  * Consulting API
  
    ```php
    $bayonet->consulting([
        'body' => [
            'channel' => 'mpos',
            'email' => 'luisehk@gmail.com',
            'consumer_name' => 'Luis Herrada',
            'cardholder_name' => 'Luis Herrada',
            'payment_method' => 'card',
            'card_number' => 4111111111111111,
            'transaction_amount' => 320,
            'currency_code' => 'MXN',
            'transaction_time' => 1476012879,
            'coupon' => false,
            'payment_gateway' => 'stripe',
            'shipping_address' => [
                'address_line_1' => 'Calle 123',
                'address_line_2' => '456',
                'city' => 'Monterrey',
                'state' => 'Nuevo León',
                'country' => 'MX',
                'zip_code' => '64000'
            ]
        ],
        'on_success' => function($response) {
            print_r($response);
        },
        'on_failure' => function($response) {
            print_r($response);
        }
    ]);
    ```
  * Feedback API
  
    ```php
    $bayonet->feedback([
        'body' => [
            'transaction_status' => 'bank_decline',
            'transaction_id' => 'test_php',
            'feedback_api_trans_code' => 'xxx'
        ],
        'on_success' => function($response) {
            print_r($response);
        },
        'on_failure' => function($response) {
            print_r($response);
        }
    ]);
    ```
  * Feedback-historical API
  
    ```php
    $bayonet->feedback_historical([
        'body' => [
            'channel' => 'mpos',
            'type' => 'transaction',
            'email' => 'david@gmail.com',
            'consumer_name' => 'David Gilmour',
            'payment_method' => 'card',
            'card_number' => 4929699022445935,
            'transaction_amount' => 500,
            'currency_code' => 'USD',
            'transaction_time' => 1423823404,
            'transaction_status' => 'bank_decline',
            'transaction_id' => 'uhffytd65rds56yt',
            'coupon' => false,
            'payment_gateway' => 'stripe',
            'device_fingerprint' => 'AF567GHGJJJ87JH',
            'bank_auth_code' => '5353888',
            'telephone' => '5566768423',
            'expedited_shipping' => false,
            'bank_decline_reason' => 'stolen_card',
            'shipping_address' => [
                'address_line_1' => '8100 Sunset Boulevard',
                'address_line_2' => 'Apt 6B',
                'city' => 'San Francisco',
                'state' => 'Sunnyvale',
                'country' => 'USA',
                'zip_code' => '03257'
            ]
        ],
        'on_success' => function($response) {
            print_r($response);
        },
        'on_failure' => function($response) {
            print_r($response);
        }
    ]);
    ```
 
## Success and error handling
Bayonet's SDK supports callbacks  for success and error handling
```php
<?php
// fixtures
$fx = json_decode(file_get_contents(__DIR__ . '/fixtures/requests.json'), true);

// make the request
$bayonet->consulting([
    'body' => $fx['consulting'],
    'on_success' => function($response) {
        print_r($response);
    },
    'on_failure' => function($response) {
        print_r($response);
    }
]);
?>
```

For a full list of error codes and their messages, please see the "Integration Specs V 1.0" document provided by the Bayonet team.

## Demo
You can run a demo application with this command:
```sh
cd demo && php -S localhost:8000
```

## Testing
You can run the test suite with the following command:
```sh
echo Hello
```
