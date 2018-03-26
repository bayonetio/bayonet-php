[![Latest Stable Version](https://poser.pugx.org/bayonet/bayonet-php/v/stable)](https://packagist.org/packages/bayonet/bayonet-php)
[![License](https://poser.pugx.org/bayonet/bayonet-php/license)](https://packagist.org/packages/bayonet/bayonet-php)

## Bayonet
Bayonet enables companies to feed and consult a global database about online consumers’ reputation, based on historic payments. Start making smarter business decisions today.

### Introduction
Bayonet’s API is organized around REST and exposes endpoints for HTTP requests. It is designed to have predictable, resource-oriented URLs and uses standard HTTP response codes to indicate the outcome of operations. Request and response payloads are formatted as JSON.

### About the service
Bayonet provides an Ecosystem of Trust and Protection where companies can collaborate with each other to combat online fraud together. We provide a secure platform to share and consult data to understand when a consumer is related to fraudulent activity or has a fraud-free record. Different technologies that run algorithms to link parameters seen in different transactions, fed by companies connected to the ecosystem are employed in order to build consumer profiles. By consulting Bayonet’s API, a response with data provided by companies themselves is available in real-time for your risk assesment process to analyze it and take better decisions.

### Bayonet's API details
The examples shown in this README are only for demonstration of the functionality of this SDK. For the detailed integration flow, and when to send which API call, please refer to the Bayonet [API documentation](https://bayonet.io/console/docs).

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
        "bayonet/bayonet-php": "2.0.*"
        ...
    }
    ```
   Run composer to get the dependencies
  
    ```sh
    composer update
    ```
2. Load the dependencies

    ```php
    require __DIR__ . '/../vendor/autoload.php';
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
1. If you do not use Composer, download the [latest release](https://github.com/Bayonet-Client/bayonet-php/releases). Extract into your project root into a folder named "bayonet-php". Use the `init.php` file to load the Bayonet dependencies

  ```php
  require 'bayonet-php/init.php';
  ```
2. BayonetClient uses [Guzzle](https://github.com/guzzle/guzzle) as dependency. Make sure you download and include Guzzle into your project as well

  ```php
  require 'guzzle/autoloader.php';
  ```
  If you use Composer, the above dependency will be handled automatically. If you choose manual installation, you will need to make sure the dependency is available.

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
Once you have Bayonet's SDK configured, you can call the APIs with the following syntax. Follow the guidelines specific to the product you are integrating:

* [Ecommerce](#ecommerce)

* [Lending](#lending)

### Ecommerce

  * Initialize the Ecommerce client

    ```php
    $bayonet = new Bayonet\EcommerceClient([
      'api_key' => 'your_api_key',
      'version' => 2
    ]);
    ```
    You can use environment vars to load the api key too

    ```sh
    export BAYONET_API_KEY=your_api_key
    ```

  * Consult API
  
    ```php
      $bayonet->consult([
        'body' => [
          'channel' => 'ecommerce',
          'email' => 'example@bayonet.io',
          'consumer_name' => 'Example name',
          'consumer_internal_id' => '<your internal ID for this consumer>',
          'cardholder_name' => 'Example name',
          'telephone' => '1234567890',
          'card_number' => '4111111111111111',
          'transaction_amount' => 999.00,
          'currency_code' => 'MXN',
          'shipping_address' => {
            'line_1' => 'example line 1',
            'line_2' => 'example line 2',
            'city' => 'Mexico City',
            'state' => 'Mexico DF',
            'country' => 'MEX',
            'zip_code' => '64000'
          },
          'billing_address' => {
            'line_1' => 'example line 1',
            'line_2' => 'example line 2',
            'city' => 'Mexico City',
            'state' => 'Mexico DF',
            'country' => 'MEX',
            'zip_code' => '64000'
          },
          'payment_method' => 'card',
          'order_id' => '<your internal ID for this order>',
          'transaction_id' => '<your internal ID for this transaction>',
          'payment_gateway' => 'stripe',
          'coupon' => 'discount_buen_fin',
          'expedited_shipping' => true,
          'products' => [
            {
              'product_id' => '1',
              'product_name' => 'product_1',
              'product_price' => 500.00,
              'product_category' =>'example category'
            },
            {
              'product_id' => '2',
              'product_name' => 'product_2',
              'product_price' => 499.00,
              'product_category' =>'example category'
            }
          ],
          'bayonet_fingerprint_token' => '<token generated by Bayonet fingerprinting JS>'
        ],
      'on_success' => function($response) {
        print_r($response);
      },
      'on_failure' => function($response) {
        print_r($response);
      }
    ]);
    ```
  * Update Transaction API
  
    ```php
    $bayonet->update_transaction([
      'body' => [
        'transaction_status' => 'success',
        'transaction_id' => '<your internal ID for this transaction (as sent in the consult step)>',
        ...
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
        'channel' => 'ecommerce',
        'email' => 'example@bayonet.io',
        'consumer_name' => 'Example name',
        'consumer_internal_id' => '<your internal ID for this consumer>',
        'cardholder_name' => 'Example name',
        'telephone' => '1234567890',
        'card_number' => '4111111111111111',
        'transaction_amount' => 999.00,
        'currency_code' => 'MXN',
        'shipping_address' => {
          'line_1' => 'example line 1',
          'line_2' => 'example line 2',
          'city' => 'Mexico City',
          'state' => 'Mexico DF',
          'country' => 'MEX',
          'zip_code' => '64000'
        },
        'billing_address' => {
          'line_1' => 'example line 1',
          'line_2' => 'example line 2',
          'city' => 'Mexico City',
          'state' => 'Mexico DF',
          'country' => 'MEX',
          'zip_code' => '64000'
        },
        'payment_method' => 'card',
        'order_id' => '<your internal ID for this order>',
        'transaction_id' => '<your internal ID for this transaction>',
        'payment_gateway' => 'stripe',
        'coupon' => 'discount_buen_fin',
        'expedited_shipping' => true,
        'products' => [
          {
            'product_id' => '1',
            'product_name' => 'product_1',
            'product_price' => 500.00,
            'product_category' =>'example category'
          },
          {
            'product_id' => '2',
            'product_name' => 'product_2',
            'product_price' => 499.00,
            'product_category' =>'example category'
          }
        ],
        'bayonet_fingerprint_token' => '<token generated by Bayonet fingerprinting JS>',
        'transaction_status' => 'success',
      ],
      'on_success' => function($response) {
          print_r($response);
      },
      'on_failure' => function($response) {
          print_r($response);
      }
    ]);
    ```
    
    
  * Get-fingerprint-data API
  
    ```php
    $bayonet->get_fingerprint_data([
        'body' => [
            'bayonet_fingerprint_token' => 'fingerprint-token-generated-by-JS-snipppet'
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
./vendor/bin/phpunit --bootstrap src/BayonetClient.php --testdox tests
```
